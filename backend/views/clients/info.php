<?php

use backend\components\UrlExtended;
use common\models\Client;
use yii\web\View;
use yii\helpers\Json;

/* @var Client $client */

$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Alle Clients</span>',
    'url' => UrlExtended::toRoute(['clients/alle']),
    'class' => 'm-nav__link',
];

$this->params['breadcrumbs'][] = $this->title = "{$client->name}";

$json = Json::encode([
    'url_to_show' => UrlExtended::toRoute(['clients/detaljer']),
    'url_to_property' => UrlExtended::toRoute(['oppdrag/detaljer']),
    'action' => Yii::getAlias('@web') . '/clients/client-leads-table?'
        . http_build_query(
            ['client_id' => $client->id]
        )
]);

$this->registerJs(
    'window.DATA_TABLE = ' . $json . ';',
    View::POS_HEAD,
    'window.DATA_TABLE'
);

$this->registerJsFile('@web/js/datatables/datatable.js');
$this->registerJsFile('@web/js/datatables/client-leads.js');
?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="row">
            <div class="col-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    <span class="schala-status">
                                        <span class="m-badge m-badge-xxl m-badge--dot schala-type-<?= $client->status ?>"></span>
                                        <em><?= $client->status ?></em>
                                    </span>
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">

                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-section__content">
                            <table class="table m-table m-table--head-no-border table-hover">
                                <tbody>
                                <tr>
                                    <th scope="row">Navn</th>
                                    <td><?= $client->name ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Phone</th>
                                    <td><a href="tel:<?= $client->phone ?>"><?= $client->phone ?></a></td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td><a href="mailto:<?= $client->email ?>"><?= $client->email ?></a></td>
                                </tr>
                                <tr>
                                    <th scope="row">Siste kontakt</th>
                                    <td>
                                        <span><?= strftime('%d. %h %Y %H:%M', $client->last_contact) ?></span>
                                        <span class="timeago" data-moment="<?= $client->last_contact ?>"></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h2 class="m-portlet__head-text text-white">
                                    Leads
                                </h2>
                            </div>
                        </div>

                        <div class="m-portlet__head-tools"></div>
                    </div>

                    <div class="m-portlet__body">
                        <div class="m-section__content">
                            <table id="data-table" class="table table-striped table-bordered"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
