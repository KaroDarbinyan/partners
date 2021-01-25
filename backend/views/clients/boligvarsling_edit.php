<?php

/* @var yii\web\View $this */

/* @var Boligvarsling $lead */
/* @var array $areas */

/* @var array $types */

use backend\components\UrlExtended;
use common\models\Boligvarsling;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\View;

$this->title = 'Boligvarsling redigere';

$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Boligvarsling</span>',
    'url' => UrlExtended::toRoute(['clients/boligvarsling']),
    'class' => 'm-nav__link',
];

$this->params['breadcrumbs'][] = 'Redigere';

$apiKey = Yii::$app->params['googleMapApiKey'] ?? '';

$this->registerJsFile('@web/js/boligvarsling.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => View::POS_READY], 'googleMapFilter');
$this->registerJsFile("//maps.google.com/maps/api/js?key={$apiKey}&callback=initMap", [
    'depends' => 'googleMapFilter',
    'async' => 'async',
    'defer' => 'defer'
]);

$radiusValues = [100, 200, 250, 300, 400, 500, 1000, 2000, 3000, 5000, 10000, 15000, 20000, 30000, 40000, 50000, 100000, 200000];

?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">
  <div class="m-content">
    <div class="row">
      <div class="col-lg-12">
        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
          <div class="m-portlet__body">
              <?php $form = ActiveForm::begin([
                  'id' => 'boligvarsling-edit',
                  'fieldConfig' => ['options' => ['tag' => false]],
                  'options' => ['class' => 'js-ajax-update']
              ]) ?>
            <div class="row">
              <div class="col-12 col-lg-6">
                <div class="form-group form-check">
                  <input
                          type="checkbox"
                          id="filter_map_enable"
                          class="form-check-input"
                          name="circle[enable]"
                      <?= $lead->map_lat ? 'checked' : '' ?>
                  >
                  <label for="filter_map_enable" class="form-check-label">Aktiver kart</label>
                </div>

                <div class="form-group">
                  <input class="form-control" type="text" id="city" placeholder="Søk etter adresse eller sted">
                </div>

                <div class="form-group">
                  <div class="map-container" id="map" style="width: 100%; height: 250px;"></div>
                </div>

                <div class="form-group">
                  <input id="filter_map_circle_radius" name="Boligvarsling[map_radius]" type="hidden"
                         class="js-range-slider"
                         data-values="<?= join(',', $radiusValues) ?>"
                         data-from="<?= array_search($lead->map_radius ?? '1000', $radiusValues) ?>"
                         data-extra-classes="is-km"
                         data-block="<?= json_encode(!$lead->map_lat) ?>">
                  <label for="filter_map_circle_radius" class="d-flex justify-content-between">
                    <span class="text-uppercase">AVSTAND</span>
                    <span class="text-uppercase"></span>
                  </label>
                </div>

                <input id="filter_map_latitude" type="hidden" name="Boligvarsling[map_lat]"
                       value="<?= $lead->map_lat ?? '' ?>">
                <input id="filter_map_longitude" type="hidden" name="Boligvarsling[map_lng]"
                       value="<?= $lead->map_lng ?? '' ?>">

                <input type="hidden" id="filter_map_coordinates" data-col-index="16" value="59.9139;10.7522;1000">

                <div class="form-group">
                  <input id="filter_price_range" type="hidden" class="js-range-slider" name="price_range"
                         data-type="double"
                         data-min="0"
                         data-max="10000000"
                         data-from="<?= $lead->cost_from ?>"
                         data-to="<?= $lead->cost_to ?>"
                         data-step="100000">
                  <label for="filter_price_range" class="d-flex justify-content-between">
                    <span class="text-uppercase">PRIS FRA</span>
                    <span class="text-uppercase">PRIS TIL</span>
                  </label>
                </div>

                <div class="form-group">
                  <input id="filter_area_range" type="hidden" class="js-range-slider" name="area_range"
                         data-type="double"
                         data-min="0"
                         data-max="300"
                         data-from="<?= $lead->area_from ?>"
                         data-to="<?= $lead->area_to ?>"
                         data-step="10">
                  <label for="filter_area_range" class="d-flex justify-content-between">
                    <span class="text-uppercase">KVM FRA</span>
                    <span class="text-uppercase">KVM TIL</span>
                  </label>
                </div>

                <div class="row">
                  <div class="col-5">
                    <div class="form-group">
                      <a class="pl-0"
                         data-toggle="collapse"
                         href="#filterCollapseAreas"
                         role="button"
                         aria-expanded="true"
                         aria-controls="filterCollapseAreas">
                        OMRÅDE <i class="fa" aria-hidden="true"></i>
                      </a>
                      <div class="collapse show pt-2" id="filterCollapseAreas">
                          <?php foreach ($areas as $key => $val): ?>
                            <div class="form-group form-check mb-1">
                              <input type="checkbox"
                                     id="filter_parent_area_<?= Inflector::slug($key) ?>"
                                     class="form-check-input"
                                     name="Boligvarsling[region][<?= $key ?>][]"
                                     value="<?= $key ?>" <?= isset($val['checked']) ? 'checked' : '' ?> <?= $lead->map_lat ? 'disabled' : '' ?>>
                              <label for="filter_parent_area_<?= Inflector::slug($key) ?>"
                                     class="form-check-label mt-0">
                                  <?= $key ?>
                              </label>
                                <?php if (count($val['area'])): ?>
                                  <div class="filter_parent_area_<?= Inflector::slug($key) ?> filter-dropdown mt-2"
                                      <?= !isset($val['checked']) ? 'style="display: none"' : '' ?>>
                                      <?php foreach ($val['area'] as $area => $prop): ?>
                                        <div class="form-group form-check mb-1">
                                          <input type="checkbox"
                                                 id="filter_area_<?= Inflector::slug($area) ?>"
                                                 class="form-check-input"
                                                 name="Boligvarsling[region][<?= $key ?>][]"
                                                 value="<?= $area ?>" <?= isset($prop['checked']) ? 'checked' : '' ?> <?= $lead->map_lat ? 'disabled' : '' ?>>
                                          <label for="filter_area_<?= Inflector::slug($area) ?>"
                                                 class="form-check-label mt-0">
                                              <?= $area ?>
                                          </label>
                                        </div>
                                      <?php endforeach ?>
                                  </div>
                                <?php endif ?>
                            </div>
                          <?php endforeach ?>
                        <div id="boligvarsling-region"></div>
                        <div class="help-block"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <a class="pl-0"
                         data-toggle="collapse"
                         href="#filterCollapseTypes"
                         role="button"
                         aria-expanded="true"
                         aria-controls="filterCollapseTypes">
                        BOLIGTYPE <i class="fa" aria-hidden="true"></i>
                      </a>
                      <div class="collapse show pt-2" id="filterCollapseTypes">
                          <?php foreach ($types as $key => $val): ?>
                            <div class="form-group form-check mb-1">
                              <input type="checkbox"
                                     id="filter_type_<?= Inflector::slug($key, '_') ?>"
                                     class="form-check-input"
                                     name="Boligvarsling[property_type][]"
                                     value="<?= $key ?>" <?= isset($val['checked']) ? 'checked' : '' ?>
                              <label for="filter_type_<?= Inflector::slug($key, '_') ?>" class="form-check-label mt-0">
                                  <?= Yii::t('app', $key) ?>
                              </label>

                                <?php if ($key === 'Hytte'): ?>
                                  <div class="filter_type_<?= Inflector::slug($key, '_') ?> filter-dropdown ml-5"
                                       style="display: none">
                                      <?php foreach (['inland', 'mountains', 'coast'] as $label): ?>
                                        <div class="form-group form-check mb-1">
                                          <input type="checkbox"
                                                 id="filter_criterions_<?= $label ?>"
                                                 class="form-check-input"
                                                 name="Boligvarsling[criterions][]"
                                                 value="<?= $label ?>">
                                          <label for="filter_criterions_<?= $label ?>" class="form-check-label mt-0">
                                              <?= Yii::t('app', $label) ?>
                                          </label>
                                        </div>
                                      <?php endforeach ?>
                                  </div>
                                <?php endif ?>

                                <?php if ($key === 'Alle Tomt'): ?>
                                  <div class="filter_type_<?= Inflector::slug($key, '_') ?> filter-dropdown mt-2"
                                       style="<?= isset($val['checked']) ? '' : 'display: none' ?>">
                                      <?php foreach (['Tomt', 'Hytte-tomt'] as $label): ?>
                                        <div class="form-group form-check mb-1">
                                          <input type="checkbox"
                                                 id="filter_type_<?= Inflector::slug($label, '_') ?>"
                                                 class="form-check-input"
                                                 name="Boligvarsling[property_type][]"
                                                 value="<?= $label ?>" <?= in_array($label, Json::decode($lead->property_type) ?? []) ? 'checked' : '' ?>>
                                          <label for="filter_type_<?= Inflector::slug($label, '_') ?>"
                                                 class="form-check-label mt-0">
                                              <?= Yii::t('app', $label) ?>
                                          </label>
                                        </div>
                                      <?php endforeach ?>
                                  </div>
                                <?php endif ?>
                            </div>
                          <?php endforeach ?>
                        <div id="boligvarsling-property_type"></div>
                        <div class="help-block"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <a class="pl-0"
                         data-toggle="collapse"
                         href="#filterCollapseRooms"
                         role="button"
                         aria-expanded="true"
                         aria-controls="filterCollapseRooms">
                        SOVEROM <i class="fa" aria-hidden="true"></i>
                      </a>
                      <div class="collapse show pt-2" id="filterCollapseRooms">
                          <?php for ($rooms = 1; $rooms < 6; $rooms++): ?>
                            <div class="form-group form-check mb-1">
                              <input type="checkbox"
                                     id="filter_rooms_<?= $rooms ?>"
                                     class="form-check-input"
                                     name="Boligvarsling[rooms][]"
                                     value="<?= $rooms ?>" <?= array_search($rooms, Json::decode($lead->rooms) ?? []) !== false ? 'checked' : '' ?>>
                              <label for="filter_rooms_<?= $rooms ?>" class="form-check-label mt-0">
                                  <?= $rooms >= 5 ? '5+' : $rooms ?>
                              </label>
                            </div>
                          <?php endfor ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-6">
                  <?= $form->field($lead, 'phone')
                      ->textInput(['class' => 'form-control', 'placeholder' => 'Telefon'])
                      ->label(false) ?>

                  <?= $form->field($lead, 'name')
                      ->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Navn'])
                      ->label(false) ?>

                  <?= $form->field($lead, 'email')
                      ->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'E-post'])
                      ->label(false) ?>

                  <?= $form->field($lead, 'subscribe', [
                      'template' => '{input} {label} {error}{hint}'
                  ])
                      ->checkbox(['class' => 'form-check-input-'], false)
                      ->label('Jeg ønsker å motta eiendomsrelatert informasjon (nyhetsbrev o.l.) på e-post', ['class' => 'form-check-label-'])
                  ?>

                  <?= $form->field($lead, 'agree', [
                      'template' => '{input} {label} {error}{hint}'
                  ])
                      ->checkbox(['class' => 'form-check-input-', 'checked' => true, 'disabled' => true], false)
                      ->label('Jeg har lest og godkjent <a href="/personvern" target="_blank">vilkårene</a>', ['class' => 'form-check-label-'])
                  ?>

                  <?= Html::submitButton('Update', ['class' => 'btn btn-default mt-4']) ?>
              </div>
            </div>
              <?php ActiveForm::end() ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
