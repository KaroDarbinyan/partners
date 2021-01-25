<?php

/* @var $this yii\web\View */

/* @var $filters array */

use frontend\widgets\PropertiesMapWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

$mapEnable = ArrayHelper::getValue(Yii::$app->request->get(), 'circle.enable');
?>

<div class="sidebar">
  <h4>Filter</h4>

  <form id="properties-filters-form" method="post">
    <div class="form-group mb-3">
      <input aria-label="Tekstsøk" type="text" name="text" value="<?= $filters['text'] ?>" placeholder="Tekstsøk">
    </div>

      <?= PropertiesMapWidget::widget(['callbackFunction' => 'initMap']) ?>

    <div class="form-group mb-4">
      <a class="pl-0"
         data-toggle="collapse"
         href="#filterCollapseAreas"
         role="button"
         aria-expanded="true"
         aria-controls="filterCollapseAreas">
        OMRÅDE <i class="fa" aria-hidden="true"></i>
      </a>
      <div class="collapse show pt-2" id="filterCollapseAreas">
          <?php foreach ($filters['areas'] as $key => $val): ?>
            <input type="checkbox"
                   id="filter_parent_area_<?= Inflector::slug($key, '_') ?>"
                   class="input_check"
                   name="parent_area[<?= $key ?>][]"
                   value="<?= $key ?>" <?= isset($val['checked']) ? 'checked' : '' ?> <?= $mapEnable ? 'disabled' : '' ?>>
            <label for="filter_parent_area_<?= Inflector::slug($key, '_') ?>" class="label_check mt-0">
                <?= $key ?> <span class="counts"><?= $val['count'] ?></span>
            </label>
              <?php if (count($val['area'])): ?>
              <div class="filter_parent_area_<?= Inflector::slug($key, '_') ?> filter-dropdown filter-property-sub"
                   style="<?= isset($val['checked']) ? '' : 'display: none' ?>">
                  <?php foreach ($val['area'] as $area => $prop): ?>
                    <input type="checkbox"
                           id="filter_area_<?= Inflector::slug($area, '_') ?>"
                           class="input_check"
                           name="parent_area[<?= $key ?>][]"
                           value="<?= $area ?>" <?= isset($prop['checked']) ? 'checked' : '' ?> <?= $mapEnable ? 'disabled' : '' ?>>
                    <label for="filter_area_<?= Inflector::slug($area, '_') ?>" class="label_check mt-0">
                        <?= $area ?> <span class="counts"><?= $prop['count'] ?></span>
                    </label>
                  <?php endforeach ?>
              </div>
              <?php endif ?>
          <?php endforeach ?>
      </div>
    </div>

    <div class="form-group">
      <input id="filter_price_range" type="hidden" class="js-range-slider" name="price_range"
             data-type="double"
             data-min="<?= $filters['price_min'] ?>"
             data-max="<?= $filters['price_max'] ?>"
             data-from="<?= $filters['price_from'] ?>"
             data-to="<?= $filters['price_to'] ?>"
             data-step="100000">
      <label for="filter_price_range" class="d-flex justify-content-between">
        <span class="text-lowercase">PRIS FRA</span>
        <span class="text-lowercase">PRIS TIL</span>
      </label>
    </div>

    <div class="form-group mb-4">
      <input id="filter_area_range" type="hidden" class="js-range-slider" name="area_range"
             data-type="double"
             data-min="<?= $filters['area_min'] ?>"
             data-max="<?= $filters['area_max'] ?>"
             data-from="<?= $filters['area_from'] ?>"
             data-to="<?= $filters['area_to'] ?>"
             data-step="10">
      <label for="filter_area_range" class="d-flex justify-content-between">
        <span class="text-lowercase">KVM FRA</span>
        <span class="text-lowercase">KVM TIL</span>
      </label>
    </div>

    <div class="form-group mb-4">
      <a class="pl-0"
         data-toggle="collapse"
         href="#filterCollapseTypes"
         role="button"
         aria-expanded="true"
         aria-controls="filterCollapseTypes">
        BOLIGTYPE <i class="fa" aria-hidden="true"></i>
      </a>
      <div class="collapse show pt-2" id="filterCollapseTypes">
          <?php foreach ($filters['types'] as $key => $val): ?>
            <input type="checkbox"
                   id="filter_type_<?= Inflector::slug($key, '_') ?>"
                   class="input_check"
                   name="homeType[]"
                   value="<?= $key ?>"
                <?= isset($val['checked']) ? 'checked' : '' ?>>
            <label for="filter_type_<?= Inflector::slug($key, '_') ?>" class="label_check mt-0">
                <?= Yii::t('app', $key) ?>
            </label>
              <?php if ($key === 'Hytte'): ?>
              <div class="filter_type_<?= Inflector::slug($key, '_') ?> filter-dropdown filter-property-sub"
                   style="<?= isset($val['checked']) ? '' : 'display: none' ?>">
                  <?php foreach (['inland', 'mountains', 'coast'] as $label): ?>
                    <input type="checkbox"
                           id="filter_criterions_<?= $label ?>"
                           class="input_check"
                           name="criterions[]"
                           value="<?= $label ?>">
                    <label for="filter_criterions_<?= $label ?>" class="label_check mt-0">
                        <?= Yii::t('app', $label) ?>
                    </label>
                  <?php endforeach ?>
              </div>
              <?php endif ?>

              <?php if ($key === 'Alle Tomt'): ?>
              <div class="filter_type_<?= Inflector::slug($key, '_') ?> filter-dropdown filter-property-sub"
                   style="<?= isset($val['checked']) ? '' : 'display: none' ?>">
                  <?php foreach (['Tomt', 'Hytte-tomt'] as $label): ?>
                      <input type="checkbox"
                             id="filter_type_<?= Inflector::slug($label, '_') ?>"
                             class="input_check"
                             name="homeType[tomt][]"
                             value="<?= $label ?>"
                          <?= in_array($label, ArrayHelper::getValue(Yii::$app->request->get('homeType'), 'tomt', [])) ? 'checked' : '' ?> >
                    <label for="filter_type_<?= Inflector::slug($label, '_') ?>" class="label_check mt-0">
                        <?= Yii::t('app', $label) ?>
                    </label>
                  <?php endforeach ?>
              </div>
              <?php endif ?>
          <?php endforeach ?>
      </div>
    </div>

    <div class="form-group mb-4">
      <a class="collapsed pl-0"
         data-toggle="collapse"
         href="#filterCollapseTypesOfOwnership"
         role="button"
         aria-expanded="false"
         aria-controls="filterCollapseTypesOfOwnership">
        EIERFORM <i class="fa" aria-hidden="true"></i>
      </a>
      <div class="collapse pt-2" id="filterCollapseTypesOfOwnership">
          <?php foreach ($filters['types_of_ownership'] as $key => $val): ?>
            <input type="checkbox"
                   id="filter_types_of_ownership_<?= $key ?>"
                   class="input_check"
                   name="eierform[]"
                   value="<?= $key ?>"
                <?= isset($val['checked']) ? 'checked' : '' ?>>
            <label for="filter_types_of_ownership_<?= $key ?>" class="label_check mt-0">
                <?= $key ?>
            </label>
          <?php endforeach ?>
      </div>
    </div>

    <div class="form-group">
      <a class="collapsed pl-0"
         data-toggle="collapse"
         href="#filterCollapseRooms"
         role="button"
         aria-expanded="false"
         aria-controls="filterCollapseRooms">
        SOVEROM <i class="fa" aria-hidden="true"></i>
      </a>
      <div class="collapse pt-2" id="filterCollapseRooms">
          <?php foreach ($filters['rooms'] as $key => $val): ?>
            <input type="checkbox"
                   id="filter_rooms_<?= $key ?>"
                   class="input_check"
                   name="roomsCount[]"
                   value="<?= $key ?>"
                <?= isset($val['checked']) ? 'checked' : '' ?>>
            <label for="filter_rooms_<?= $key ?>" class="label_check mt-0">
                <?= $key >= 5 ? '5+' : $key ?>
            </label>
          <?php endforeach ?>
      </div>
    </div>

    <div class="form-group">
      <a class="collapsed pl-0"
         data-toggle="collapse"
         href="#filterCollapseCriterions"
         role="button"
         aria-expanded="false"
         aria-controls="filterCollapseCriterions">
        FASILITETER <i class="fa" aria-hidden="true"></i>
      </a>
      <div class="collapse pt-2" id="filterCollapseCriterions">
          <?php foreach ($filters['criterions'] as $val): ?>
            <input type="checkbox"
                   id="filter_criterions_<?= $val['iadnavn'] ?>"
                   class="input_check"
                   name="criterions[]"
                   value="<?= $val['iadnavn'] ?>"
                <?= isset($val['checked']) ? 'checked' : '' ?>>
            <label for="filter_criterions_<?= $val['iadnavn'] ?>" class="label_check mt-0">
                <?= Yii::t('app', $val['navn']) ?>
            </label>
          <?php endforeach ?>
      </div>
    </div>

    <!--<div class="form-group">
            <input type="checkbox"
                   id="filter_archives"
                   class="input_check"
                   name="archives"
                   value="true"
                <?= $filters['archives'] ? 'checked' : '' ?>>
            <label for="filter_archives" class="label_check mt-0">Arkiv</label>
        </div>-->

    <input id="filter_sort" type="hidden" name="sort" value="">
  </form>

  <div class="form-group mt-2">
    <a id="properties-filters-reset" href="#" class="order order_full text-uppercase" style="display: none">
      Tilbakestill filter
    </a>
  </div>
</div>
