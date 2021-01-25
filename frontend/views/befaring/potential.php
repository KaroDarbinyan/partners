<?php

use common\models\Forms;
use common\models\PropertyDetails;
use frontend\widgets\GoogleMapWidget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JqueryAsset;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var Forms $model */
/** @var array $formTypes */
/** @var array $propTypes */
/** @var array $salgssum */
/** @var PropertyDetails $property */

$this->title = 'Mulige kjøpere';

$this->params['breadcrumbs'][] = $this->title;

$googleMapApiKey = Yii::$app->params["googleMapApiKey"];

$json = Json::encode([
    'url_to_show' => '',
    'action' => Yii::getAlias('@web') . '/befaring/potential-table',
    'route' => Yii::$app->controller->action->id,
]);

$this->registerJs(
    'window.DATA_TABLE = ' . $json . ';',
    View::POS_HEAD,
    'window.DATA_TABLE'
);

$this->registerCssFile('//cdn.datatables.net/v/bs/dt-1.10.20/datatables.min.css');

$this->registerJsFile('//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js', ['depends' => [
    JqueryAsset::class,
]]);

$this->registerJsFile('//cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js', ['depends' => [
    JqueryAsset::class,
]]);

$this->registerJsFile('@web/js/datatables/potential-clients.js');

$types = ['Leilighet', 'Enebolig', 'Tomannsbolig', 'Rekkehus'];
$andre = ['Leilighet', 'Enebolig', 'Tomannsbolig', 'Hytte', 'Rekkehus'];
$property_type_selected = array_fill_keys(array_keys($propTypes), ['selected' => false]);

if ($property) {
    if (in_array($property->type_eiendomstyper, $types)) {
        foreach ($types as $item) $property_type_selected[$item]['selected'] = true;
    } else if ($property->type_eiendomstyper === 'Hytte') {
        $property_type_selected[$property->type_eiendomstyper]['selected'] = true;
    } else if (!in_array($property->type_eiendomstyper, $andre)) {
        $property_type_selected['Andre']['selected'] = true;
    }
}

?>

<div class="potential-clients">
    <div class="row">
        <div class="col-md-12">
            <ul class="about-tabs" role="tablist">
                <li role="presentation" class="about-tabs_item tab-active">
                    <a href="#filter" role="tab">Filter</a>
                </li>
                <li role="presentation" class="about-tabs_item">
                    <a href="#table" class="show-table" role="tab">
                        Mulige kjøpere <span class="potential-clients-count badge"></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div role="tabpanel" id="filter" class="tab-content" style="padding-top: 20px;">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <?= GoogleMapWidget::widget([
                    'mapScript' => '@web/js/potential-clients-map.js',
                    'callback' => 'initMap',
                    'needActivation' => false,
                    'height' => '528px',
                    'dataTablesCoordinatesIndex' => 10,
                    'radius' => 5000,
                    'coordinate' => [
                            'lat' => $property->lat,
                            'lng' => $property->lng
                    ]
                ]) ?>
                <!--<div id="map" class="w-100 h-100" style="min-height: 528px"></div>-->
            </div>
            <div class="col-xs-12 col-md-6">
                <?php $form = ActiveForm::begin([
                    'action' => ['befaring/map-coords'],
                    'options' => [
                        'data-gmap-filter' => 'gmap-form',
                        'id' => 'data-table-filter',
                    ]
                ]) ?>

                <?= $form->field($model, 'type')->dropDownList($formTypes,
                    [
                        'multiple' => 'multiple',
                        'class' => 'form-control selectpicker mx-2',
                        'data' => [
                            'actions-box' => true,
                            'col-index' => 1,
                            'style' => 'btn-light'
                        ],
                        'options' => [
                            'visningliste' => ['selected' => true],
                            'salgsoppgave' => ['selected' => true],
                            'budvarsel' => ['selected' => true]
                        ]
                    ]
                )->label('Leadstype')
                ?>

                <div class="form-group field-forms-type">
                    <label class="control-label mx-2" for="forms-type">Eiendomstype</label>
                    <?= Html::dropDownList('property_type', null, $propTypes,
                        [
                            'id' => 'forms-property_type',
                            'multiple' => 'multiple',
                            'class' => 'form-control selectpicker',
                            'data' => [
                                'actions-box' => true,
                                'col-index' => 6,
                                'style' => 'btn-light'
                            ],
                            'options' => $property_type_selected
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
                        'postfix' => ' month',
                        'col-index' => 3,
                    ]])->label('Registrert', ['class' => 'mx-2'])
                ?>

                <div class="form-group">
                    <label class="control-label mx-2" for="forms-type">Salgssum</label>
                    <?= Html::hiddenInput('price_range', null, [
                        'id' => 'forms-price_range',
                        'class' => 'js-range-slider',
                        'data' => [
                            'type' => 'double',
                            'grid' => false,
                            'min' => $salgssum['min'],
                            'max' => $salgssum['max'],
                            'from' => $property && $property->salgssum ? $property->salgssum - $property->salgssum * 0.1 : 100000,
                            'to' => $property && $property->salgssum ? $property->salgssum + $property->salgssum * 0.1 : 6000000,
                            'input-values-separator' => '-',
                            'max-postfix' => '+',
                            'step' => 100000,
                            'col-index' => 7,
                        ]]);
                    ?>
                </div>

                <div class="form-group">
                    <label class="control-label mx-2" for="forms-type">Primærrom</label>
                    <?= Html::hiddenInput('area_range', null, [
                        'id' => 'forms-area_range',
                        'class' => 'js-range-slider',
                        'data' => [
                            'type' => 'double',
                            'grid' => false,
                            'min' => 10,
                            'max' => 200,
                            'from' => $property && $property->prom ? $property->prom - $property->prom * 0.3 : 40,
                            'to' => $property && $property->prom ? $property->prom + $property->prom * 0.3 : 100,
                            'input-values-separator' => '-',
                            'max-postfix' => '+',
                            'step' => 5,
                            'postfix' => ' m<sup>2</sup>',
                            'col-index' => 8,
                        ]]);
                    ?>
                </div>

                <?= $form->field($model, 'post_number')
                    ->hiddenInput(['data' => [
                        'gmap-values' => 'gmap-form',
                        'col-index' => 9,
                    ]])->label(false)
                ?>

                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>

    <div role="tabpanel" id="table" class="tab-content" style="display: none">
        <table id="data-table" class="table table-striped" style="width: 100%"></table>
    </div>
</div>

