<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\CatAtributosProductos;

$this->title = 'Asignar atributos de '.$producto->txt_nombre;
$this->params['classBody'] = "site-navbar-small site-menubar-hide";
?>

<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="panel-title"><?= Html::encode($this->title) ?></h2>        
        </div>
        <div class="panel-body">

            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($atributosProductos, 'id_atributo_producto')->dropDownList(ArrayHelper::map(CatAtributosProductos::find()->where(['b_habilitado'=>1])->all(), 'id_atributo_producto', 'txt_nombre'), ['prompt'=>'Seleccionar atributo']) ?>

                <?php if($atributosPadres){ ?>

                    <?= $form->field($atributosProductos, 'id_padre')->dropDownList(ArrayHelper::map($atributosPadres, 'id_atributo_producto_opcion', 'txt_valor'), ['prompt'=>'Seleccionar atributo']) ?>

                <?php } ?>

                <?= $form->field($atributosProductos, 'txt_valor')->textInput(['maxlength' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
