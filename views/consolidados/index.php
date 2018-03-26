<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ConsolidadosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ent Consolidados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ent-consolidados-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ent Consolidados', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_consolidado',
            'id_tipo_consolidado',
            'uddi',
            'txt_nombre',
            'fch_creacion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
