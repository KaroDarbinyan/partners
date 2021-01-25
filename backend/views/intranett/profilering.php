<?php

/* @var $this yii\web\View */

use common\models\User;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use backend\components\UrlExtended;
use yii\web\View;

/* @var $newsList \common\models\News */

$this->title = 'Profilering';
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Intranett</span>',
    'url' => ['/intranett/profilering'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = $this->title;


/** @var User $user */ 
$user = Yii::$app->user->identity;

?>

<div class="block-nyheter m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <button type="button" class="btn video-btn mb-4" data-toggle="modal" data-src="https://player.vimeo.com/video/400561123" data-target="#myModalVideo">
            <i class="flaticon-warning"></i> Instruksjonsvideo
        </button>
        <div class="row">
            <?php foreach ($newsList as $news): ?>
                <?php
                $img = Yii::$app->params['NewsDefaultImg'];

                if ($news->image) {
                    $image = "/img/news/{$news->image->dir_name}/{$news->image->file_name}";
                    if (is_file(Yii::getAlias('@frontend') . "/web{$image}")) $img = $image;
                }

                $url = UrlExtended::to(['nyheter-view', 'id' => $news->id]);
                ?>
                <div class="news-card col-xs-12 col-sm-6 col-xl-4">
                    <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height  m-portlet--rounded-force news-btn">
                        <div class="m-portlet__head m-portlet__head--fit">
                            <div class="m-portlet__head-caption">
                                <?php if ($user->hasRole('superadmin')): ?>
                                    <div class="m-portlet__head-action">
                                        <a href="<?= UrlExtended::toRoute(['/intranett/nyheter-update/' . $news->id]) ?>"
                                           class="btn btn-sm m-btn--pill btn-secondary">
                                            Rediger
                                        </a>
                                        <a href="#" data-action="<?= UrlExtended::toRoute(['/intranett/nyheter-delete/' . $news->id]) ?>"
                                           class="btn btn-sm m-btn--pill btn-secondary js-delete-confirm">
                                            Fjerne
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-widget19">
                                <div class="m-widget19__pic m-portlet-fit--top m-portlet-fit--sides">
                                    <img src="<?= $img ?>" alt="<?= $news->name ?>" onclick="window.open('<?= $url ?>', '_self')">
                                    <div class="m-widget19__shadow"></div>
                                </div>
                                <div class="m-widget19__content">
                                    <div class="m-widget19__header">
                                        <?= date('d.m.Y', $news->created_at) . ' <i class="far fa-eye ml-3"></i> ' . $news->viewings; ?>
                                    </div>
                                    <div class="m-widget19__body">
                                        <h4 class="m-widget19__title m--font-light" style="text-align: left;"  onclick="window.open('<?= $url ?>', '_self')"><?= $news->name ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>