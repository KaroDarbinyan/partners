<?php
/** @var $this View */
/** @var $formTypes array */
/** @var $propTypes array */

/** @var $model Forms */

use backend\widgets\GoogleMapWidget;
use common\models\Forms;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\UrlExtended;
use yii\helpers\Json;
use yii\web\View;
use backend\assets\AppAsset;
use yii\web\JqueryAsset;

//$googleMapApiKey = Yii::$app->params["googleMapApiKey"];

$json = Json::encode([
    'url_to_show' => UrlExtended::toRoute(['clients/detaljer']),
    'action' => Yii::getAlias('@web') . '/clients/potential-table',
    'route' => Yii::$app->controller->action->id,
]);

$this->registerJs(
    'window.DATA_TABLE = ' . $json . ';',
    View::POS_HEAD,
    'window.DATA_TABLE'
);

$this->registerJsFile('//cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-nb_NO.min.js', ['depends' => [
    AppAsset::class,
]]);

$formTypesOptions = $formTypesList = [];
foreach ($formTypes as $formType) {
    $formTypesList[$formType] = str_replace("_", " ", $formType);
    $formTypesOptions[$formType] = ["selected" => true];
}

//$this->registerJsFile("//maps.google.com/maps/api/js?key={$googleMapApiKey}&callback=initPotentialClientsMap", ['depends' => [
//    JqueryAsset::className(),
//    AppAsset::className(),
//], 'async' => true, 'defer' => true]);
//
//$this->registerJsFile('@web/js/potential-clients-map.js', ['depends' => [
//    JqueryAsset::className(),
//    AppAsset::className(),
//]]);

$this->registerJsFile('@web/js/datatables/potential-clients.js');
?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile m-portlet--body-progress">
            <button type="button" class="btn video-btn mt-4 ml-4" data-toggle="modal"
                    data-src="https://player.vimeo.com/video/400562177" data-target="#myModalVideo">
                <i class="flaticon-warning"></i> Instruksjonsvideo
            </button>
            <div class="m-portlet__body">
                <div class="row align-items-center">
                    <div class="col-12 order-2 col-md-6">
                        <?php $form = ActiveForm::begin([
                            'action' => ['clients/get-coord-map'],
                            'options' => [
                                'class' => 'ic_form forms',
                                'data-gmap-filter' => 'gmap-form',
                                'id' => 'data-table-filter',
                            ]
                        ]) ?>

                        <?= $form->field($model, 'type')->dropDownList($formTypesList,
                            [
                                'multiple' => 'multiple',
                                'class' => 'form-control selectpicker',
                                'data' => [
                                    'actions-box' => false,
                                    'col-index' => 1,
                                ],
                                'options' => $formTypesOptions
                            ]
                        )->label('Leadstype')
                        ?>

                        <div class="form-group field-forms-type">
                            <label class="control-label" for="forms-type">Eiendomstype</label>
                            <?= Html::dropDownList('property_type', null, $propTypes,
                                [
                                    'id' => 'forms-property_type',
                                    'multiple' => 'multiple',
                                    'class' => 'form-control selectpicker',
                                    'data' => [
                                        'actions-box' => false,
                                        'col-index' => 12,
                                    ],
                                ]
                            )
                            ?>
                        </div>

                        <?= $form->field($model, 'created_at')
                            ->hiddenInput(['class' => 'js-range-slider', 'data' => [
                                'type' => 'double',
                                'grid' => false,
                                'min' => 0,
                                'max' => 12,
                                'from' => 0,
                                'to' => 9,
                                'input-values-separator' => '-',
                                'step' => 1,
                                'postfix' => ' mnd',
                                'col-index' => 4,
                            ]])->label('Registrert')
                        ?>

                        <div class="form-group">
                            <label class="control-label" for="forms-type">Salgssum</label>
                            <?= Html::hiddenInput('price_range', null, [
                                'id' => 'forms-price_range',
                                'class' => 'js-range-slider',
                                'data' => [
                                    'type' => 'double',
                                    'grid' => false,
                                    'min' => 100000,
                                    'max' => 10000000,
                                    'from' => 100000,
                                    'to' => 6000000,
                                    'input-values-separator' => '-',
                                    'max-postfix' => '+',
                                    'step' => 100000,
                                    'col-index' => 13,
                                ]]);
                            ?>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="forms-type">Primærrom</label>
                            <?= Html::hiddenInput('area_range', null, [
                                'id' => 'forms-area_range',
                                'class' => 'js-range-slider',
                                'data' => [
                                    'type' => 'double',
                                    'grid' => false,
                                    'min' => 10,
                                    'max' => 200,
                                    'from' => 40,
                                    'to' => 100,
                                    'input-values-separator' => '-',
                                    'max-postfix' => '+',
                                    'step' => 5,
                                    'postfix' => ' m<sup>2</sup>',
                                    'col-index' => 14,
                                ]]);
                            ?>
                        </div>

                        <?= $form->field($model, 'post_number')
                            ->hiddenInput(['data' => [
                                'gmap-values' => 'gmap-form',
                                'col-index' => 15,
                            ]])->label(false)
                        ?>

                        <?php ActiveForm::end() ?>
                    </div>
                    <div class="col-12 order-1 col-md-6 order-md-2">
                        <div class="d-flex">
                            <span class="font-weight-bold font-size-16" data-gmap-count></span>
                        </div>
                        <div class="w-100 mb-2">
                            <?= GoogleMapWidget::widget([
                                'callback' => 'initMap',
                                'needActivation' => false,
                                'height' => '250px'
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-12 order-last">
                        <div class="data-table">
                            <table id="data-table" class="table table-striped table-bordered"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

