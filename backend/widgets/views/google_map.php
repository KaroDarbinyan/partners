<?php

use yii\web\View;

/* @var View $this */
/* @var string $apiKey */
/* @var string $callback */
/* @var string $width */
/* @var string $height */
/* @var bool $needActivation */

$this->registerJsFile('@web/js/google-map-filter.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => View::POS_READY], 'googleMapFilter');
$this->registerJsFile("//maps.google.com/maps/api/js?key={$apiKey}&language=no&callback={$callback}", ['depends' => 'googleMapFilter']);

$input = Yii::$app->request->get();

$radiusValues = [100, 200, 250, 300, 400, 500, 1000, 2000, 3000, 5000, 10000, 15000, 20000, 30000, 40000, 50000, 100000, 200000];

?>

<div class="form-group">
    <?php if ($needActivation): ?>
        <input
                type="checkbox"
                id="filter_map_enable"
                class="input_check css_thumbler"
                name="circle[enable]"
            <?= isset($input['circle']) && isset($input['circle']['enable']) ? 'checked' : '' ?>
        >
        <label for="filter_map_enable" class="label_check mt-0">Aktiver kart</label>
    <?php else: ?>
        <input type="checkbox" id="filter_map_enable" class="d-none" name="circle[enable]" checked />
    <?php endif ?>

    <div class="form-group mb-4">
        <input class="form-control" type="text" id="city" placeholder="Søk etter adresse eller sted">
    </div>
    <div class="map-container css_thumbler_target mb-4" id="map" style="width: <?= $width ?? '100%' ?>; height: <?= $height ?? '200px' ?>;"></div>
</div>

<div class="form-group">
    <input id="filter_map_circle_radius" type="hidden" class="js-range-slider"
           data-values="<?= join(',', $radiusValues) ?>"
           data-from="<?= array_search($input['circle']['radius'] ?? '1000', $radiusValues) ?>"
           data-extra-classes="is-km"
           data-block="<?= json_encode(!isset($input['circle']['enable']) && $needActivation) ?>"
    >
    <label for="filter_map_circle_radius" class="d-flex justify-content-between">
        <span class="text-uppercase">AVSTAND</span>
        <span class="text-uppercase"></span>
    </label>
</div>

<input type="hidden" id="filter_map_coordinates" data-col-index="16" value="59.9139;10.7522;1000">
