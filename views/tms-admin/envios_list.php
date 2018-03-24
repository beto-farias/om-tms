<?php

use yii\helpers\Url;
use yii\helpers\Html;

foreach($shipments as $item):
    ?>

    <div>
        <?=$item->id_envio?>
        <?=Html::a($item->uddi,['tms-admin/envio-detalles', 'uddi' => $item->uddi] )?>
        <?=$item->idEnvioEstado->txt_nombre?>
        <?=$item->fch_creacion?>
    </div>


    <?php
endforeach

?>