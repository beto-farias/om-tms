<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\CatCategoriasProductos;
use app\models\CatGruposProductos;
use app\models\CatMarcasProductos;
use app\models\CatProductosGenericos;

/* @var $this yii\web\View */
/* @var $model app\models\EntProductos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ent-productos-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="row">

            <div class="col-sm-12 col-md-6 col-lg-4">   
                <?= $form->field($model, 'id_categoria_producto')->dropDownList(ArrayHelper::map(CatCategoriasProductos::find()->where(['b_habilitado'=>1])->all(), 'id_categoria_producto', 'txt_nombre'), ['prompt'=>'Seleccionar categoria']) ?>

                <?= $form->field($model, 'id_grupo_producto')->dropDownList(ArrayHelper::map(CatGruposProductos::find()->where(['b_habilitado'=>1])->all(), 'id_grupo_producto', 'txt_nombre'), ['prompt'=>'Seleccionar grupo']) ?>

                <?= $form->field($model, 'id_marca_producto')->dropDownList(ArrayHelper::map(CatMarcasProductos::find()->where(['b_habilitado'=>1])->all(), 'id_marca_producto', 'txt_nombre'), ['prompt'=>'Seleccionar marca']) ?>   
                        
                <?= $form->field($model, 'id_producto_generico')->dropDownList(ArrayHelper::map(CatProductosGenericos::find()->where(['b_habilitado'=>1])->all(), 'id_producto_generico', 'txt_nombre'), ['prompt'=>'Seleccionar producto']) ?>
            </div>

             <div class="col-sm-12 col-md-6 col-lg-4">   
        
                <?= $form->field($model, 'txt_sku')->textInput(['maxlength' => true]) ?>
                
                <?= $form->field($model, 'txt_nombre')->textInput(['maxlength' => true]) ?>
            
                <?= $form->field($model, 'txt_description')->textarea(['rows' => 6]) ?>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-4">  
                
                <?= $form->field($model, 'num_precio')->textInput() ?>
                
                <?= $form->field($model, 'b_atributos')->textInput() ?>
                
                <?= $form->field($model, 'num_tamanio_paquete')->textInput() ?>
            </div>

            <div class="form-group col-sm-12 col-md-6 col-lg-4">
                <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
    
        </div>
    <?php ActiveForm::end(); ?> 
</div>
