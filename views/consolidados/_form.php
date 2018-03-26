<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EntConsolidados */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ent-consolidados-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_tipo_consolidado')->textInput() ?>

    <?= $form->field($model, 'uddi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txt_nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fch_creacion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
