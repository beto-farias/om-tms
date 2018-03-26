<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\models\EntEnvios;
use app\models\EntConsolidados;
use app\models\RelEnviosConsolidados;

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
        $consolidados = EntConsolidados::find()->all();
        return $this->render('envios_list',['shipments'=>$shipments, 'consolidados'=>$consolidados]);
    }

    public function actionEnvioDetalles($uddi){
         $shipment = EntEnvios::find()->where(['uddi'=>$uddi])->one();
         return $this->render('envio_detalles',['shipment'=>$shipment]);
    }

    public function actionProcesar(){
        print_r($_POST);
        $shipments = $_POST['shipment'];
        

        //TODO mover la funcion a una externa para swichear de acuerdo a la accion
        $model = new EntConsolidados();
        $model->uddi = uniqid("consolidado-");
        $model->txt_nombre = Yii::$app->request->post()['nombre'];
        $model->id_tipo_consolidado = 1;
        if ($model->save()) {

            //Relaciona los envios con el consolidado
            foreach($shipments as $item){
                $shipment = $this->getEnvioByUDDI($item);
                $rel = new RelEnviosConsolidados();
                $rel->id_envio = $shipment->id_envio;
                $rel->id_consolidado = $model->id_consolidado;
                $rel->save();

            }

            return $this->redirect(['envios-list']);
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

    

    private function getEnvioByUDDI($uddi){
        return  EntEnvios::find()->where(['uddi'=>$uddi])->one();
    }

    
}
