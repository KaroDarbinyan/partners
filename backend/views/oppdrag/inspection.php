<?php

/* @var $this yii\web\View */
/* @var $type string */
/* @var $office string */
/* @var $user string */
/* @var $departments Department[] */

use backend\components\UrlExtended;
use common\models\Department;
use yii\helpers\Json;
use yii\web\View;

$this->params['breadcrumbs'][] = $this->title;

$json = Json::encode([
    'url_to_show' => UrlExtended::toRoute(['oppdrag/detaljer']),
    'action' => Yii::getAlias('@web') . '/oppdrag/data-table?'
        . http_build_query(
            compact('type', 'office', 'partner', 'user')
        ),
]);

$this->registerJs(
    'window.DATA_TABLE = ' . $json . ';',
    View::POS_HEAD,
    'window.DATA_TABLE'
);

$this->registerJsFile('@web/js/datatables/datatable.js');
$this->registerJsFile('@web/js/datatables/properties/inspection.js');

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
                                           placeholder="Adresse">
                                </div>
                                <div class="col-sm mb-3">
                                    <input type="text" class="form-control form-control-sm daterange-picker"
                                           data-col-index="7"
                                           placeholder="Registrert">
                                </div>
                                <div class="col-sm mb-3">
                                    <input type="text" class="form-control form-control-sm daterange-picker"
                                           data-col-index="8"
                                           placeholder="Sist endret">
                                </div>
                                <div class="col-sm mb-3">
                                    <input type="text" class="form-control form-control-sm daterange-picker"
                                           data-col-index="9"
                                           placeholder="Markedsforingsdato">
                                </div>
                                <div class="col-sm mb-3">
                                    <input type="text" class="form-control form-control-sm daterange-picker"
                                           data-col-index="10"
                                           placeholder="Salgsdato">
                                </div>

                                <div class="col-sm mb-3">
                                    <input type="text" class="form-control form-control-sm"
                                           data-col-index="12"
                                           placeholder="Megler">
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
