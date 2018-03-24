<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\components\AccessControlExtend;
use yii\helpers\Json;

use app\models\ServiceResponse;
use app\models\EntEnvios;
use app\models\EntDirecciones;
use app\models\Entplataformas;


class ServicesController extends \yii\rest\Controller
{

    public $enableCsrfValidation = false;
    public $layout = null;


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

        $shipment->save();

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

    const ENVIO_ESTADO_INFO_RECIBIDA = 1;

    //-------------------- UTILIDADES -----------------------------
  
    private function createAddress($data){
        $address = new EntDirecciones();
        $address->uddi = uniqid("addr-to");
        $address->txt_calle = $data->calle;
        $address->txt_numero_exterior = $data->num_ext;
        $address->txt_numero_interior = $data->num_int;
        $address->txt_colonia = $data->colonia;
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

    private function validateRequiredParam($response, $isSet, $atributoName){
        if(!$isSet){
            $response->responseCode = -1;
            $response->message = $atributoName . ' faltante';
            return false;
        }
        return true;
    }
    
}
