<?php

/** @var $this yii\web\View */

use backend\components\UrlExtended;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'Boligvarsling';
$this->params['breadcrumbs'][] = $this->title;

$json = Json::encode([
    'url_to_show' => Url::toRoute(['clients/boligvarsling']),
    'action' => Yii::getAlias('@web') . '/clients/boligvarsling-table',
]);

$this->registerJs(
    'window.DATA_TABLE = ' . $json . ';',
    View::POS_HEAD,
    'window.DATA_TABLE'
);

$this->registerJsFile('@web/js/datatables/boligvarsling.js');

?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__body">
                        <table id="boligvarsling-datatable" class="table table-striped table-bordered"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
