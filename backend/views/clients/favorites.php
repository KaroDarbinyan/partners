<?php

/** @var $this yii\web\View */

use backend\components\UrlExtended;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;

$this->params['breadcrumbs'][] = $this->title = 'Favoritter';

$json = Json::encode([
    'url_to_detail' => UrlExtended::to(['clients/detaljer']),
    'url_to_create' => UrlExtended::to(['clients/create']),
    'action' => Yii::getAlias('@web') . '/clients/favorites-table?'
        . http_build_query(
            compact('office', 'user')
        ),
]);

$this->registerJs(
    'window.DATA_TABLE = ' . $json . ';',
    View::POS_HEAD,
    'window.DATA_TABLE'
);

$this->registerJsFile('@web/js/datatables/leads/favorites.js');

?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="row">
                        <div class="col-lg-12 pr-4">
                            <a href="<?= Url::toRoute('clients/create') ?>" class="btn btn-success mt-4 ml-4">Legg til ny client</a>
                            <button type="button" class="btn video-btn mt-4 ml-4" data-toggle="modal" data-src="https://player.vimeo.com/video/400560237" data-target="#myModalVideo">
                                <i class="flaticon-warning"></i> Instruksjonsvideo
                            </button>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <table id="data-table" class="table table-striped table-bordered"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->render('_log_modal') ?>
