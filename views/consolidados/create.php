<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EntConsolidados */

$this->title = 'Create Ent Consolidados';
$this->params['breadcrumbs'][] = ['label' => 'Ent Consolidados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ent-consolidados-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
