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

        <!-- List -->
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__body" id="chart-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
