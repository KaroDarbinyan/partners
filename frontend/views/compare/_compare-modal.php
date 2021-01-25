<?php

/** @var $property_details common\models\PropertyDetails */


use frontend\assets\AppAsset;



$this->registerJsFile('/js/eiendommer/compare.js?v=' . time(), [
    'depends' => AppAsset::className()
]);
$this->registerCssFile('/css/eiendommer/compare.css?v=' . time(), [
    'depends' => AppAsset::className()
]);


?>
<a href="#compare-popup" data-open-modal class="popup fade">compare-popup</a>

<div class="hide">
    <div class="pop lagre_ditt_sok padd-30" id="compare-popup">
        <div class="">
            <div class="tb_title">compare-popup</div>

            <div class="icf_l full-width">
                <div class="pl_keys">
                    <div class="pl_properties">
                        <div class="plp_l">
                            <ul class="list_prop">
                                <li>
                                    <span>Prisantydning:</span>
                                </li>
                                <li>
                                    <span>Omkostninger:</span>
                                </li>
                                <li>
                                    <span>Totalpris:</span>
                                </li>
                                <li>
                                    <span>Ligningsverdi:</span>
                                </li>
                                <li>
                                    <span>Type: </span>
                                </li>
                                <li>
                                    <span>Primærrom: </span>
                                </li>
                                <li>
                                    <span>Bruksareal: </span>
                                </li>
                                <li>
                                    <span>Bruttoareal: </span>
                                </li>
                                <li>
                                    <span>Etasje: </span>
                                </li>
                                <li>
                                    <span>Antall rom: </span>
                                </li>
                                <li>
                                    <span>Oppholdsrom: </span>
                                </li>
                                <li>
                                    <span>Soverom: </span>
                                </li>
                                <li>
                                    <span>Byggeår: </span>
                                </li>
                                <li>
                                    <span>Gårdsnummer: </span>
                                </li>
                                <li>
                                    <span>Bruksnummer: </span>
                                </li>
                                <li>
                                    <span>Sist endret: </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class=" pl_items carousel" data-flickity>
                <?php foreach ($property_details as $property_detail): ?>
                    <div class="carousel-cell pl_properties">
                        <div class="plp_l">
                            <ul class="list_prop">
                                <li>
                                    <span><?= number_format($property_detail["prisantydning"], 0, ' ', ' '); ?>,-</span>
                                </li>
                                <li>
                                    <span>15 435,-</span>
                                </li>
                                <li>
                                    <span>3 985 435,-</span>
                                </li>
                                <li>
                                    <span><?= number_format($property_detail["ligningsverdi"], 0, ' ', ' '); ?>,-</span>
                                </li>
                                <li>
                                    <span><?= $property_detail["type_eiendomstyper"]; ?></span>
                                </li>
                                <li>
                                    <span><?= number_format($property_detail["prom"], 0, ' ', ' '); ?> m²</span>
                                </li>
                                <li>
                                    <span><?= number_format($property_detail["bruksareal"], 0, ' ', ' '); ?> m²</span>
                                </li>
                                <li>
                                    <span><?= number_format($property_detail["bruttoareal"], 0, ' ', ' '); ?> m²</span>
                                </li>
                                <li>
                                    <span><?= $property_detail["etasje"]; ?></span>
                                </li>
                                <li>
                                    <span><?= $property_detail["antallrom"]; ?></span>
                                </li>
                                <li>
                                    <span><?= $property_detail["oppholdsrom"]; ?></span>
                                </li>
                                <li>
                                    <span><?= $property_detail["soverom"]; ?></span>
                                </li>
                                <li>
                                    <span><?= $property_detail["byggeaar"]; ?></span>
                                </li>
                                <li>
                                    <span><?= $property_detail["gaardsnummer"]; ?></span>
                                </li>
                                <li>
                                    <span><?= $property_detail["bruksnummer"]; ?></span>
                                </li>
                                <li>
                                    <span><?= date('d.m.y H:i', $property_detail["endretdato"]); ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="pop" id="lagre_ditt_sok_result">
        <form>
            <div class="iTAKK"></div>
            <div class="it_title">TAKK!</div>
            <div class="it_info">Du blir varslet på e-post, i appen på mobil og her på Schala.</div>
        </form>
    </div>

</div>