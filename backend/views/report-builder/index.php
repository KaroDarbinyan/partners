<?php

/* @var $this yii\web\View */
/* @var $deps string */

$this->title = 'Report Builder';
$this->params['breadcrumbs'][] = $this->title;

use backend\assets\AppAsset;
use common\models\Forms;

$this->registerCssFile(Yii::$app->urlManager->baseUrl . '/css/report-builder/style.css', ['depends' => [AppAsset::className()]]);
$this->registerJsFile('https://www.amcharts.com/lib/4/core.js', ['depends' => [AppAsset::className()]]);
$this->registerJsFile('https://www.amcharts.com/lib/4/charts.js', ['depends' => [AppAsset::className()]]);
$this->registerJsFile('https://www.amcharts.com/lib/4/plugins/timeline.js', ['depends' => [AppAsset::className()]]);
$this->registerJsFile('https://www.amcharts.com/lib/4/plugins/bullets.js', ['depends' => [AppAsset::className()]]);
$this->registerJsFile('https://www.amcharts.com/lib/4/themes/animated.js', ['depends' => [AppAsset::className()]]);
$this->registerJsFile(Yii::$app->urlManager->baseUrl . '/js/report-builder/chart.js', ['depends' => [AppAsset::className()]]);

?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress- block-rapporter">
                    <div class="m-portlet__head-caption pl-3 pt-1 border-bottom border-success">
                        <!--                        dateRangePicker section begin-->
                        <div class="row rb_toolbar">
                            <div class="col-md-12">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <div class="w-100 p-0" id="daterange-btns">
                                        <button type="button" class="btn btn-sm btn-success"
                                                data-range-key="I dag"
                                                data-type="range-btn">I dag
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success"
                                                data-range-key="I går"
                                                data-type="range-btn">I går
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success"
                                                data-range-key="Denne uke"
                                                data-type="range-btn">Denne uke
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success"
                                                data-range-key="Forrige uke"
                                                data-type="range-btn">Forrige uke
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success"
                                                data-range-key="Denne mnd"
                                                data-type="range-btn">Denne mnd
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success"
                                                data-range-key="Forrige mnd"
                                                data-type="range-btn">Forrige mnd
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success"
                                                data-range-key="Hittil i år"
                                                data-type="range-btn">Hittil i år
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success"
                                                data-range-key="Sammenlagt"
                                                data-type="range-btn">Sammenlagt
                                        </button>
                                    </div>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button class="dateRangePicker btn btn-sm btn-success w-100"
                                            data-type="dateRangePicker">
                                        <i class="far fa-calendar-alt"></i>&nbsp;
                                        <span></span>
                                        <i class="fa fa-caret-down"></i>
                                    </button>

                                </div>
                            </div>
                        </div>
                        <!--                        dateRangePicker section end-->

                        <!--                        department and broker select section begin-->
                        <div class="row rb_toolbar">
                            <div class="col-md-4">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <select id="dept-select" class="selectpicker" data-size="10"
                                            data-style="form-control-sm btn btn-success">
                                    </select>
                                </div>
                                <div class="btn-group d-none" role="group" aria-label="Basic example">
                                    <select id="user-select" class="selectpicker" data-size="10"
                                            data-style="form-control-sm btn btn-success">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!--                        department and broker select section end-->
                        <!--                        add filter section begin-->
                        <div class="row rb_toolbar mb-2">
                            <div class="col-md-12">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <select id="dept-select" class="selectpicker dropright" data-size="10"
                                            data-style="dropright form-control-sm btn btn-success">
                                        <option value="">65456</option>
                                        <option value="">65456</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 dropright">
                                <button type="button" class="btn btn-sm btn-success rounded-circle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">+
                                </button>
                                <ul class="dropdown-menu ml-2">
                                    <li>
                                        <a role="option" class="dropdown-item" aria-disabled="false" tabindex="0"
                                           aria-selected="false">
                                            <span class=" bs-ok-default check-mark"></span>
                                            <span class="text">Carl Berner</span>
                                        </a>
                                    </li>
                                    <li><a role="option" class="dropdown-item" aria-disabled="false" tabindex="0"
                                           aria-selected="false">
                                            <span class=" bs-ok-default check-mark"></span>
                                            <span class="text">Kalbakken</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--                        add filter section end-->
                    </div>
                    <!--                     chart type change buttons section begin -->
                    <div class="m-portlet__body pt-4 pl-5 pb-0">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <span class="h3 mr-3">Визиты</span>
                            <button class="rounded-circle btn-success btn btn-sm ml-1 mr-1"
                                    title="Simple Column Chart"
                                    data-chart-type="simpleColumnChart"
                                    data-type="chart-type">
                                <i data-chart-type="simpleColumnChart" class="far fa-chart-bar"></i>
                            </button>
                            <button class="rounded-circle btn-success btn btn-sm ml-1 mr-1"
                                    title="Stacked Area Chart"
                                    data-chart-type="stackedAreaChart"
                                    data-chart="chart-type">
                                <i data-chart-type="stackedAreaChart" class="fas fa-chart-area"></i>
                            </button>
                            <button class="rounded-circle btn-success btn btn-sm ml-1 mr-1"
                                    title="Date Based Data Chart"
                                    data-chart-type="dateBasedDataChart"
                                    data-chart="chart-type">
                                <i data-chart-type="dateBasedDataChart" class="fas fa-chart-line"></i>
                            </button>
                            <button class="rounded-circle btn-success btn btn-sm ml-1 mr-1"
                                    title="Pie Chart"
                                    data-chart-type="pieChart"
                                    data-chart="chart-type">
                                <i data-chart-type="pieChart" class="fas fa-chart-pie"></i>
                            </button>
                        </div>
                    </div>
                    <!--                    chart type change buttons section end-->
                    <div class="chart-container w-100">
                        <img id="chart-loader"
                             src="<?= Yii::$app->urlManager->baseUrl . '/images/report-builder/loader.svg'; ?>">
                        <div id="chart-div" class="w-100 p-4"></div>
                    </div>
                    <div id="data-deps" class="m-hendelser mt-2 p-3"
                         data-deps="<?= htmlspecialchars($deps, ENT_QUOTES, 'UTF-8'); ?>">
                        <div class="row rb_toolbar">
                            <div class="col-md-12">
                                <div class="containeras">
                                    <div class="panel-group pt-2" id="accordion1">
                                        <div class="panel panel-default pb-0">
                                            <div class="panel-heading">
                                                <h5 class="panel-title">
                                                    <a class="accordion-toggle collapsed" data-toggle="collapse"
                                                       data-parent="#accordion1" href="#accordion1_1">Hot clients</a>
                                                </h5>
                                            </div>
                                            <div id="accordion1_1" class="panel-collapse collapse">
                                                <div class="panel-body pb-0 pt-1">
                                                    <?php foreach (Forms::getHotTypes() as $hotType): ?>
                                                        <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                                            <div class="form-group field-lead-i_agree required">
                                                                <label>
                                                                    <input type="checkbox" id="<?= $hotType; ?>"
                                                                           data-lead-type="<?= $hotType; ?>"
                                                                           class="custom-control-input"
                                                                           value="<?= $hotType; ?>">
                                                                    <span class="custom-control-label"><?= ucfirst($hotType); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default pb-0">
                                            <div class="panel-heading">
                                                <h5 class="panel-title">
                                                    <a class="accordion-toggle collapsed" data-toggle="collapse"
                                                       data-parent="#accordion1" href="#accordion1_2">Cold clients</a>
                                                </h5>
                                            </div>
                                            <div id="accordion1_2" class="panel-collapse collapse">
                                                <div class="panel-body pb-0 pt-1">
                                                    <?php foreach (Forms::getColdTypes() as $coldType): ?>
                                                        <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                                            <div class="form-group field-lead-i_agree required">
                                                                <label>
                                                                    <input type="checkbox" id="<?= $coldType; ?>"
                                                                           data-lead-type="<?= $coldType; ?>"
                                                                           class="custom-control-input"
                                                                           value="<?= $coldType; ?>">
                                                                    <span class="custom-control-label"><?= ucfirst($coldType); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
