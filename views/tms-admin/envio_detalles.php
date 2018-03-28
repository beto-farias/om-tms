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
        <hr>
        <div>
            <? print_r($direccionFrom);?>
        </div>
        <hr>
        <div>
            <? print_r($direccionTo);?>
        </div>
    </div>

<hr>

    <div>
        <ul>
        <?php foreach($details as $item):?>
            <li>
                <?=$item['id_evento']?>
                <?=$item['fch_evento']?>
                <strong><?=$item['txt_evento']?></strong>
                <?=$item['txt_lugar']?>
            </li>
        <?php endforeach;?>
        </ul>
    </div>

    <?php


?>