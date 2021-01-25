<?php

/* @var $this yii\web\View */

/* @var $budsjett_table String */

use backend\assets\AppAsset;
use backend\components\UrlExtended;
use yii\helpers\Url;

$this->title = 'Budsjett';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/statistikk-personal.js',
    ['depends' => [AppAsset::className()]]);

?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <div class="m-content">
        <button type="button" class="btn video-btn mb-4" data-toggle="modal"
                data-src="https://player.vimeo.com/video/400425905" data-target="#myModalVideo">
            <i class="flaticon-warning"></i> Instruksjonsvideo
        </button>

        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs  m-tabs-line m-tabs-line--2x m-tabs-line--danger" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a href="<?= UrlExtended::toRoute(['statistikk/budsjett']); ?>"
                           class="nav-link m-tabs__link active">Budsjett</a>
                    </li>
                    <?php if (Yii::$app->user->identity->hasRole('superadmin')): ?>
                        <li class="nav-item m-tabs__item">
                            <a href="<?= UrlExtended::toRoute(['statistikk/salgssnitt']); ?>"
                               class="nav-link m-tabs__link">Salgssnitt</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- List -->
        <div class="row">

            <div class="col-lg-12">

                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__body">
                        <form id="budsjett-form">
                            <select name="year" class="selectpicker mt-3 mb-4 year"
                                    data-style="btn-success">
                                <?php $year = range(date('Y') + 1, 2015);
                                foreach ($year as $y):?>
                                    <option <?php if ($y == date('Y')) echo "selected = 'selected'"; ?>
                                            value="<?= $y; ?>"><?= $y; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <table class="table table-striped table-hover center td-first-left table-budsjett">
                                <thead>
                                <tr class="budsjett-head">
                                    <th data-sort-type="4" data-sort="navn">Navn</th>
                                    <th data-sort-type="4" data-sort="department.short_name">Office</th>
                                    <th data-sort-type="4" data-sort="budsjett.inntekt">Inntekt, nok</th>
                                    <th data-sort-type="4" data-sort="budsjett.snittprovisjon">Snittprovisjon, nok</th>
                                    <th data-sort-type="4" data-sort="budsjett.hitrate">Hitrate, %</th>
                                    <th data-sort-type="4" data-sort="budsjett.befaringer">Befaringer</th>
                                    <th data-sort-type="4" data-sort="budsjett.salg">Salg</th>
                                </tr>
                                </thead>
                                <tbody id="budsjett_table_body">
                                <?= $budsjett_table; ?>
                                </tbody>
                                <tfoot id="sum">
                                </tfoot>
                            </table>
                            <button class="mt-5 btn btn-success">Save</button>
                        </form>
                    </div>
                </div>


                <P>&nbsp;</p>
                <div style="padding: 2.2rem 2.2rem;">
                    <h5>KOMMENTARER</h5>
                    <p>
                    <table class="table table-auto-width td-padding-left table-hover">
                        <thead>
                        <tr>
                            <th>Navn</th>
                            <th>Beskrivelse</th>
                            <th>Type</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Inntekt</td>
                            <td>Provisjon 3000 + tilrettelegging 3030</td>
                            <td>manuelt</td>
                        </tr>
                        <tr>
                            <td>Snittprovisjon</td>
                            <td>Basert på siste år + forventning</td>
                            <td>manuelt</td>
                        </tr>
                        <tr>
                            <td>Hitrate</td>
                            <td>Prosentvis signering på befaring</td>
                            <td>manuelt</td>
                        </tr>
                        <tr>
                            <td>Befaringer</td>
                            <td>Salg / Hitrate * 100</td>
                            <td>automatisk</td>
                        </tr>
                        <tr>
                            <td>Salg</td>
                            <td>Inntekt / Snittprovisjon</td>
                            <td>automatisk</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>


    </div>
</div>

<button type="button" id="budsjett-modal-btn" class="btn btn-info btn-lg d-none" data-toggle="modal"
        data-target="#budsjett-modal"></button>
<div id="budsjett-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #2b2b2b">
            <div class="modal-body"></div>
            <div class="modal-footer" style="border-top: none">
                <button type="button" class="btn btn-default m--block-center" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>