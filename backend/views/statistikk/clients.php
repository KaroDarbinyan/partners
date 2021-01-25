<?php

/* @var $this yii\web\View */

/* @var $budsjett_table String */

use backend\assets\AppAsset;
use backend\components\UrlExtended;
use yii\helpers\Url;

$this->title = 'Clients';
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Statistikk</span>',
    'url' => ['/oppdrag/'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('https://www.amcharts.com/lib/4/core.js',
    ['depends' => [AppAsset::className()]]);
$this->registerJsFile('https://www.amcharts.com/lib/4/charts.js',
    ['depends' => [AppAsset::className()]]);
$this->registerJsFile('https://www.amcharts.com/lib/4/themes/animated.js',
    ['depends' => [AppAsset::className()]]);
$this->registerJsFile(Yii::$app->getUrlManager()->getBaseUrl() . '/js/statistikk-clients.js',
    ['depends' => [AppAsset::className()]]);

?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <div class="m-content">
        <button type="button" class="btn video-btn mb-4" data-toggle="modal"
                data-src="https://player.vimeo.com/video/400425905" data-target="#myModalVideo">
            <i class="flaticon-warning"></i> Instruksjonsvideo
        </button>

        <!-- List -->
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__body chart-body">
                        <div class="row d-none">
                            <p class="w-100 p-4 h2 text-center text-white">3RD PARTY BY SOURCE (No data)</p>
                            <div class="col-md-12" id="chart-div-1"></div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__body chart-body">
                        <div class="row d-none">
                            <p class="w-100 p-4 h2 text-center text-white">3RD PARTY BY OFFICE (No data)</p>
                            <div class="col-md-12" id="chart-div-2"></div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__body chart-body">
                        <div class="row d-none">
                            <p class="w-100 p-4 h2 text-center text-white">Hot clients by source (No data)</p>
                            <div class="col-md-12" id="chart-div-3"></div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__body chart-body">
                        <div class="row d-none">
                            <p class="w-100 p-4 h2 text-center text-white">Hot clients (No data)</p>
                            <div class="col-md-12" id="chart-div-4"></div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__body chart-body">
                        <div class="row d-none">
                            <p class="w-100 p-4 h2 text-center text-white">Cold clients (No data)</p>
                            <div class="col-md-12" id="chart-div-5"></div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__body chart-body">
                        <div class="row d-none">
                            <p class="w-100 p-4 h2 text-center text-white">Behandlede / Ubehandlede (No data)</p>
                            <div class="col-md-12" id="chart-div-6"></div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__body chart-body">
                        <div class="row d-none">
                            <p class="w-100 p-4 h2 text-center text-white">Kontorer / Meglere (No data)</p>
                            <div class="col-md-12" id="chart-div-7"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
