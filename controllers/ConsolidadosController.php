<?php

namespace app\controllers;

use Yii;
use app\models\EntConsolidados;
use app\models\ConsolidadosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConsolidadosController implements the CRUD actions for EntConsolidados model.
 */
class ConsolidadosController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all EntConsolidados models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConsolidadosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EntConsolidados model.
     * @param integer $id_consolidado
     * @param integer $id_tipo_consolidado
     * @return mixed
     */
    public function actionView($id_consolidado, $id_tipo_consolidado)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_consolidado, $id_tipo_consolidado),
        ]);
    }

    /**
     * Creates a new EntConsolidados model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EntConsolidados();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_consolidado' => $model->id_consolidado, 'id_tipo_consolidado' => $model->id_tipo_consolidado]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EntConsolidados model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id_consolidado
     * @param integer $id_tipo_consolidado
     * @return mixed
     */
    public function actionUpdate($id_consolidado, $id_tipo_consolidado)
    {
        $model = $this->findModel($id_consolidado, $id_tipo_consolidado);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_consolidado' => $model->id_consolidado, 'id_tipo_consolidado' => $model->id_tipo_consolidado]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EntConsolidados model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id_consolidado
     * @param integer $id_tipo_consolidado
     * @return mixed
     */
    public function actionDelete($id_consolidado, $id_tipo_consolidado)
    {
        $this->findModel($id_consolidado, $id_tipo_consolidado)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EntConsolidados model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id_consolidado
     * @param integer $id_tipo_consolidado
     * @return EntConsolidados the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_consolidado, $id_tipo_consolidado)
    {
        if (($model = EntConsolidados::findOne(['id_consolidado' => $id_consolidado, 'id_tipo_consolidado' => $id_tipo_consolidado])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
