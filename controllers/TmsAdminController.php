<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\models\EntEnvios;

class TmsAdminController extends Controller
{
   

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionEnviosList()
    {
        //Carga los envios
        $shipments = EntEnvios::find()->all();
        return $this->render('envios_list',['shipments'=>$shipments]);
    }

    public function actionEnvioDetalles($uddi){
         $shipment = EntEnvios::find()->where(['uddi'=>$uddi])->one();
         return $this->render('envio_detalles',['shipment'=>$shipment]);
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

    

    
}
