<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\BaseHtml;
?>


<?=Html::beginForm(['/tms-admin/procesar-envios', 'id' => 'procesar'], 'POST'); ?>

<label for="action">Acción</label>
<select name="action">
    <option value="recibir-shipment">Recibir envio</option>
    <option value="new-consolidado">Nuevo consolidado</option>
    <option value="add-consolidado">Agregar a consolidado</option>
    <option value="candado">Candado</option>
</select>

<label for="consolidado">Consolidado</label>
<select name="consolidado">
    <?php
    foreach($consolidados as $item):
    ?>
        <option value="<?=$item->uddi?>"><?=$item->txt_nombre?></option>
    <?php
    endforeach;
    ?>
</select>

<label for="almacen">Almacen</label>
<select name="almacen">
    <?php
    foreach($almacenes as $item):
    ?>
        <option value="<?=$item->uddi?>"><?=$item->txt_nombre?></option>
    <?php
    endforeach;
    ?>
</select>

<label for="nombre">Nombre del Consolidado</label>
<input type="text" name="nombre">

<?= Html::submitButton('Procesar', ['class' => 'btn btn-primary']) ?>
<h2>Envíos</h2>
<?php
foreach($shipments as $key=>$item):
    if($item->idConsolidados){
        continue;
    }
    ?>

    <div>
        <input type="checkbox" name="shipment[<?=$key?>]" value="<?=$item->uddi?>">
        <?=$item->id_envio?>
        <?=Html::a($item->uddi,['tms-admin/envio-detalles', 'uddi' => $item->uddi] )?>
        <strong><?=$item->idEnvioEstado->txt_nombre?></strong>
        <?=$item->fch_creacion?>
    </div>


    <?php
        endforeach
    ?>

<?=BaseHtml::endForm() ?>




<h2>Consolidados</h2>
<?=Html::beginForm(['/tms-admin/procesar-consolidados', 'id' => 'procesar'], 'POST'); ?>

<label for="action">Acción</label>
<select name="action">
    <option value="close-consolidado">Consolidar</option>
</select>

<?= Html::submitButton('POST', ['class' => 'btn btn-primary']) ?>
<?php
foreach($consolidados as $key=>$item):
?>

    <div>
        <input type="checkbox" name="consolidado[<?=$key?>]" value="<?=$item->uddi?>">
        <?=$item->id_consolidado?>
        <?=$item->txt_nombre?>
        [<?=$item->idAlmacenOrigen->txt_nombre?> -> 
        <?=$item->idAlmacenDestino->txt_nombre?>]
        <?=Html::a($item->uddi,['tms-admin/consolidado-detalles', 'uddi' => $item->uddi] )?>
        <?=$item->idTipoConsolidado->txt_nombre?>
        <strong><?=$item->idConsolidadoEstado->txt_nombre?></strong>
        <?=$item->fch_creacion?>
        <ul>
            <?php
                foreach($item->idEnvios as $subitem):
            ?>

            <li>
                <?=$subitem->id_envio?>
                <?=Html::a($subitem->uddi,['tms-admin/envio-detalles', 'uddi' => $subitem->uddi] )?>
            </li>
            <?php
                endforeach
            ?>
        </ul>
    </div>


    <?php
endforeach

?>

<?=BaseHtml::endForm() ?>