<?php

/** @var $this \yii\web\View */


use frontend\assets\AppAsset;
use frontend\assets\BefaringAsset;
use yii\helpers\ArrayHelper;

$this->title = 'BEFARING';
$googleMapApiKey = Yii::$app->params["googleMapApiKey"];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('/css/befaring/oppdrag.css',
    ['depends' => [AppAsset::class, BefaringAsset::class]]);

$this->registerJsFile("//maps.google.com/maps/api/js?key={$googleMapApiKey}&callback=initMap&language=no", [
    'depends' => BefaringAsset::class,
    'async' => true, 'defer' => true
]);

$this->registerJsFile('js/befaring/detaljer.js',
    ['depends' => [BefaringAsset::class]]);

?>
<div class="dit-hjem">
    <div class="row">
        <div class="col-md-12">
            <ul class="about-tabs">
                <li class="about-tabs_item tab-active" href="#detaljer"><a href="#detaljer">Detaljer</a></li>
                <li class="about-tabs_item" href="#statistikk"><a href="#statistikk">Statistikk</a></li>
                <li class="about-tabs_item" href="#nabolagsprofil"><a href="#nabolagsprofil">Nabolagsprofil</a></li>
                <?= $property['propertyImage']['urlstorthumbnail'] ? '<li class="about-tabs_item" href="#bilder"><a href="#bilder">Bilder</a></li>' : ''; ?>
            </ul>
        </div>
    </div>
    <div class="row" style="padding-top: 20px;">
        <div class="col-md-6">
            <div id="map" style="height:calc(100vh - 165px); margin-bottom: 1%"></div>
            <label id="marker-filter">
                <div class="jq-checkbox styler checked" id="filter-checked">
                    <input type="checkbox" class="styler">
                </div>
                <span>Fjern filter</span>
            </label>
        </div>
        <div class="col-md-6" id="pd-info"
             data-json="<?= htmlentities(json_encode(ArrayHelper::toArray($property)), ENT_QUOTES, 'UTF-8'); ?>">
            <?= $this->render('detaljer/_property-info', compact('property', 'neighbours')); ?>
        </div>
    </div>
</div>

<div id="bilder-slider"></div>

