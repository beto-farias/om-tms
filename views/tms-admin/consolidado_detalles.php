<?php
    $direccionFrom = $item->idAlmacenOrigen;
    $direccionTo = $item->idAlmacenDestino;
    ?>

    <div>
       
        <?=$item->uddi?>
        <?=$item->txt_nombre?>
        <?=$item->idConsolidadoEstado->txt_nombre?>
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