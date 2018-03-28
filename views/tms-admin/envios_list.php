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

<label for="almacen_destino">Almacen destino</label>
<select name="almacen_destino">
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
    if($item->id_consolidado){
        continue;
    }
    ?>

    <div>
        <input type="checkbox" name="shipment[<?=$key?>]" value="<?=$item->uddi?>">
        <?=$item->id_envio?>
        <?=Html::a($item->uddi,['tms-admin/envio-detalles', 'uddi' => $item->uddi] )?>
        <strong><?=$item->idEnvioEstado->txt_nombre?></strong>
        <?=$item->id_almacen?$item->idAlmacen->txt_nombre:''?>
        [<?=$item->id_consolidado?$item->idConsolidado->txt_nombre:''?>]
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
    <option value="transito-consolidado">Transito</option>
    <option value="arribo-consolidado">Arribo</option>
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
                <strong><?=$subitem->idEnvioEstado->txt_nombre?></strong>
                <?=$subitem->id_almacen?$subitem->idAlmacen->txt_nombre:''?>
                [<?=$subitem->id_consolidado?$subitem->idConsolidado->txt_nombre:''?>]
                <?=$subitem->fch_creacion?>
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