<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\db\Transaction;

use app\models\ServiceResponse;
use app\models\EntEnvios;
use app\models\EntConsolidados;
use app\models\RelEnviosConsolidados;
use app\models\WrkConsolidadosEventos;
use app\models\WrkEnviosEventos;
use app\models\EntAlmacenes;
use app\models\WrkAlmacenesEventos;
use app\models\RelEnviosAlmacenes;
use app\models\VReporteEnvio;
use yii\db\Query;

class TmsAdminController extends Controller
{
   
    const CONSOLIDADO_ESTADO_EN_PREPARACION = 1;
    const CONSOLIDADO_ESTADO_CONSOLIDADO = 2;
    const CONSOLIDADO_ESTADO_TRANSITO = 3;
    const CONSOLIDADO_ESTADO_ARRIBO = 4;

    const ENVIO_ESTADO_ENTRADA_ALMACEN = 6;
    const ENVIO_ESTADO_SALIDA_ALMACEN = 5;

    const ALMACEN_EVENTO_ARRIBO = 1;
    const ALMACEN_EVENTO_SALIDA = 2;

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionEnviosList()
    {
        //Carga los envios
        $shipments = EntEnvios::find()->all();
        $consolidados = EntConsolidados::find()->all();
        $almacenes = EntAlmacenes::find()->all();
        return $this->render('envios_list',[
            'shipments'=>$shipments, 
            'consolidados'=>$consolidados,
            'almacenes'=>$almacenes]);
    }



    /**
     * Obtiene los detalles del elvio
     */
    public function actionEnvioDetalles($uddi){
         $shipment = EntEnvios::find()->where(['uddi'=>$uddi])->one();

       //Obtiene los eventos que tienen el id del envio
        $queryEnvios = VReporteEnvio::find()->
        where(['id_envio'=>$shipment->id_envio]);

        //Obtiene la relacion entre el consolidado y el envio
        $subQueryConsolidados = RelEnviosConsolidados::find()->
        select('id_consolidado')->
        where(['id_envio'=>$shipment->id_envio]);

        //Obtiene la informacion de los consolodados relaconados con el envio
        $queryConsolidados = VReporteEnvio::find()->
        where(['in','id_consolidado',$subQueryConsolidados]);

        //Crea el query final
        $query = (new yii\db\Query())->
        select(['id_evento','id_envio','id_consolidado','id_almacen','txt_lugar','fch_evento','txt_evento'])->
        from(['detalles'=>$queryEnvios->union($queryConsolidados)])->
        orderBy('fch_evento');

        $details = $query->all();

         return $this->render('envio_detalles',[
             'shipment'=>$shipment,
             'details'=>$details
             ]);
    }



    /**
     * 
     */
    public function actionConsolidadoDetalles($uddi){
        $item = $this->getConsolidadoByUDDI($uddi);
        return $this->render('consolidado_detalles',['item'=>$item]);
   }

    public function actionProcesarEnvios(){
        
        $accion = $_POST['action'];


        if($accion == 'new-consolidado'){

            $this->procesarNuevoConsolidado();

        }else if($accion == 'add-consolidado'){

            $this->procesarAgregarConsolidado();

        }else if($accion == 'recibir-shipment'){

            $this->recibirShipment();
        }
    }

    


    /**
     * 
     */
    public function actionProcesarConsolidados(){
        print_r($_POST);

        $accion = $_POST['action'];
        if($accion == 'close-consolidado'){

            $this->cerrarConsolidado();

        }else if($accion == 'transito-consolidado'){

            $this->transitoConsolidado();

        }else if($accion == 'arribo-consolidado'){

            $this->arriboConsolidado();

        }

        
    }

   

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionConstruccion(){

        $this->layout = "classic/topBar/mainBlank";

        return $this->render("construccion");
    }


//------------------- FUNCIONES DE NEGOCIO ---------------


