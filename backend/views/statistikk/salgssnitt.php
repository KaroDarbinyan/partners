<?php

/* @var $this yii\web\View */
/* @var $models common\models\Salgssnitt */

$this->title = 'Salgssnitt';

$this->params['breadcrumbs'][] = $this->title;

use backend\components\UrlExtended; ?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <div class="m-content">
        <button type="button" class="btn video-btn mb-4" data-toggle="modal" data-src="https://player.vimeo.com/video/400425905" data-target="#myModalVideo">
            <i class="flaticon-warning"></i> Instruksjonsvideo
        </button>

        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs  m-tabs-line m-tabs-line--2x m-tabs-line--danger" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a href="<?= UrlExtended::toRoute(['statistikk/budsjett']); ?>"
                           class="nav-link m-tabs__link">Budsjett</a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a href="<?= UrlExtended::toRoute(['statistikk/salgssnitt']); ?>"
                           class="nav-link m-tabs__link active">Salgssnitt</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- List -->
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__body">
                        <form>
                            <table class="table table-striped table-hover center td-first-left table-budsjett">
                                <thead>
                                <tr class="budsjett-head">
                                    <th>Year</th>
                                    <th>Jan</th>
                                    <th>Feb</th>
                                    <th>Mar</th>
                                    <th>Apr</th>
                                    <th>May</th>
                                    <th>Jun</th>
                                    <th>Jul</th>
                                    <th>Aug</th>
                                    <th>Sep</th>
                                    <th>Oct</th>
                                    <th>Nov</th>
                                    <th>Dec</th>
                                    <th>Percent</th>
                                </tr>
                                </thead>
                                <tbody id="budsjett_table_body">
                                <?php foreach ($models as $key => $val): ?>
                                    <tr>
                                        <td><?= $key ?></td>
                                        <?php foreach ($val as $item): ?>
                                            <td><?= $item; ?></td>
                                        <?php endforeach; ?>
                                        <td>100</td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
