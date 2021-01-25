<?php

/* @var $this yii\web\View */
/* @var $propertyDetailsData PropertyDetails */
/* @var $data string */
/* @var $years string */

$this->title = 'Statistikk';
$this->params['breadcrumbs'][] = $this->title;

use backend\assets\AppAsset;
use backend\components\UrlExtended;
use common\models\PropertyDetails;

$this->registerJsFile('https://www.amcharts.com/lib/4/core.js',
    ['depends' => [AppAsset::className()]]);
$this->registerJsFile('https://www.amcharts.com/lib/4/charts.js',
    ['depends' => [AppAsset::className()]]);
$this->registerJsFile('https://www.amcharts.com/lib/4/themes/animated.js',
    ['depends' => [AppAsset::className()]]);
$this->registerJsFile(Yii::$app->getUrlManager()->getBaseUrl() . '/js/statistikk-personal.js',
    ['depends' => [AppAsset::className()]]);
?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <div class="m-content">
        <button type="button" class="btn video-btn mb-4" data-toggle="modal" data-src="https://player.vimeo.com/video/400425905" data-target="#myModalVideo">
            <i class="flaticon-warning"></i> Instruksjonsvideo
        </button>

        <div class="row print-hide">
            <div class="col-lg-12">
                <ul class="nav nav-tabs  m-tabs-line m-tabs-line--2x m-tabs-line--danger" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a href="<?= UrlExtended::toRoute(['statistikk/befaringer']); ?>"
                           class="nav-link m-tabs__link <?= isset(Yii::$app->view->params['befaringer']) ? Yii::$app->view->params['befaringer'] : ''; ?>">Befaringer</a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a href="<?= UrlExtended::toRoute(['statistikk/signeringer']); ?>"
                           class="nav-link m-tabs__link <?= isset(Yii::$app->view->params['signeringer']) ? Yii::$app->view->params['signeringer'] : ''; ?>">Signeringer</a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a href="<?= UrlExtended::toRoute(['statistikk/salg']); ?>"
                           class="nav-link m-tabs__link <?= isset(Yii::$app->view->params['salg']) ? Yii::$app->view->params['salg'] : ''; ?>">Salg</a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a href="<?= UrlExtended::toRoute(['statistikk/provisjon']); ?>"
                           class="nav-link m-tabs__link <?= isset(Yii::$app->view->params['provisjon']) ? Yii::$app->view->params['provisjon'] : ''; ?>">Provisjon</a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a href="<?= UrlExtended::toRoute(['statistikk/aktiviteter']); ?>"
                           class="nav-link m-tabs__link <?= isset(Yii::$app->view->params['aktiviteter']) ? Yii::$app->view->params['aktiviteter'] : ''; ?>">Aktiviteter</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress- block-rapporter">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div>
                                <h4>
                                    <?= ucfirst(Yii::$app->controller->action->id); ?>
                                </h4>
                            </div>
                        </div>
                        <div class="m-portlet__head-caption">
                            <?php /* <a class="button btn btn-success mr-3" id="download_link"
                               download="my_exported_file.txt" href="javascript:;">Save data</a> */ ?>
                            <button class="btn btn-success print-hide" onclick="print()">Print</button>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div id="chart-data" data-json="<?= htmlentities($data, ENT_QUOTES, 'UTF-8'); ?>"
                             data-years="<?= htmlentities($years, ENT_QUOTES, 'UTF-8'); ?>"></div>
                        <div id="chartdiv" style="width: 100%; height: 700px;"></div>
                        <div class="m-hendelser mt-5 p-3">
                            <tr>
                                <td class="border-0">
                                    <form>
                                        <select id="statistikk-date" class="selectpicker m-3" data-style="btn-success">
                                            <option value="">Alle år</option>
                                            <?php $currentYear = intval(date('Y'));
                                            for($i=$currentYear; $i > $currentYear - 5; $i--): ?>
                                                <option <?= $i === $currentYear ? 'selected' : ''; ?> value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            <table class="table table-auto-width td-padding-left m-table m-table--head-no-border table-hover table-cell-center">
                                <tr>
                                    <td class="border-0">
                                        <span class="m-hendelser-adresse ml-3">Provisjon 3000 + tilrettelegging 3030</span>
                                    </td>
                                    <td class="border-0"><span id="provisjon_tilrettelegging"
                                                               class="pr-3"><?= $propertyDetailsData['provisjon_tilrettelegging']; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-0">
                                        <span class="m-hendelser-adresse ml-3">Omsetningsverdi</span>
                                    </td>
                                    <td class="border-0"><span id="omsetningsverdi"
                                                               class="pr-3"><?= $propertyDetailsData['omsetningsverdi']; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-0">
                                        <span class="m-hendelser-adresse ml-3">Alle befaringer</span>
                                    </td>
                                    <td class="border-0"><span id="befaring"
                                                               class="pr-3"><?= $propertyDetailsData['befaring']; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-0">
                                        <span class="m-hendelser-adresse ml-3">Alle signeringer</span>
                                    </td>
                                    <td class="border-0"><span id="signeringer"
                                                class="pr-3"><?= $propertyDetailsData['signeringer']; ?></span></td>
                                </tr>
                                <tr>
                                    <td class="border-0">
                                        <span class="m-hendelser-adresse ml-3">Alle salg</span>
                                    </td>
                                    <td class="border-0"><span id="salg"
                                                               class="pr-3"><?= $propertyDetailsData['salg']; ?></span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>