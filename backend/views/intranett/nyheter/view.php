<?php

use backend\components\UrlExtended;
use common\models\User;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \common\models\News */


$this->title = 'Artikkel';
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Nyheter/Profilering</span>',
    'url' => ['/intranett/nyheter'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = $this->title;

/** @var User $user */
$user = Yii::$app->user->identity;

?>

<div class="block-nyheter m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="row">

            <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height  m-portlet--rounded-force"
                 style="width: 100%">
                <div class="m-portlet__body" style="padding: 30px;">
                    <div class="m-widget19" style="position: relative;">
                        <?php if (!$user->hasRole('broker')): ?>
                            <div style="right: 0; margin: 10px 0 25px 25px; position: absolute; z-index: 20;">
                                <a href="<?= UrlExtended::to(['nyheter-update', 'id' => $model->id]) ?>"
                                   class="btn btn-sm m-btn--pill btn-secondary">
                                    Rediger
                                </a>
                                <a href="#"
                                   data-action="<?= UrlExtended::toRoute(['nyheter-delete', 'id' => $model->id]) ?>"
                                   class="btn btn-sm m-btn--pill btn-secondary js-delete-confirm">
                                    Fjerne
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ($model->image && $model->show_img): ?>
                            <?php
                            $img = Yii::$app->params['NewsDefaultImg'];
                            $image = "/img/news/{$model->image->dir_name}/{$model->image->file_name}";

                            if (is_file(Yii::getAlias('@frontend') . "/web{$image}")) $img = $image;
                            ?>
                            <div class="m-widget19__pic m-portlet-fit--top m-portlet-fit--sides"
                                 style="padding: 10px 30px 30px 30px; margin-top: 0px;">
                                <img src="<?= $img ?>" alt="<?= $model->name ?>"
                                     style="border-top-right-radius: 10px; border-top-left-radius: 10px;">
                                <div class="m-widget19__shadow"></div>
                            </div>
                        <?php endif; ?>
                        <div class="m-widget19__content" style="padding-top: 40px;">
                            <h1 class="m-widget19__title m--font-dark"><?= $model->name ?></h1>
                            <span class="m-widget19__number">
                                <?= date('d.m.Y', $model->created_at) . ' <i class="far fa-eye ml-3"></i> ' . $model->viewings; ?>
                            </span>
                            <div class="m-widget19__body" style="font-size: 1.3rem">
                                <br/>
                                <p><?= $model->text ?></p>
                                <?php if ($newsLinks = $model->newsLinks): ?>
                                    <ul class="mt-5">
                                        <?php foreach ($newsLinks as $newsLink): ?>
                                            <?php if (in_array($newsLink->file_extension, ["zip", "pdf", "rar"])): ?>
                                                <?php
                                                $filename = $newsLink->file_desc ? $newsLink->file_desc : $newsLink->file_original_name;
                                                $download = str_replace(".{$newsLink->file_extension}", "", $filename) . ".{$newsLink->file_extension}";
                                                $filename .= " (" . number_format(floatval($newsLink->file_size / 1024 / 1024), 2) . " Mb)"
                                                ?>
                                                <li>
                                                    <a class="news-download-link"
                                                       title="<?= $filename; ?>"
                                                       href="<?= "{$newsLink->getPath()}/{$newsLink->dir_name}/{$newsLink->file_name}"; ?>"
                                                       download="<?= $download; ?>"><?= $filename; ?></a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <button type="button" id="open-modal" class="btn btn-info btn-lg d-none" data-toggle="modal"
            data-target="#myModal">Klikk
    </button>
<?php endif; ?>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #2b2b2b">
            <div class="modal-body">
                <h3 class="text-center text-success">Lagret</h3>
            </div>
            <div class="modal-footer" style="border-top: none">
                <button type="button" class="btn btn-default m--block-center" data-dismiss="modal">Lukke</button>
            </div>
        </div>
    </div>
</div>