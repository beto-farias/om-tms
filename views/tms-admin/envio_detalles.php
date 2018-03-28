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
        <ul>
        <?foreach($item->relEnviosAtributos as $attr):?>
            <li><?=$attr->idEnvioAtributo->txt_nombre?>: <?=$attr->txt_valor?></li>
        <?endforeach;?>
        </ul>
        <hr>
        <div>
           
            <?=$direccionFrom->uddi?>
            <?=$direccionFrom->txt_calle?>
            <?=$direccionFrom->txt_numero_exterior?>
            <?=$direccionFrom->txt_numero_interior?>
            <?=$direccionFrom->txt_colonia?>
            <?=$direccionFrom->txt_municipio?>
            <?=$direccionFrom->txt_estado?>
            <?=$direccionFrom->txt_pais?>
            <?=$direccionFrom->txt_cp?>
            <?=$direccionFrom->txt_referencia?>
            
        </div>
        <hr>
        <div>
            <?=$direccionTo->uddi?>
            <?=$direccionTo->txt_calle?>
            <?=$direccionTo->txt_numero_exterior?>
            <?=$direccionTo->txt_numero_interior?>
            <?=$direccionTo->txt_colonia?>
            <?=$direccionTo->txt_municipio?>
            <?=$direccionTo->txt_estado?>
            <?=$direccionTo->txt_pais?>
            <?=$direccionTo->txt_cp?>
            <?=$direccionTo->txt_referencia?>
        </div>
    </div>

<hr>

    <div>
        <ul>
        <?php foreach($details as $item):?>
            <li>
                <?=$item['id_evento']?>
                [<?=$item['txt_tipo']?>]
                <?=$item['fch_evento']?>
                <strong><?=$item['txt_evento']?></strong>
                <?=$item['txt_lugar']?>
            </li>
        <?php endforeach;?>
        </ul>
    </div>

    <?php


?>