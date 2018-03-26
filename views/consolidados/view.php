<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EntConsolidados */

$this->title = $model->id_consolidado;
$this->params['breadcrumbs'][] = ['label' => 'Ent Consolidados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ent-consolidados-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_consolidado' => $model->id_consolidado, 'id_tipo_consolidado' => $model->id_tipo_consolidado], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_consolidado' => $model->id_consolidado, 'id_tipo_consolidado' => $model->id_tipo_consolidado], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_consolidado',
            'id_tipo_consolidado',
            'uddi',
            'txt_nombre',
            'fch_creacion',
        ],
    ]) ?>

</div>
