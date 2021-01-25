<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use backend\components\UrlExtended;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;

$model = $this->params['model'];
$page = $this->params['v'];
$subPage = $this->params['v2'];


?>
<div class="row">
    <div class="col-lg-12">

        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-" style="margin-bottom: 0">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--danger additional">
                        <li class="nav-item m-tabs__item ">
                            <a
                                href="<?= UrlExtended::toRoute([
                                    'oppdrag/befaringsmappe/',
                                    'page' => 'omrade',
                                    'id' => $model->web_id,
                                ]) ?>"
                                class="
                                    nav-link m-tabs__link
                                    <?= 'omrade' === $subPage ? 'active' : '' ?>
                                "
                            >
                                Område
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a
                                href="<?= UrlExtended::toRoute([
                                    'oppdrag/befaringsmappe/',
                                    'page' => 'interessenter',
                                    'id' => $model->web_id,
                                ]) ?>"
                                class="
                                    nav-link m-tabs__link
                                    <?= 'interessenter' === $subPage ? 'active' : '' ?>
                                "
                            >
                                Interessenter
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a
                                href="<?= UrlExtended::toRoute([
                                    'oppdrag/befaringsmappe/',
                                    'page' => 'team',
                                    'id' => $model->web_id,
                                ]) ?>"
                                class="
                                    nav-link m-tabs__link
                                    <?= 'team' === $subPage ? 'active' : '' ?>
                                "
                            > Team
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a
                                    href="<?= UrlExtended::toRoute([
                                        'oppdrag/befaringsmappe/',
                                        'page' => 'salgsprosessen',
                                        'id' => $model->web_id,
                                    ]) ?>"
                                    class="
                                    nav-link m-tabs__link
                                    <?= 'salgsprosessen' === $subPage ? 'active' : '' ?>
                                "
                            > Salgsprosessen
                            </a>

                        </li>
                        <li class="nav-item m-tabs__item">
                            <a
                                    href="<?= UrlExtended::toRoute([
                                        'oppdrag/befaringsmappe/',
                                        'page' => 'kalender',
                                        'id' => $model->web_id,
                                    ]) ?>"
                                    class="
                                    nav-link m-tabs__link
                                    <?= 'kalender' === $subPage ? 'active' : '' ?>
                                "
                            > Kalender
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a
                                    href="<?= UrlExtended::toRoute([
                                        'oppdrag/befaringsmappe/',
                                        'page' => 'dokumenter',
                                        'id' => $model->web_id,
                                    ]) ?>"
                                    class="
                                    nav-link m-tabs__link
                                    <?= 'dokumenter' === $subPage ? 'active' : '' ?>
                                "
                            > Dokumenter
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Content -->
            <?= $content ?>
        </div>
    </div>
</div>

