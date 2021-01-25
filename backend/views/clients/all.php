<?php

/** @var $this yii\web\View */

use backend\components\UrlExtended;
use yii\helpers\Json;
use yii\web\View;

$this->params['breadcrumbs'][] = $this->title = 'Alle Clients';

$json = Json::encode([
    'url_to_show' => UrlExtended::toRoute(['clients/info']),
    'action' => Yii::getAlias('@web') . '/clients/clients-table?'
        . http_build_query(
            compact('office', 'user')
        ),
]);

$this->registerJs(
    'window.DATA_TABLE = ' . $json . ';',
    View::POS_HEAD,
    'window.DATA_TABLE'
);

$this->registerJsFile('@web/js/datatables/datatable.js');
$this->registerJsFile('@web/js/datatables/clients-all.js');

?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__body">
                        <form id="data-table-filter" class="mb-3" method="post" style="display: none">
                            <div class="form-row align-items-center">
                                <div class="col-sm mb-3">
                                    <input type="text" class="form-control form-control-sm"
                                           data-col-index="2"
                                           placeholder="Navn" aria-label="Navn">
                                </div>
                                <div class="col-sm mb-3 d-flex">
                                    <button type="submit" class="btn btn-default btn-sm">
                                        <i class="la la-search text-white"></i> Søk
                                    </button>
                                    <button type="reset" class="btn btn-secondary btn-sm ml-2">
                                        <i class="la la-close text-white"></i> Fjern filter
                                    </button>
                                </div>
                            </div>
                        </form>

                        <table id="data-table" class="table table-striped table-bordered"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>