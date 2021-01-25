<?php

/** @var $this yii\web\View */

/** @var $id int */

/** @var $formTypes array */

use backend\components\UrlExtended;
use yii\helpers\Json;
use yii\web\View;

$this->title = 'Interessenter';
$this->params['breadcrumbs'][] = $this->title;

$json = Json::encode([
    'formTypes' => $formTypes,
    'url_to_show' => UrlExtended::toRoute(['clients/detaljer']),
    'action' => Yii::getAlias('@web') . '/oppdrag/interessenter-data-table?'
        . http_build_query(
            ['target_id' => $id]
        ),
]);

$this->registerJs(
    'window.DATA_TABLE = ' . $json . ';',
    View::POS_HEAD,
    'window.DATA_TABLE'
);

$this->registerJsFile('@web/js/datatables/datatable.js');
$this->registerJsFile('@web/js/datatables/interessenter.js');

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
                                    <select id="types" class="form-control form-control-sm" data-col-index="1">
                                        <option value="" selected>Alle typer</option>
                                        <?php foreach ($formTypes as $type): ?>
                                            <option class="text-capitalize" value="<?= $type ?>">
                                                <?= str_replace('_', ' ', $type) ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-sm mb-3">
                                    <input type="text" class="form-control form-control-sm"
                                           data-col-index="2"
                                           placeholder="Navn" aria-label="Navn">
                                </div>
                                <div class="col-sm mb-3">
                                    <input type="text" class="form-control form-control-sm"
                                           data-col-index="3"
                                           placeholder="Source">
                                </div>
                                <div class="col-sm mb-3">
                                    <input type="text" class="form-control form-control-sm daterange-picker"
                                           data-col-index="4"
                                           placeholder="Registrert">
                                </div>
                                <div class="col-sm mb-3">
                                    <input type="text" class="form-control form-control-sm daterange-picker"
                                           data-col-index="5"
                                           placeholder="Sist endret">
                                </div>
                                <div class="col-sm mb-3">
                                    <input type="text" class="form-control form-control-sm"
                                           data-col-index="7"
                                           placeholder="Megler">
                                </div>
                                <div class="col-sm mb-3">
                                    <select class="form-control form-control-sm" data-col-index="6">
                                        <option value="" selected>Alle typer</option>
                                        <?php foreach (['1002', '1014', '1001', '1004', '1005', '1013', 'Ubehandlede'] as $type): ?>
                                            <option value="<?= $type ?>"><?= Yii::t('lead_log', $type) ?></option>
                                        <?php endforeach ?>
                                    </select>
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