<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EntProductos */

$this->title = 'Crear productos';
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['classBody'] = "site-navbar-small site-menubar-hide";
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title"><?= Html::encode($this->title) ?></h2>        
    </div>
    <div class="panel-body">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
