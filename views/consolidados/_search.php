<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConsolidadosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ent-consolidados-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_consolidado') ?>

    <?= $form->field($model, 'id_tipo_consolidado') ?>

    <?= $form->field($model, 'uddi') ?>

    <?= $form->field($model, 'txt_nombre') ?>

    <?= $form->field($model, 'fch_creacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
