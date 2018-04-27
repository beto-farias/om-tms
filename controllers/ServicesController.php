<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\components\AccessControlExtend;
use yii\helpers\Json;
use yii\db\Transaction;

use app\models\ServiceResponse;
use app\models\EntEnvios;
use app\models\EntDirecciones;
use app\models\Entplataformas;
use app\models\WrkEnviosEventos;
use app\models\RelEnviosAtributos;
use app\models\CatEnviosAtributos;


class ServicesController extends \yii\rest\Controller
{

    public $enableCsrfValidation = false;
    public $layout = null;

    const ENVIO_ESTADO_INFO_RECIBIDA = 1;


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
        return true; // or false to not run the action
    }

    //------------------- SERVICIOS -------------------------------

    public function actionAddShipment(){
        if(!isset($GLOBALS["HTTP_RAW_POST_DATA"])){
            $error = new ServiceResponse();
            $error->responseCode = -1;
            $error->message = 'Body de la petición faltante';
            return $error;
        }

        $json = json_decode($GLOBALS["HTTP_RAW_POST_DATA"] );

        //Validacion del servicio
        $error = new ServiceResponse();
        
        if(!$this->validateRequiredParam($error,isset($json->address_from), "Direccion origen" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->address_to), "Direccion destino" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->remitente), "Remitente" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->destinatario), "Destinatario" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->plataforma), "Plataforma" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->transaccion), "transaccion" )){
            return $error;
        }

        
        $validFrom = self::validateRequiredParamAddress($json->address_from);
        if($validFrom){
            return $validFrom;
        }

        $validTo = self::validateRequiredParamAddress($json->address_to);
        if($validTo){
            return $validTo;
        }
       
        //Validacion de atributios obligatorios
        if(!$this->validateRequiredParam($error,isset($json->atributos), "atributos" )){
            return $error;
        }
        
        
        if(!$this->validateRequiredParam($error,isset($json->atributos->peso_gr), "Peso" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->atributos->ancho_cm), "Ancho" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->atributos->alto_cm), "Alto" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->atributos->largo_cm), "Largo" )){
            return $error;
        }
        


        //Verifica que exista la plataforma
        $plataforma = EntPlataformas::find()->where(['uddi'=>$json->plataforma])->one();

        if(!$plataforma){
            $error = new ServiceResponse();
            $error->responseCode = -1;
            $error->message = 'Plataforma incorrecta';
            return $error;
        }

        //Verifica que no se repita la creacion del envío
        $shipment = EntEnvios::find()->where([
            'txt_token_transaccion_plataforma'=>$json->transaccion,
            'id_plataforma'=>$plataforma->id_plataforma
            ])->one();


        if($shipment){
            $error = new ServiceResponse();
            $error->responseCode = $shipment->id_envio;
            $error->message = 'El envío ya está registrado';
            return $error;
        }


        //---- construccion del objeto ------

        $addressFrom = self::createAddress($json->address_from);
        $addressTo = self::createAddress($json->address_to);
        

        $shipment = new EntEnvios();

        $shipment->uddi = uniqid("shipment-");
        $shipment->id_envio_estado = self::ENVIO_ESTADO_INFO_RECIBIDA;
        $shipment->id_direccion_remitente = $addressFrom->id_direccion;
        $shipment->id_direccion_destino = $addressTo->id_direccion;
        $shipment->txt_remitente = $json->remitente;
        $shipment->txt_destinatario = $json->destinatario;
        $shipment->txt_token_transaccion_plataforma = $json->transaccion;
        $shipment->id_plataforma = $plataforma->id_plataforma;



        //crea la transaccion
        $transaction = Yii::$app->db->beginTransaction(
            Transaction::SERIALIZABLE
        );

        try {

            //guarda el registro
            if(!$shipment->save()){
                throw new \Exception(self::getModelErrorsAsString($shipment->errors));
            }
            
            //Crea el evento
            self::addEnvioEvento($shipment, self::ENVIO_ESTADO_INFO_RECIBIDA, "");

            //Crea los atributos obligatorios
            self::createAttributoEnvio($shipment->id_envio, self::ENVIO_ATTR_ALTO, $json->atributos->alto_cm);
            self::createAttributoEnvio($shipment->id_envio, self::ENVIO_ATTR_ANCHO, $json->atributos->ancho_cm);
            self::createAttributoEnvio($shipment->id_envio, self::ENVIO_ATTR_LARGO, $json->atributos->largo_cm);
            self::createAttributoEnvio($shipment->id_envio, self::ENVIO_ATTR_PESO, $json->atributos->peso_gr);

            //Crea los atributos opcionales
            if(isset($json->atributos->opcionales)){
                foreach($json->atributos->opcionales as $item){
                    //verifica que tenga los elementos necesarios
                    if(!isset($item->atributo) || !isset($item->valor)){
                        //Salta el atributo por no tener los elementos completos
                        continue;
                    }
                    //Busca si existe el atributo en la base de datos
                    $attr = CatEnviosAtributos::find()->
                    where(['txt_nombre'=>$item->atributo, 'b_habilitado'=>1])->
                    one();
                    //Si se encontró el atributo
                    if($attr){
                        self::createAttributoEnvio($shipment->id_envio, $attr->id_envio_atributo, $item->valor);
                    }
                }
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();

            $response = new ServiceResponse();
            $response->responseCode = -1;
            $response->message = $e->getMessage();
            $response->data = $e;

            return $response;
        }

        //carga las direcciones
        $shipment->id_direccion_remitente = $shipment->idDireccionRemitente;
        $shipment->id_direccion_destino = $shipment->idDireccionDestino;

        $shipment->id_envio_estado = $shipment->idEnvioEstado;
        $shipment->fch_creacion = $shipment->fch_creacion . "";

        $response = new ServiceResponse();
        $response->responseCode = $shipment->id_envio;
        $response->message = "Envio recibido";
        $response->data = $shipment;
        
        return $response;  
    }


    

    const ENVIO_ATTR_ANCHO = 1;
    const ENVIO_ATTR_ALTO = 2;
    const ENVIO_ATTR_LARGO = 3;
    CONST ENVIO_ATTR_PESO = 4;
    

    

    //-------------------- UTILIDADES -----------------------------


    /**
     * Agrega el evento al envio
     */
    private function addEnvioEvento($envio, $estatus, $notas){
        $evento = new WrkEnviosEventos();
        $evento->id_envio = $envio->id_envio;
        $evento->id_envio_estado = $estatus;
        $evento->txt_notas = $notas;

        if(!$evento->save()){
            throw new \Exception("Error al generar el evento");
        }
    }


    /**
     * Crea un atributo y lo relaciona con el envio
     */
    private function createAttributoEnvio($idEnvio, $idAtributo, $valor){
        //Crea los atributos obligatorios
        
        $relAttr = new RelEnviosAtributos();
        $relAttr->id_envio = $idEnvio;
        $relAttr->id_envio_atributo = $idAtributo;
        $relAttr->txt_valor = $valor;
        
        

        if(!$relAttr->save()){
            return $relAttr->errors;
            throw new \Exception("Error al generar el atributo ");
        }
    }
  

    /**
     * Crea una direccion de destino en la base de datos
     */
    private function createAddress($data){
        $address = new EntDirecciones();
        $address->uddi = uniqid("addr-");
        $address->txt_calle = $data->calle;
        $address->txt_numero_exterior = $data->num_ext;
        $address->txt_numero_interior = $data->num_int;
        $address->txt_colonia = $data->colonia;
        $address->txt_municipio = $data->municipio;
        $address->txt_estado = $data->estado;
        $address->txt_pais = $data->pais; 
        $address->txt_cp = $data->cp;
        $address->txt_referencia = $data->referencia;

        $address->save();

        return $address;
    }

    private function validateRequiredParamAddress($json){
        //Validacion del servicio
        $error = new ServiceResponse();
        
        if(!$this->validateRequiredParam($error,isset($json->calle), "Calle" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->num_ext), "Numero exterior" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->num_int), "Numero interior" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->colonia), "Colonia" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->municipio), "Municipio" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->estado), "Estado" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->pais), "pais" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->cp), "cp" )){
            return $error;
        }

        if(!$this->validateRequiredParam($error,isset($json->referencia), "Referencia" )){
            return $error;
        }
        
    }

    /**
     * Toma los errores del modelo y los pone como String
     */
    private function getModelErrorsAsString($error){
        $errors = "";
            foreach($error->errors as $item){
                $errors .=  $item[0] . ", ";
            }  
        return $errors;
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