    /**
     * Crea el consolidado
     */
    private function cerrarConsolidado(){
        $consolidados = $_POST['consolidado']; 
            //crea la transaccion
            $transaction = Yii::$app->db->beginTransaction(
                Transaction::SERIALIZABLE
            );
            try{
                foreach($consolidados as $item){
                    //Actualiza el estado en el consolidado
                    $consolidado = $this->getConsolidadoByUDDI($item);
                    $consolidado->id_consolidado_estado = self::CONSOLIDADO_ESTADO_CONSOLIDADO;
                    if(!$consolidado->save()){
                        throw new \Exception(self::getModelErrorsAsString($consolidado->errors));
                    }

                    //Agrega el evento al consolidado
                    $evento = new WrkConsolidadosEventos();
                        $evento->id_consolidado = $consolidado->id_consolidado;
                        $evento->id_consolidado_estado = self::CONSOLIDADO_ESTADO_CONSOLIDADO;
                        if(!$evento->save()){
                            throw new \Exception(self::getModelErrorsAsString($evento->errors));
                        }
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                print_r($e);
                return $this->redirect(['envios-list']);
            }

            $transaction->commit();
            return $this->redirect(['envios-list']);
    }



    /**
     * Pone en transito el consolidado
     */
    private function transitoConsolidado(){
        $consolidados = $_POST['consolidado']; 
            //crea la transaccion
            $transaction = Yii::$app->db->beginTransaction(
                Transaction::SERIALIZABLE
            );
            try{
                foreach($consolidados as $item){
                    //Actualiza el estado en el consolidado
                    $consolidado = $this->getConsolidadoByUDDI($item);
                    $consolidado->id_consolidado_estado = self::CONSOLIDADO_ESTADO_TRANSITO;
                    if(!$consolidado->save()){
                        throw new \Exception(self::getModelErrorsAsString($consolidado->errors));
                    }

                    //Agrega el evento al consolidado
                    $this->createConsolidadoEvento($consolidado->id_consolidado, self::CONSOLIDADO_ESTADO_TRANSITO);
                

                    //----- Indica en el almacen que el envio salio -----
                    // 1 Carga los items que estan en el consolidado
                    $shipments = RelEnviosConsolidados::find()->where(['id_consolidado'=>$consolidado->id_consolidado])->all();

                    foreach($shipments as $rel){
                    //$idAlmacen, $idEnvio, $idEvento
                        $shipment = $rel->idEnvio;
                        $this->createAlmacenEvento($shipment->id_almacen,$shipment->id_envio, self::ALMACEN_EVENTO_SALIDA);

                        $shipment->id_envio_estado = self::ENVIO_ESTADO_SALIDA_ALMACEN;
                        //Remueve el id del almacen
                        $shipment->id_almacen = null;
                        if(!$shipment->save()){
                            throw new \Exception(self::getModelErrorsAsString($shipment->errors));
                        }
                    }

                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                print_r($e);
                return $this->redirect(['envios-list']);
            }

            $transaction->commit();
            return $this->redirect(['envios-list']);
    }


    private function arriboConsolidado(){
        $consolidados = $_POST['consolidado']; 
            //crea la transaccion
            $transaction = Yii::$app->db->beginTransaction(
                Transaction::SERIALIZABLE
            );
            try{
                foreach($consolidados as $item){
                    //Actualiza el estado en el consolidado
                    $consolidado = $this->getConsolidadoByUDDI($item);
                    $consolidado->id_consolidado_estado = self::CONSOLIDADO_ESTADO_ARRIBO;
                    
                    if(!$consolidado->save()){
                        throw new \Exception(self::getModelErrorsAsString($consolidado->errors));
                    }

                    //Obtiene el id del almacen destino del consolidado
                    $idAlmacenDestino = $consolidado->id_almacen_destino;

                    //Agrega el evento al consolidado
                    $this->createConsolidadoEvento($consolidado->id_consolidado, self::CONSOLIDADO_ESTADO_ARRIBO);
                

                    //----- Indica en el almacen que el envio llego -----
                    // 1 Carga los items que estan en el consolidado
                    $shipments = RelEnviosConsolidados::find()->where(['id_consolidado'=>$consolidado->id_consolidado])->all();

                    foreach($shipments as $rel){
                        $shipment = $rel->idEnvio;
                        //Crea el evento del almacen que el envio llego
                        $this->createAlmacenEvento($idAlmacenDestino,$shipment->id_envio, self::ALMACEN_EVENTO_ARRIBO);

                        //Actualiza el envio
                        $shipment->id_envio_estado = self::ENVIO_ESTADO_ENTRADA_ALMACEN;
                        //Asigna el id del almacen
                        $shipment->id_almacen = $idAlmacenDestino;
                        //Remueve el id del consolidado
                        $shipment->id_consolidado = null;
                        if(!$shipment->save()){
                            throw new \Exception(self::getModelErrorsAsString($shipment->errors));
                        }
                    }

                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                print_r($e);
                return $this->redirect(['envios-list']);
            }

            $transaction->commit();
            return $this->redirect(['envios-list']);
    }


    /**
     * 
     */
    private function procesarNuevoConsolidado(){
        $shipments = $_POST['shipment'];
        $almacenOrigen = $_POST['almacen'];
        $almacenOrigen = $this->getAlmacenByUDDI($almacenOrigen);

        $almacenDestino = $_POST['almacen_destino'];
        $almacenDestino = $this->getAlmacenByUDDI($almacenDestino);

        //TODO mover la funcion a una externa para swichear de acuerdo a la accion
        $model = new EntConsolidados();
        $model->uddi = uniqid("consolidado-");
        $model->txt_nombre = Yii::$app->request->post()['nombre'];
        $model->id_tipo_consolidado = 1;
        $model->id_consolidado_estado = self::CONSOLIDADO_ESTADO_EN_PREPARACION;
        $model->id_almacen_origen = $almacenOrigen->id_almacen;;
        $model->id_almacen_destino = $almacenDestino->id_almacen;;

        //crea la transaccion
        $transaction = Yii::$app->db->beginTransaction(
            Transaction::SERIALIZABLE
        );

        try {
            if ($model->save()) {

                //Crea el evento
                $evento = new WrkConsolidadosEventos();
                $evento->id_consolidado = $model->id_consolidado;
                $evento->id_consolidado_estado = self::CONSOLIDADO_ESTADO_EN_PREPARACION;
                if(!$evento->save()){
                    throw new \Exception(self::getModelErrorsAsString($evento->errors));
                }


                //Relaciona los envios con el consolidado
                foreach($shipments as $item){
                    $shipment = $this->getEnvioByUDDI($item);
                    $shipment->id_consolidado = $model->id_consolidado; //Asigna al envio el consolidado

                    //Guarda la actualizacion
                    if(!$shipment->save()){
                        throw new \Exception(self::getModelErrorsAsString($shipment->errors));
                    }


                    $rel = new RelEnviosConsolidados();
                    $rel->id_envio = $shipment->id_envio;
                    $rel->id_consolidado = $model->id_consolidado;
                    if(!$rel->save()){
                        throw new \Exception(self::getModelErrorsAsString($rel->errors));
                    }

                }
                $transaction->commit();
                return $this->redirect(['envios-list']);
            } else{
                throw new \Exception(self::getModelErrorsAsString($shipment->errors));
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            print_r($e);
            return $this->redirect(['envios-list']);
        }
    }


    /**
     * Recibir un envio ---
     */
    private function recibirShipment(){
        $shipments = $_POST['shipment'];
            $almacen = $_POST['almacen'];
            $almacen = $this->getAlmacenByUDDI($almacen);

            //crea la transaccion
            $transaction = Yii::$app->db->beginTransaction(
                Transaction::SERIALIZABLE
            );

            try {
                //Relaciona los envios con el consolidado
                foreach($shipments as $item){
                    $shipment = $this->getEnvioByUDDI($item);
                    $shipment->id_almacen = $almacen->id_almacen; //Indica el almacen del produto
                    
                    //Guarda la actualizacion
                    if(!$shipment->save()){
                        throw new \Exception(self::getModelErrorsAsString($shipment->errors));
                    }

                    //Crea el evento del envio
                    $this->createEnvioEvento($shipment->id_envio, self::ENVIO_ESTADO_ENTRADA_ALMACEN);
                    //Crea el evento del almacen;
                    $this->createAlmacenEvento($almacen->id_almacen, $shipment->id_envio, self::ALMACEN_EVENTO_ARRIBO);

                    //Actualiza el evento
                    $shipment->id_envio_estado = self::ENVIO_ESTADO_ENTRADA_ALMACEN;
                    if(!$shipment->save()){
                        throw new \Exception(self::getModelErrorsAsString($shipment->errors));
                    }
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                echo("<hr>");
                print_r($e);
                echo("<hr>");
                return $this->redirect(['envios-list']);
            }

            $transaction->commit();
            return $this->redirect(['envios-list']);
    }

    /**
     * Agrega los envios a un consolidado
     */
    private function procesarAgregarConsolidado(){
        $shipments = $_POST['shipment'];
        $consolidado = $_POST['consolidado'];
        $consolidado = $this->getConsolidadoByUDDI($consolidado);

        //crea la transaccion
        $transaction = Yii::$app->db->beginTransaction(
            Transaction::SERIALIZABLE
        );
        try{
            //Relaciona los envios con el consolidado
            foreach($shipments as $item){
                $shipment = $this->getEnvioByUDDI($item);
                $shipment->id_consolidado = $consolidado->id_consolidado; //Asigna al envio el consolidado

                //Guarda la actualizacion
                if(!$shipment->save()){
                    throw new \Exception(self::getModelErrorsAsString($shipment->errors));
                }

                $rel = new RelEnviosConsolidados();
                $rel->id_envio = $shipment->id_envio;
                $rel->id_consolidado = $consolidado->id_consolidado;
                if(!$rel->save()){
                    throw new \Exception(self::getModelErrorsAsString($rel->errors));
                }
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            print_r($e);
            return $this->redirect(['envios-list']);
        }

        $transaction->commit();
        return $this->redirect(['envios-list']);
    }

    
    //-------------- UTILIDADES ---------------------------


    private function createConsolidadoEvento($idConsolidado, $idEvento){
        $evento = new WrkConsolidadosEventos();
        $evento->id_consolidado = $idConsolidado;
        $evento->id_consolidado_estado = $idEvento;
        if(!$evento->save()){
            throw new \Exception(self::getModelErrorsAsString($evento->errors));
        }
    }


    /**
     * Crea un evento para el envio
     */
    private function createEnvioEvento($idEnvio, $idEvento){
        $evento = new WrkEnviosEventos();
        $evento->id_envio = $idEnvio;
        $evento->id_envio_estado = $idEvento;
        if(!$evento->save()){
            throw new \Exception(self::getModelErrorsAsString($evento->errors));
        }
    }

    /**
     * Crea un evento para el almacen
     */
    private function createAlmacenEvento($idAlmacen, $idEnvio, $idEvento){

        //Verifica si existe una relacion entre el almacen y el envio
        $rel = RelEnviosAlmacenes::find()->where([
            'id_envio'=>$idEnvio,
             'id_almacen'=>$idAlmacen
             ])->one();
        
        if(!$rel){
            $rel = new RelEnviosAlmacenes();
            $rel->id_almacen = $idAlmacen;
            $rel->id_envio = $idEnvio;
            if(!$rel->save()){
                print_r($idAlmacen);
        print_r($idEnvio);
        print_r($idEvento);
        print_r(this->getModelErrorsAsString($rel->errors));
        //print_r($evento->errors);
        exit;
                throw new \Exception(self::getModelErrorsAsString($rel->errors));
            }
        }
        
        $evento = new WrkAlmacenesEventos();
        $evento->id_almacen = $idAlmacen;
        $evento->id_envio = $idEnvio;
        $evento->id_almacen_estado = $idEvento;

       
        if(!$evento->save()){

        // print_r($idAlmacen);
        // print_r($idEnvio);
        // print_r($idEvento);
        // print_r($evento->errors);
        // exit;
            throw new \Exception(self::getModelErrorsAsString($evento->errors));
        }
    }


    private function getEnvioByUDDI($uddi){
        return  EntEnvios::find()->where(['uddi'=>$uddi])->one();
    }

    private function getConsolidadoByUDDI($uddi){
        return  EntConsolidados::find()->where(['uddi'=>$uddi])->one();
    }
    

    private function getAlmacenByUDDI($uddi){
        return  EntAlmacenes::find()->where(['uddi'=>$uddi])->one();
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

    
}
