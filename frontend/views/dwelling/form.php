<?php

use common\models\Boligvarsling;
use frontend\widgets\PropertiesMapWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\web\Request;
use yii\web\View;

/** @var $this View */
/** @var $types array */
/** @var $formModel Boligvarsling */
/** @var $areas array */

?>

<?php $this->beginBlock('head') ?>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="BOLIGER SOM KOMMER FOR SALG"/>
    <meta property="og:description"
          content="Har du ikke funnet drømmeboligen enda? Sett opp et søk under og bli
           varslet på mail når aktuelle boliger dukker opp."/>
    <meta property="og:url" content="<?= Url::current([], true); ?>"/>
    <meta property="og:image" content="<?= Url::home(true); ?>img/property-default.jpg"/>
    <meta property="og:site_name" content="PARTNERS.NO"/>
<?php $this->endBlock() ?>

<?php $this->beginBlock('page_header') ?>
<header class="header">
  <div class="container">
      <?php $form = ActiveForm::begin(['id' => 'properties-notify-form']) ?>
    <div class="row">
      <div class="col-12 text-center">
        <h1><?= Yii::$app->view->params['header'] ?></h1>
        <h4>Har du ikke funnet drømmeboligen enda?<br> Sett opp et søk under og bli varslet på mail når aktuelle boliger
          dukker opp.</h4>
      </div>
      <div class="col-12 col-lg-6">
          <?= PropertiesMapWidget::widget([
              'callbackFunction' => 'initMap',
              'needActivation' => false,
              'height' => '565px',
          ]) ?>
      </div>
      <div class="col-12 col-lg-6">

        <div class="row">
          <div class="col">
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
                    <input type="checkbox"
                           id="filter_parent_area_<?= Inflector::slug($key) ?>"
                           class="input_check"
                           name="Boligvarsling[region][<?= $key ?>][]"
                           value="<?= $key ?>" disabled>
                    <label for="filter_parent_area_<?= Inflector::slug($key) ?>" class="label_check mt-0">
                        <?= $key ?>
                    </label>
                      <?php if (count($val['area'])): ?>
                      <div class="filter_parent_area_<?= Inflector::slug($key) ?> filter-dropdown ml-5"
                           style="display: none">
                          <?php foreach ($val['area'] as $area => $prop): ?>
                            <input type="checkbox"
                                   id="filter_area_<?= Inflector::slug($area) ?>"
                                   class="input_check"
                                   name="Boligvarsling[region][<?= $key ?>][]"
                                   value="<?= $area ?>" disabled>
                            <label for="filter_area_<?= Inflector::slug($area) ?>" class="label_check mt-0">
                                <?= $area ?>
                            </label>
                          <?php endforeach ?>
                      </div>
                      <?php endif ?>
                  <?php endforeach ?>
                <div id="boligvarsling-region"></div>
                <div class="help-block"></div>
              </div>
            </div>
          </div>
          <div class="col">
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
                    <input type="checkbox"
                           id="filter_type_<?= Inflector::slug($key, '_') ?>"
                           class="input_check"
                           name="Boligvarsling[property_type][]"
                           value="<?= $key ?>">
                    <label for="filter_type_<?= Inflector::slug($key, '_') ?>" class="label_check mt-0">
                        <?= Yii::t('app', $key) ?>
                    </label>

                      <?php if ($key === 'Hytte'): ?>
                      <div class="filter_type_<?= Inflector::slug($key, '_') ?> filter-dropdown ml-5"
                           style="display: none">
                          <?php foreach (['inland', 'mountains', 'coast'] as $label): ?>
                            <input type="checkbox"
                                   id="filter_criterions_<?= $label ?>"
                                   class="input_check"
                                   name="Boligvarsling[criterions][]"
                                   value="<?= $label ?>">
                            <label for="filter_criterions_<?= $label ?>" class="label_check mt-0">
                                <?= Yii::t('app', $label) ?>
                            </label>
                          <?php endforeach ?>
                      </div>
                      <?php endif ?>

                      <?php if ($key === 'Alle Tomt'): ?>
                      <div class="filter_type_<?= Inflector::slug($key, '_') ?> filter-dropdown ml-5"
                           style="<?= isset($val['checked']) ? '' : 'display: none' ?>">
                          <?php foreach (['Tomt', 'Hytte-tomt'] as $label): ?>
                            <input type="checkbox"
                                   id="filter_type_<?= Inflector::slug($label, '_') ?>"
                                   class="input_check"
                                   name="tomt[]"
                                   value="<?= $label ?>">
                            <label for="filter_type_<?= Inflector::slug($label, '_') ?>" class="label_check mt-0">
                                <?= Yii::t('app', $label) ?>
                            </label>
                          <?php endforeach ?>
                      </div>
                      <?php endif ?>
                  <?php endforeach ?>
                <div id="boligvarsling-property_type"></div>
                <div class="help-block"></div>
              </div>
            </div>
          </div>
          <div class="col">
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
                    <input type="checkbox"
                           id="filter_rooms_<?= $rooms ?>"
                           class="input_check"
                           name="Boligvarsling[rooms][]"
                           value="<?= $rooms ?>">
                    <label for="filter_rooms_<?= $rooms ?>" class="label_check mt-0">
                        <?= $rooms >= 5 ? '5+' : $rooms ?>
                    </label>
                  <?php endfor ?>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <input id="filter_price_range" type="hidden" class="js-range-slider" name="price_range"
                 data-type="double"
                 data-min="0"
                 data-max="10000000"
                 data-from="0"
                 data-to="10000000"
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
                 data-from="0"
                 data-to="300"
                 data-step="10">
          <label for="filter_area_range" class="d-flex justify-content-between">
            <span class="text-uppercase">KVM FRA</span>
            <span class="text-uppercase">KVM TIL</span>
          </label>
        </div>

          <?php $form = ActiveForm::begin(['id' => 'boligvarsling-form',
              'fieldConfig' => [
                  'options' => [
                      'tag' => false
                  ],
              ],
              'options' => [
                  'class' => 'properties-form'
              ]]) ?>

          <?= $form->field($formModel, 'domain', ['errorOptions' => ['tag' => null]])
              ->hiddenInput(['class' => false, 'value' => (new Request)->getServerName()])
              ->label(false) ?>

          <?= $form->field($formModel, 'phone')
              ->textInput(['class' => 'styler', 'placeholder' => 'Telefon'])
              ->label(false) ?>

          <?= $form->field($formModel, 'name')
              ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'Navn'])
              ->label(false) ?>

          <?= $form->field($formModel, 'email')
              ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'E-post'])
              ->label(false) ?>

          <?= $form->field($formModel, 'subscribe', [
              'template' => '{input} {label} {error}{hint}'
          ])
              ->checkbox(['class' => 'input_check', 'checked' => true], false)
              ->label('Jeg ønsker å motta eiendomsrelatert informasjon (nyhetsbrev o.l.) på e-post', ['class' => 'label_check'])
          ?>

          <?= $form->field($formModel, 'agree', [
              'template' => '{input} {label} {error}{hint}'
          ])
              ->checkbox(['class' => 'input_check'], false)
              ->label('Jeg har lest og godkjent <a href="/personvern" target="_blank">vilkårene</a>', ['class' => 'label_check'])
          ?>

          <?= Html::submitButton('Send', ['class' => 'order mt-4']) ?>
          <?php ActiveForm::end() ?>
      </div>
    </div>
      <?php ActiveForm::end() ?>
  </div>
</header>
<?php $this->endBlock() ?>
