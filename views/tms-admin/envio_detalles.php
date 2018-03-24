<?php

    $item = $shipment;
    $direccionFrom = $item->idDireccionRemitente;
    $direccionTo = $item->idDireccionDestino;
    ?>

    <div>
        <?=$item->id_envio?>
        <?=$item->uddi?>
        <?=$item->idEnvioEstado->txt_nombre?>
        <?=$item->fch_creacion?>
        <div>
            <? print_r($direccionFrom);?>
        </div>

        <div>
            <? print_r($direccionTo);?>
        </div>
    </div>


    <?php


?>