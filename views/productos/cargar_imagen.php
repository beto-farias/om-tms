<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
use app\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $model app\models\EntProductos */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile(
    '@web/webAssets/templates/classic/global/vendor/dropify/dropify.css',
    ['depends' => [AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webAssets/templates/classic/global/vendor/dropify/dropify.min.js',
    ['depends' => [AppAsset::className()]]
);

$this->registerJsFile(
    '@web/webAssets/templates/classic/global/js/Plugin/dropify.js',
    ['depends' => [AppAsset::className()]]
);

$this->params['classBody'] = "site-navbar-small site-menubar-hide";
$this->title = 'Cargar fotos de '.$producto->txt_nombre;
?>

<div class="container">
    <h2>Fotos de <?= $producto->txt_nombre ?></h2>
    <div class="row">
        <?php
        if($imagenes){
            foreach($imagenes as $imagen){
        ?>
            <div class="col-md-4">
                <img src="<?= Url::base() . '/' . Yii::$app->params ['modUsuarios'] ['path_imagenes_productos'] . $imagen->txt_url_imagen ?>" alt="" weigth=150 height=150>
            </div>
        <?php
            }
        }
        ?>
    </div>

    <h3>Seleccionar imagen</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="panel-title"><?= Html::encode($this->title) ?></h2>        
        </div>
        <div class="panel-body">
        
            <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($imagenProd, 'imagen')->fileInput(["data-plugin"=>"dropify", "data-max-file-size"=>"50M", "data-allowed-file-extensions"=>"png jpg jpeg"]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Guardar iamgen', ['class' => 'btn btn-success']) ?>
                </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>

    <a class="btn btn-primary" href="<?= Url::base() . '/productos/atributos?id='.$producto->id_producto ?>"> 
        <span>Asignar atributos</span>
    </a>
</div>

