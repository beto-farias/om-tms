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


        


        return true;
    }

    //-------------------- UTILIDADES -----------------------------
  


    private function validateRequiredParam($response, $isSet, $atributoName){
        if(!$isSet){
            $response->responseCode = -1;
            $response->message = $atributoName . ' faltante';
            return false;
        }
        return true;
    }
    
}
