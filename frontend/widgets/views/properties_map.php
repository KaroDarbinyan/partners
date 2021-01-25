<?php

use yii\web\View;

/* @var View $this */
/* @var string $apiKey */
/* @var string $callbackFunction */
/* @var bool $needActivation */
/* @var string $height */

$this->registerJsFile('@web/js/properties-map-filter.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => View::POS_READY], 'propertiesMapFilter');
$this->registerJsFile("//maps.google.com/maps/api/js?key={$apiKey}&language=no&callback={$callbackFunction}", ['depends' => 'propertiesMapFilter']);

$input = Yii::$app->request->get();

$radiusValues = [100, 200, 300, 400, 500, 1000, 2000, 3000, 5000, 10000, 15000, 20000, 30000, 40000, 50000, 100000, 200000];

$active = !$needActivation || (isset($input['circle']) && isset($input['circle']['enable']));

?>

<div class="form-group">
    <input
            type="checkbox"
            id="filter_map_enable"
            class="input_check css_thumbler"
            name="circle[enable]"
        <?= $active ? 'checked' : '' ?>
    >
    <label for="filter_map_enable" class="label_check mt-0">Aktiver kart</label>
    <div class="form-group mb-4">
        <input type="text" id="city" placeholder="Søk etter adresse eller sted">
    </div>
    <div class="map-container css_thumbler_target mb-4" id="map" style="height: <?= $height ?? '200px' ?>"></div>
</div>

<div class="form-group">
    <input id="filter_map_circle_radius" type="hidden" class="js-range-slider" name="circle[radius]"
           data-values="<?= join(',', $radiusValues) ?>"
           data-from="<?= array_search($input['circle']['radius'] ?? 1000, $radiusValues) ?>"
           data-extra-classes="is-km"
           data-block="<?= json_encode(!$active) ?>"
    >
    <label for="filter_map_circle_radius" class="d-flex justify-content-between">
        <span class="text-uppercase">AVSTAND</span>
        <span class="text-uppercase"></span>
    </label>
</div>

<input id="filter_map_latitude" type="hidden" name="circle[lat]" value="<?= $input['circle']['lat'] ?? 59.9139 ?>">
<input id="filter_map_longitude" type="hidden" name="circle[lon]" value="<?= $input['circle']['lon'] ?? 10.7522 ?>">
