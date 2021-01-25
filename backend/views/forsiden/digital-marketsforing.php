<?php
/* @var $this yii\web\View */

use backend\assets\AppAsset;

$this->title = 'Digital markedsføring';
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Forsiden</span>',
    'url' => ['/forsiden/'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = $this->title;


$this->registerJsFile('https://www.amcharts.com/lib/4/core.js',
    ['depends' => [AppAsset::className()]]);
$this->registerJsFile('https://www.amcharts.com/lib/4/charts.js',
    ['depends' => [AppAsset::className()]]);
$this->registerJsFile('https://www.amcharts.com/lib/4/themes/animated.js',
    ['depends' => [AppAsset::className()]]);
$this->registerJsFile(Yii::$app->getUrlManager()->getBaseUrl() . '/js/forsiden.js',
    ['depends' => [AppAsset::className()]]);
?>
<!--<script src="https://www.amcharts.com/lib/4/core.js"></script>-->
<!--<script src="https://www.amcharts.com/lib/4/charts.js"></script>-->
<!--<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>-->
<div data-dynamic-content="main-content" style="color: white; flex: 1; max-width: 100%;">

    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-content">
            <h1 class="forsiden-header">DIGITAL MARKEDSFØRING</h1>
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-portlet m-portlet--mobile">
                        <div class="m-portlet__head forsiden-head">
                            <p class="w-100 p-4 h2 text-center">PERIODE 22. juli - 29. juli 2019.</p>
                        </div>
                        <div class="m-portlet__body m--block-center forsiden">
                            <div class="row">
                                <div class="col-md-8 offset-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <b>38</b>
                                            <p>klikk</p>
                                        </div>
                                        <div class="col-md-4">
                                            <b>696</b>
                                            <p>visninger</p>
                                        </div>
                                        <div class="col-md-4">
                                            <b>689</b>
                                            <p>unike visninger</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row p-5">
                                <div class="col-md-6 p-5">
                                    <div id="pieChartDiv"></div>
                                </div>
                                <div class="col-md-6 p-5">
                                    <div id="columnChartDiv"></div>
                                </div>
                            </div>

                        </div>
                        <table class="table table-hover forsiden-table">
                            <thead>
                            <tr>
                                <th class="text-left pl-5">KLIDE</th>
                                <th>KLIKK</th>
                                <th>VISNINGER</th>
                                <th>UNIKE VISNINGER</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-left"><i class="socicon-facebook mr-3 pl-4"></i>Facebook</td>
                                <td>xx</td>
                                <td>xxx</td>
                                <td>xxx</td>
                            </tr>
                            <tr>
                                <td class="text-left"><i class="socicon-instagram  mr-3 pl-4"></i>Instagram</td>
                                <td>xx</td>
                                <td>xxx</td>
                                <td>xxx</td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-left pl-5">TOTALT</th>
                                <th>xx</th>
                                <th>xxx</th>
                                <th>xxx</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



