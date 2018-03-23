<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\components\AccessControlExtend;
use yii\helpers\Json;

use app\models\EntVendedores;
use app\models\catRoles;
use app\models\MessageResponse;
use app\models\LoginResponse;
use app\models\EntClientes;
use app\models\RelVendedoresClientes;
use app\models\ListResponse;
use app\models\CatProductosGenericos;
use app\models\CatMarcasProductos;
use app\models\CatCategoriasProductos;
use app\models\EntProductos;
use app\models\CatGruposProductos;
use app\models\VClientesByVendedor;
use app\models\WrkVentas;
use app\models\RelVentaVendedor;
use app\models\RelVentaProducto;
use app\models\WrkCitas;
use app\models\WrkVendedoresDisponibilidades;
use app\models\VDisponibilidadesVendedoresCitas;
use app\models\WrkVendedoresSesiones;

class ServicesController extends \yii\rest\Controller
{

    public $enableCsrfValidation = false;
    public $layout = null;

    const ERROR_TOKEN = -1100;
    const SESION_USUARIO_INVALIDA = -1100;
    const SESION_USUARIO_CADUCA = -1200;

    const ERROR_CREAR_CITA = -23;
    const ERROR_LOGIN = -100;

    const SESION_DURACION_MINUTOS = 1800; //Segundos 



    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
            ],
        ];
        return $behaviors;
    }

    public function init()
    {
        parent::init();        
        date_default_timezone_set('America/Mexico_City');
      }

    
    public function beforeAction($action)
    {
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl

        if (!parent::beforeAction($action)) {
            return false;
        }
        //Pone el header de cerrar la conexión
        $headers = Yii::$app->response->headers;
        $headers->set('Connection', 'close');

        //echo($action->id);
        //return false;
        // $headers is an object of yii\web\HeaderCollection 
        if($action->id != 'login'){
            $headers = Yii::$app->request->headers;
            // returns the Accept header value
            $auth = $headers->get('Authentication-Token');

            $wrkSesion = WrkVendedoresSesiones::find()->where(['txt_token'=>$auth])->one();
            

            //1 Si no existe la sesion lo manda a volar
            if(!$wrkSesion){
                $error = new MessageResponse();
                $error->responseCode = self::SESION_USUARIO_INVALIDA;
                $error->message = 'Sesion del usuario invalida';
                echo(\json_encode( $error) );
                return false;
            }

            
            
            //2 verifica el tiempo de la sesion, si han pasado más de X minutos
            if(\strtotime('now') - \strtotime($wrkSesion->fch_actualizacion) > self::SESION_DURACION_MINUTOS){
                $error = new MessageResponse();
                $error->responseCode = self::SESION_USUARIO_CADUCA;
                $error->message = 'Sesion del usuario caducada';
                echo(\json_encode( $error) );
                return false;
            }

            $wrkSesion->fch_actualizacion = date('Y-m-d H:i:s', time());
            $wrkSesion->save();

        }
        return true; // or false to not run the action
    }

    /**
     * Permite el acceso al usuario
     */
    public function actionLogin(){
        if(!isset($GLOBALS["HTTP_RAW_POST_DATA"])){
            $error = new MessageResponse();
            $error->responseCode = -1;
            $error->message = 'Body de la petición faltante';
            return $error;
        }

        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );

        if(!isset($json->username)){
            $error = new MessageResponse();
            $error->responseCode = -1;
            $error->message = 'nombre usuario faltante';
            return $error;
        }

        if(!isset($json->password)){
            $error = new MessageResponse();
            $error->responseCode = -1;
            $error->message = 'password usuario faltante';
            return $error;
        }

        //verifica que los parámetros solicitados se encuentren
        $username = $json->username;
        $password = $json->password;

        $usuario = EntVendedores::find()->where([
            'txt_nombre_usuario'=>$username,
            'txt_contrasena'=>$password, 
            'b_activo'=>1])->one();


        if($usuario){
            $usuario->txt_contrasena = "";
            $usuario->id_rol = $usuario->idRol;
            $usuario->id_tienda = $usuario->idTienda;

            //Sesion del usuario
            $sesionId = uniqid($usuario->txt_nombre_usuario . '-');
            $wrkSesion = WrkVendedoresSesiones::find()->where(['id_vendedor'=>$usuario->id_vendedor])->one();

            if(!$wrkSesion){
                $wrkSesion = new WrkVendedoresSesiones();
                $wrkSesion->id_vendedor = $usuario->id_vendedor;
            }

            //Crea o Actualiza el token de la sesion
            $wrkSesion->txt_token = $sesionId;
            $wrkSesion->save();


            //----Header de seguridad ----
            $headers = Yii::$app->response->headers;
            // add a Authentication-Token header.
            $headers->add('Authentication-Token', $sesionId);

            $response = new MessageResponse();
            $response->responseCode = 0;
            $response->message = 'Usuario correcto';
            $response->data = $usuario;

            return $response;
        }else{
            $error = new MessageResponse();
            $error->responseCode = self::ERROR_LOGIN;
            $error->message = 'Usuario incorrecto';
            return $error;
        }
    }


    //-------------------------------- AGREGAR DATOS -------------------------------------------------------------------------

    

    /**
     * Agrega una nueva cita al calendario de un vendedor
     */
    public function actionAddCita(){
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );
        $error = new MessageResponse();
        
        if(!$this->validateRequiredParam($error,isset($json->token), "Token de vendedor" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->cliente_uddi), "Token de cliente" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->fecha), "Fecha de la cita" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->hora), "Hora de la cita" )){
            return $error;
        }

        

        //-------------- Inicia proceso 

        $cliente = $this->getClienteByToken($json->cliente_uddi); 
        $vendedor = $this->getVendedorByToken($json->token);

        $cita = new WrkCitas();

        $cita->id_vendedor = $vendedor->id_vendedor;
        $cita->id_cliente = $cliente->id_cliente;
        $cita->fch_cita = $json->fecha;
        $cita->num_hora_cita = $json->hora;
        $cita->b_confirmada = 0;
        $cita->b_cubierta = 0;
        $cita->b_habilitada = 1;
        $cita->uddi = uniqid();
        
        $date = new \DateTime($cita->fch_cita);
        $week = $date->format("W");
        $cita->num_semana = $week;

        $cita->save();

        
        //En caso de existir uno o más errores
        if( count($cita->errors) > 0){
            //Calcula los errores
            $errors = "";
            foreach($cita->errors as $item){
                $errors .=  $item[0] . ", ";
            }   

            $response = new MessageResponse();
            $response->message = "Error al generar la cita " . $errors;
            $response->responseCode = self::ERROR_CREAR_CITA;
            return $response;
        }

        $response = new MessageResponse();
        $response->message = "La cita se registro con exito " . $cita->id_cita;
        $response->responseCode = $cita->id_cita;
        return $response;
    }


    /**
     * Agrega un dia y hora para la disponibilidad del usuario
     */
    public function actionAddDisponibilidad(){
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );
        $error = new MessageResponse();
        if(!$this->validateRequiredParam($error,isset($json->token), "Token de vendedor" )){
            return $error;
        }

        $token = $json->token;
        $vendedor = $this->getVendedorByToken($token);

        if(!$vendedor){
            $error->message="No se encontro un vendedor valido";
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->dia_semana), "Día de la semana" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->hora_dia), "Hora del dia" )){
            return $error;
        }

        //Valida si se tiene el dato en la base de datos
        $disponibilidad = WrkVendedoresDisponibilidades::find()->where([
            'id_vendedor' => $vendedor->id_vendedor,
            'id_dia_semana'=>$json->dia_semana,
            'num_hora_disponible'=>$json->hora_dia
            ])->one();

        if($disponibilidad){
            $response = new MessageResponse();
            $response->message = "La disponibilidad ya se encontraba registrada";
            $response->responseCode = 1;
            return $response;     
        }    

        $disponibilidad = new WrkVendedoresDisponibilidades();
        $disponibilidad->id_vendedor = $vendedor->id_vendedor;
        $disponibilidad->id_dia_semana = $json->dia_semana;
        $disponibilidad->num_hora_disponible = $json->hora_dia;

        if($disponibilidad->save()){
            $response = new MessageResponse();
            $response->message = "La disponibilidad se registro con exito ";
            $response->responseCode = 1;
            return $response;
        }else{
            $response = new MessageResponse();
            $response->message = "Error al registrar la disponibilidad ";
            $response->responseCode = -1;
            return $response;
        }
    }


    /**
     * Remueve un dia y hora para la disponibilidad del usuario
     */
    public function actionRemoveDisponibilidad(){
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );
        $error = new MessageResponse();
        if(!$this->validateRequiredParam($error,isset($json->token), "Token de vendedor" )){
            return $error;
        }

        $token = $json->token;
        $vendedor = $this->getVendedorByToken($token);

        if(!$vendedor){
            $error->message="No se encontro un vendedor valido";
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->dia_semana), "Día de la semana" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->hora_dia), "Hora del dia" )){
            return $error;
        }

        //Valida si se tiene el dato en la base de datos
        $disponibilidad = WrkVendedoresDisponibilidades::find()->where([
            'id_vendedor' => $vendedor->id_vendedor,
            'id_dia_semana'=>$json->dia_semana,
            'num_hora_disponible'=>$json->hora_dia
            ])->one();

        if(!$disponibilidad){
            $response = new MessageResponse();
            $response->message = "La disponibilidad no se encontraba registrada";
            $response->responseCode = 1;
            return $response;     
        }    

        

        if($disponibilidad->delete()){
            $response = new MessageResponse();
            $response->message = "La disponibilidad elimino con exito ";
            $response->responseCode = 1;
            return $response;
        }else{
            $response = new MessageResponse();
            $response->message = "Error al eliminar la disponibilidad ";
            $response->responseCode = -1;
            return $response;
        }
    }

    /**
     * Agrega una venta 
     */
    public function actionAddSale(){
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );
        $error = new MessageResponse();
        if(!$this->validateRequiredParam($error,isset($json->token), "Token de vendedor" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->cliente_uddi), "Token de cliente" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->vendedores), "Vendedores" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->productos), "Productos" )){
            return $error;
        }

        //Verifica que almenos haya 1 vendedor y maximo 2
        $numVendedores =  count($json->vendedores);
        if($numVendedores<1 || $numVendedores>2){
            $error->message = "Se indicaron " . $numVendedores . " vendedores";
            $error->responseCode = -1;
            return $error;
        }

        //Valida los campos de los vendedores
        $vendedores = $json->vendedores;
        foreach($vendedores as $item){
            if(!$this->validateRequiredParam($error,isset($item->token), "token del vendedor" )){
                return $error;
            }

            if(!$this->validateRequiredParam($error,isset($item->porcentaje), "porcentaje de venta del vendedor" )){
                return $error;
            }
        }

        //Valida que almenos haya 1 producto
        $numProductos =  count($json->productos);
        if($numProductos<1 ){
            $error->message = "Se indicaron " . $numProductos . " productos";
            $error->responseCode = -1;
            return $error;
        }
        
        //Valida el contenido del json
        $productos = $json->productos;
        foreach($productos as $item){
            if(!$this->validateRequiredParam($error,isset($item->uddi), "token del producto" )){
                return $error;
            }

            if(!$this->validateRequiredParam($error,isset($item->precio), "precio del producto" )){
                return $error;
            }

            if(!$this->validateRequiredParam($error,isset($item->cantidad), "cantidad del producto" )){
                return $error;
            }
        }

        

        //-------------- Inicia proceso -------------

        $vendedor = $this->getVendedorByToken($json->token);
        $cliente = $this->getClienteByToken($json->cliente_uddi); 

        //Crea la venta
        $sale = new WrkVentas();
        $sale->id_cliente = $cliente->id_cliente;
        $sale->id_tienda = $vendedor->id_tienda;
        $sale->save();

        //Relaciona la venta con los vendedores
        $vendedores = $json->vendedores;
        foreach($vendedores as $item){
            $vendedor = $this->getVendedorByToken($item->token);
            $relVentaVendedor = new RelVentaVendedor();
            $relVentaVendedor->id_venta = $sale->id_venta;
            $relVentaVendedor->id_vendedor = $vendedor->id_vendedor;
            $relVentaVendedor->num_porcentaje = $item->porcentaje;
            $relVentaVendedor->save();
        }

        //Relaciona la venta con los productos
        $productos = $json->productos;
        foreach($productos as $item){
            $producto = $this->getProductoByToken($item->uddi);
            $relVentaProducto = new RelVentaProducto();
            $relVentaProducto->id_venta = $sale->id_venta;
            $relVentaProducto->id_producto = $producto->id_producto;
            $relVentaProducto->num_precio = $item->precio;
            $relVentaProducto->num_cantidad = $item->cantidad;
            
            $relVentaProducto->save();
        }

        $response = new MessageResponse();
        $response->message = "La venta se registro con exito " . $sale->id_venta;
        $response->responseCode = $sale->id_venta;
        return $response;
    }


    public function actionAddClient(){
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );
        $error = new MessageResponse();
        if(!$this->validateRequiredParam($error,isset($json->token), "Token de vendedor" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->nombre), "Nombre de usuario" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->correo), "Correo de usuario" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->telefono_fijo), "Telefono fijo" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->telefono_movil), "Telefono movil" )){
            return $error;
        }

        $vendedor = $this->getVendedorByToken($json->token);
        $cliente = new EntClientes();

        $cliente->uddi = uniqid();
        $cliente->txt_nombre = $json->nombre;
        $cliente->txt_correo = $json->correo;
        $cliente->txt_telefono_fijo = $json->telefono_fijo;
        $cliente->txt_telefono_movil = $json->telefono_movil;

        $cliente->b_habilitado = 1;

        $cliente->save();

        $rel = new RelVendedoresClientes();
        $rel->id_vendedor = $vendedor->id_vendedor;
        $rel->id_cliente = $cliente->id_cliente;
        $rel->b_actual = 1;

        $rel->save();

        $res = new MessageResponse();
        $res->responseCode = 1;
        $res->message = 'Usuario creado correctamente';
        return $res;
    }






    //----------------------------- CONSULTAS DE VENDEDOR ---------------------------------------------


    

    /**
     * Agrega diponibilidad de un vendedor para ciertos días
     */
    public function actionListDisponibility(){
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );
        $error = new MessageResponse();
        if(!$this->validateRequiredParam($error,isset($json->token), "Token de usuario" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->semana), "Semana del año a consultar" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->anio), "Año a consultar" )){
            return $error;
        }

        $token = $json->token;
        $vendedor = $this->getVendedorByToken($token);

        if(!$vendedor){
            $error->message="No se encontro un vendedor valido";
            return $error;
        }

        //Calcula la semana y el año actual
        $date = new \DateTime();
        $week = $date->format("W");
        $year = $date->format("Y");

        
        //Verifica si se tiene una semana indicada
        if(isset($json->semana)){
            $week = $json->semana;
        }

        if(isset($json->anio)){
            $year = $json->anio;
        }

        $disponibilidad = VDisponibilidadesVendedoresCitas::find()->where([
            'id_vendedor'=> $vendedor->id_vendedor])
            ->andWhere(['or',
                ['num_semana'=>$week],
                ['num_semana'=>null]
            ])
            ->andWhere(['or',
                ['num_anio'=>$year],
                ['num_anio'=>null]
            ])
            ->orderBy('id_dia_semana, num_hora_disponible')->all();

        foreach($disponibilidad as $item){
            if($item->id_cita!= null){
                $cita = WrkCitas::find()->where(['id_cita'=>$item->id_cita])->one();
                $cita->idVendedor->id_rol = $cita->idVendedor->idRol;
                $cita->idVendedor->id_tienda = $cita->idVendedor->idTienda;
                $cita->id_cliente = $cita->idCliente;
                $cita->id_vendedor = $cita->idVendedor;
                $item->id_cita = $cita;

            }
        }

        $response = new ListResponse();
        $response->results = $disponibilidad;
        $response->count = count($disponibilidad);
        $response->operation = "List Disponibility";
        return $response;
    }
    

    /**
     * Obtiene la lista de los clientes asociados al vendedor
     */
    public function actionListClients(){
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );
        $error = new MessageResponse();
        if(!$this->validateRequiredParam($error,isset($json->token), "Token de usuario" )){
            return $error;
        }

        
        $token = $json->token;
        $vendedor = $this->getVendedorByToken($token);

        if(!$vendedor){
            $error->message="No se encontro un vendedor valido";
            return $error;
        }

        $clientes = VClientesByVendedor::find()->where([
                 'id_vendedor'=> $vendedor->id_vendedor,
                 'b_actual'=>1
                 ])->all();

        $response = new ListResponse();
        $response->results = $clientes;
        $response->count = count($clientes);
        $response->operation = "List Clients";
        return $response;
    }


    /**
     * Obtiene la lista de las citas asociados al vendedor
     */
    public function actionListCitas(){
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );
        $error = new MessageResponse();
        if(!$this->validateRequiredParam($error,isset($json->token), "Token de usuario" )){
            return $error;
        }

        
        $token = $json->token;
        $vendedor = $this->getVendedorByToken($token);

        $citas = WrkCitas::find()->where(['id_vendedor'=>$vendedor->id_vendedor, 'b_habilitada'=>1])->orderBy('fch_cita, num_hora_cita ASC')->all();

        foreach($citas as $item){
            $item->id_cliente = $item->idCliente;

            $item->id_vendedor = $item->idVendedor;
            $item->idVendedor->id_tienda = $item->idVendedor->idTienda;
            $item->idVendedor->id_rol = $item->idVendedor->idRol;
        }

        $response = new ListResponse();
        $response->results = $citas;
        $response->count = count($citas);
        $response->operation = "List Citas";
        return $response;
    }


    //--------- BUSQUEDAS GENERICAS ----------------
    /**
     * Obtiene la lista de los productos genericos
     */
    public function actionListGenericos(){
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );
        
        $items = CatProductosGenericos::find()->
            where(['b_habilitado'=>1])->
            orderBy('txt_nombre ASC')->
            all();
        $response = new ListResponse();
        $response->results = $items;
        $response->count = count($items);
        $response->operation = "List Genericos";
        return $response;
    }


    /**
     * Obtiene la lista de las marcas
     */
    public function actionListMarcas(){
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );
        
        $items = CatMarcasProductos::find()->
            where(['b_habilitado'=>1])->
            orderBy('txt_nombre ASC')->
            all();

        foreach($items as $item){
            $item->id_fabricante = $item->idFabricante;
        }
            
        $response = new ListResponse();
        $response->results = $items;
        $response->count = count($items);
        $response->operation = "List Marcas";
        return $response;
    }


    /**
     * Obtiene la lista de las categorias
     */
    public function actionListCategorias(){
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );
        
        $items = CatCategoriasProductos::find()->
            where(['b_habilitado'=>1])->
            orderBy('txt_nombre ASC')->
            all();
        $response = new ListResponse();
        $response->results = $items;
        $response->count = count($items);
        $response->operation = "List Categorias";
        return $response;
    }


    /**
     * Obtiene la lista de las grupos
     */
    public function actionListGrupos(){
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );
        
        $items = CatGruposProductos::find()->
            where(['b_habilitado'=>1])->
            orderBy('txt_nombre ASC')->
            all();
        $response = new ListResponse();
        $response->results = $items;
        $response->count = count($items);
        $response->operation = "List Grupos";
        return $response;
    }




    /**
     * Obtiene la lista de los produtos
     */
    public function actionListProductos(){
        $error = new MessageResponse();
        if(!$this->validateRequiredParam($error,isset($GLOBALS["HTTP_RAW_POST_DATA"]), "Raw Data" )){
            return $error;
        }
        
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );
        
        $query = [];
        $query['b_habilitado'] = 1;

        if(isset($json->id_marca)){
            $query['id_marca_producto']= $json->id_marca;
        }

        if(isset($json->id_categoria)){
            $query['id_categoria_producto']= $json->id_categoria;
        }

        if(isset($json->id_grupo)){
            $query['id_grupo_producto']= $json->id_grupo;
        }

        if(isset($json->id_generico)){
            $query['id_producto_generico']= $json->id_generico;
        }


        $items = EntProductos::find()->
            where($query)->
            orderBy('txt_nombre ASC')->
            all();

        foreach($items as $item){
            $item->id_marca_producto = $item->idMarcaProducto;
            $item->id_categoria_producto = $item->idCategoriaProducto;
            $item->id_grupo_producto = $item->idGrupoProducto;
            $item->id_producto_generico = $item->idProductoGenerico;
            $item->idMarcaProducto->id_fabricante = $item->idMarcaProducto->idFabricante;
            if($item->b_atributos == 1){
                $item->b_atributos = $item->relProductosCatAtributos; 
                foreach($item->b_atributos as $at){
                    $at->id_atributo_producto = $at->idAtributoProducto;
                }            
            }else{
                $item->b_atributos = null;
            }

            $dataArray = array();
            $dataArray['imagenes'] = $item->entProductosImagenes;

            $item->producto_data = $dataArray;
        }
        
        //return $items[0]->entProductosImagenes;
        


        $response = new ListResponse();
        $response->results = $items;
        $response->count = count($items);
        $response->operation = "List Productos";
        return $response;
    }



    /**
     * Detalles de un producto
     */
    public function actionDetailProducto(){
        $error = new MessageResponse();
        if(!$this->validateRequiredParam($error,isset($GLOBALS["HTTP_RAW_POST_DATA"]), "Raw Data" )){
            return $error;
        }
        
        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );
        
        if(!$this->validateRequiredParam($error,isset($json->token), "Token de usuario" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->uddi), "UDDI del producto" )){
            return $error;
        }

        


        $item = EntProductos::find()->where(['uddi'=>$json->uddi])->one();
        if($item){
            $item->id_marca_producto = $item->idMarcaProducto;
            $item->id_categoria_producto = $item->idCategoriaProducto;
            $item->id_grupo_producto = $item->idGrupoProducto;
            $item->id_producto_generico = $item->idProductoGenerico;
            $item->idMarcaProducto->id_fabricante = $item->idMarcaProducto->idFabricante;
            if($item->b_atributos == 1){
                $item->b_atributos = $item->relProductosCatAtributos; 
                foreach($item->b_atributos as $at){
                    $at->id_atributo_producto = $at->idAtributoProducto;
                }            
            }else{
                $item->b_atributos = null;
            }

            $dataArray = array();
            $dataArray['imagenes'] = $item->entProductosImagenes;

            $item->producto_data = $dataArray;

            $response = new MessageResponse();
            $response->responseCode = $item->id_producto;
            $response->message = "Producto Detalle";
            $response->data = $item;

            return $response;
        }else{
            $response = new MessageResponse();
            $response->responseCode = -1;
            $response->message = "Producto no encontrado ";
    
            return $response;
        }

    }
    

    //-------------------- UTILIDADES -----------------------------
    /**
     * Recupera el usuario por un token
     */
    private function getVendedorByToken($token){
        $item = EntVendedores::find()->where([
            'uddi'=>$token])->one();
        return $item;
    }

    private function getClienteByToken($token){
        $item = EntClientes::find()->where([
            'uddi'=>$token])->one();

        return $item;
    }

    private function getProductoByToken($token){
        $item = EntProductos::find()->where([
            'uddi'=>$token])->one();

        return $item;
    }


    private function validateRequiredParam($response, $isSet, $atributoName){
        if(!$isSet){
            $response->responseCode = -1;
            $response->message = $atributoName . ' faltante';
            return false;
        }
        return true;
    }
    
}
