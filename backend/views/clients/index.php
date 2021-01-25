<?php

/** @var $this yii\web\View */
/** @var $title string */
/** @var $formTypes array */
/** @var $type string */
/** @var $partner string */
/** @var $office string */
/** @var $user string */

use backend\components\UrlExtended;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;
use common\models\User;

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
$form_type = Yii::$app->request->get('filter')[1] ?? null;
$lead_log_typer = Yii::$app->request->get('filter')[5] ?? null;
$user_name = $user ? User::findOne(['url' => $user])->navn : '';
$source = Yii::$app->request->get('filter')[7] ?? '';

$videoInstruction = 'https://player.vimeo.com/video/400560653';

if ($title === 'Cold clients') {
    $formTypes = array_merge($formTypes, ['ringeliste']);
    $videoInstruction = 'https://player.vimeo.com/video/400559074';
}

$json = Json::encode([
    'formTypes' => $formTypes,
    'url_to_show' => UrlExtended::toRoute(['clients/detaljer']),
    'action' => Yii::getAlias('@web') . '/clients/data-table?'
        . http_build_query(
            compact('type', 'partner', 'office', 'user', 'filter')
        ),
    'route' => Yii::$app->controller->action->id,
]);

$this->registerJs(
    'window.DATA_TABLE = ' . $json . ';',
    View::POS_HEAD,
    'window.DATA_TABLE'
);

$this->registerJsFile('@web/js/datatables/datatable.js');
$this->registerJsFile('@web/js/datatables/clients.js');

$type_arr = [
    '1002',
    '1014',
    '1001',
    '1004',
    '1005',
    '1013',
    'Ubehandlede',
    'Behandlede'
];

?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="row">
                        <div class="col-lg-12 pr-4">
                            <a href="<?= Url::toRoute('clients/create') ?>" class="btn btn-success mt-4 ml-4">Legg til ny client</a>
                            <button type="button" class="btn video-btn mt-4 ml-4" data-toggle="modal" data-src="<?= $videoInstruction ?>" data-target="#myModalVideo">
                                <i class="flaticon-warning"></i> Instruksjonsvideo
                            </button>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <form id="data-table-filter" class="mb-3" method="post" style="display: none">
                            <div class="form-row align-items-center">
                                <div class="col-sm mb-3">
                                    <select id="types" class="form-control form-control-sm" data-col-index="1">
                                        <option value="">Alle typer</option>
                                        <?php if (($title === 'Hot clients')): ?>
                                            <option <?= $form_type === "3rd party" ? 'selected' : ''; ?> class="text-capitalize" value="3rd party">3rd party</option>
                                            <option <?= $form_type === "Our own" ? 'selected' : ''; ?> class="text-capitalize" value="Our own">Our own</option>
                                        <?php endif; ?>
                                        <?php foreach ($formTypes as $type): ?>
                                            <option <?= $type === $form_type ? 'selected' : ''; ?> class="text-capitalize" value="<?= $type ?>">
                                                <?= str_replace('_', ' ', $type) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm mb-3">
                                    <input type="text" class="form-control form-control-sm"
                                           data-col-index="2"
                                           placeholder="Navn" aria-label="Navn">
                                </div>
                                <div class="col-sm mb-3">
                                    <input type="text" class="form-control form-control-sm daterange-picker"
                                           data-col-index="3"
                                           placeholder="Sist endret">
                                </div>
                                <div class="col-sm mb-3">
                                    <input type="text" class="form-control form-control-sm daterange-picker"
                                           data-col-index="4"
                                           placeholder="Registrert">
                                </div>
                                <div class="col-sm mb-3">
                                    <input type="text" class="form-control form-control-sm"
                                           data-col-index="5" value="<?= $user_name; ?>"
                                           placeholder="Megler">
                                </div>
                                <div class="col-sm mb-3">
                                    <input type="text" class="form-control form-control-sm"
                                           data-col-index="7"
                                           value="<?= $source; ?>"
                                           placeholder="Source">
                                </div>
                                <div class="col-sm mb-3">
                                    <select id="clientsLogType" class="form-control form-control-sm" data-col-index="6">
                                        <option value="" selected>Alle typer</option>
                                        <?php foreach ($type_arr as $type): ?>
                                            <option <?= $lead_log_typer === $type ? 'selected' : '' ?> value="<?= $type ?>">
                                                <?= Yii::t('lead_log', $type) ?>
                                            </option>
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

<?= $this->render('_log_modal') ?>
