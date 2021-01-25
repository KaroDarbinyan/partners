<?php

/** @var $this yii\web\View */

use backend\components\UrlExtended;
use yii\helpers\Json;
use yii\web\View;

$this->params['breadcrumbs'][] = $this->title = 'Ringeliste';

$json = Json::encode([
    'url_to_show' => UrlExtended::toRoute(['clients/detaljer']),
    'url_to_create' => UrlExtended::toRoute(['clients/create']),
    'action' => Yii::getAlias('@web') . '/clients/calling-list-table?'
        . http_build_query(
            compact('partner', 'office', 'user')
        ),
    'user_id' => Yii::$app->user->identity->web_id
]);

$this->registerJs(
    'window.DATA_TABLE = ' . $json . ';',
    View::POS_HEAD,
    'window.DATA_TABLE'
);

$this->registerJsFile('@web/js/datatables/leads/calling-list.js');

?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <button type="button" class="btn video-btn mt-4 ml-4" data-toggle="modal" data-src="https://player.vimeo.com/video/400563188" data-target="#myModalVideo">
                        <i class="flaticon-warning"></i> Instruksjonsvideo
                    </button>
                    <div class="m-portlet__body">
                        <form id="data-table-filter" class="mb-3" method="post" style="display: none">
                            <div class="form-row align-items-center">
                                <div class="col-sm mb-3">
                                    <select class="form-control form-control-sm" data-col-index="6">
                                        <option value="">Alle</option>
                                        <option value="pers">Min</option>
                                        <option value="kontor">Kontor</option>
                                        <option value="felles">Felles</option>
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

<div class="modal fade show" id="interested_modal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Loggføring</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="m-accordion m-accordion--bordered m-accordion--solid" role="tablist">
                        <form id="interested-form" method="post">
                            <input type="hidden" id="lead-id" class="form-control" name="id">

                            <div class="form-group jq-selectbox styler">
                                <label class="control-label" for="lead-log-type">Type</label>
                                <select id="lead-log-type" class="form-control styler is-logs-type" name="type" aria-required="true" aria-invalid="false">
                                    <option value="1014">Påminnelse</option>
                                    <option value="1020">Vunnet</option>
                                    <?php /* <option value="Tapt">Tapt</option> */ ?>
                                    <option value="1011">Har tatt kontakt</option>
                                    <?php /* <option value="Får ikke kontakt">Får ikke kontakt</option> */ ?>
                                    <option value="1008">Avtalt befaring</option>
                                    <option value="1018">Utført befaring</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="lead-log-message">Message</label>
                                <textarea id="lead-log-message" class="form-control styler" name="message"></textarea>
                            </div>

                            <div class="form-group is-for-notify">
                                <label class="control-label" for="lead-log-notify_at">Notify At</label>
                                <input type="text" id="lead-log-notify_at" class="form-control styler is-datetimepicker" name="notify_at" autocomplete="off">
                            </div>

                            <div class="form-group" style="display: none">
                                <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                                    <input class="favorite-checkbox" type="checkbox" name="favorite" checked>
                                    Legg til favoritter
                                    <span></span>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-dark">Ferdig</button>
                        </form>
                    </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>