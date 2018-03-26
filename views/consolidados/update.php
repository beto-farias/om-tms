<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EntConsolidados */

$this->title = 'Update Ent Consolidados: ' . $model->id_consolidado;
$this->params['breadcrumbs'][] = ['label' => 'Ent Consolidados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_consolidado, 'url' => ['view', 'id_consolidado' => $model->id_consolidado, 'id_tipo_consolidado' => $model->id_tipo_consolidado]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ent-consolidados-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
