<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\BaseHtml;
?>


<?=Html::beginForm(['/tms-admin/procesar', 'id' => 'procesar'], 'POST'); ?>
<select name="action">
    <option value="consolidado">Consolidado</option>
    <option value="candado">Candado</option>
</select>
<input type="text" name="nombre">
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
        <?=$item->idEnvioEstado->txt_nombre?>
        <?=$item->fch_creacion?>
    </div>


    <?php
        endforeach
    ?>
<div class="form-group">
    <?= Html::submitButton('POST', ['class' => 'btn btn-primary']) ?>
</div>
<?=BaseHtml::endForm() ?>

<h2>Consolidados</h2>
<?php
foreach($consolidados as $item):
    ?>

    <div>
        <input type="checkbox" name="shipment" value="<?=$item->uddi?>">
        <?=$item->id_consolidado?>
        <?=$item->txt_nombre?>
        <?=Html::a($item->uddi,['tms-admin/consolidado-detalles', 'uddi' => $item->uddi] )?>
        <?=$item->idTipoConsolidado->txt_nombre?>
        <?=$item->fch_creacion?>
        <ul>
            <?php
                foreach($item->idEnvios as $subitem):
            ?>

            <li><?=$subitem->id_envio?></li>
            <?php
                endforeach
            ?>
        </ul>
    </div>


    <?php
endforeach

?>
