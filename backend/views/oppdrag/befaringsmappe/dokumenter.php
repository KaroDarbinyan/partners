<?php

/* @var $this yii\web\View */
/** @var $doc app\models\Docs */

use backend\assets\AppAsset;

$this->title = 'Dokumenter';
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Oppdrag</span>',
    'url' => ['/oppdrag/'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Befaringsmappe</span>',
    'url' => ['/oppdrag/befaringsmappe/omrade'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('//maps.google.com/maps/api/js?key=AIzaSyBigZy49qUlMNHKyai6MSjdMW3Bl-p2HqM&callback=initMap',
    [
        'depends' => AppAsset::className(),
        'async' => true, 'defer' => true
    ]);
$this->registerJsFile('admin/js/google-maps.js',
    ['depends' => [AppAsset::className()]]);

$docs = $model->propertyDocs;
?>

<div class="m-portlet__body m-widget4">

    <div class="row">
        <div class="col-md-12">

            <table class="table m-table m-table--head-no-border table-hover table-cell-center table-oppdrag-dokumenter">
                <tbody>

                    <?php foreach ($docs as $doc) { ?>
                        <tr><td>
                            <a href="<?= $doc->urldokument ?>" class="m-widget4__item">
                                <div class="m-widget4__img m-widget4__img--icon">
                                    <img src="/admin/app/media/img/files/<?= $doc->filtype ?>.svg"
                                         alt="<?= $doc->filtype ?>"
                                    />
                                </div>
                                <div class="m-widget4__info">
                                    <span><?= $doc->navn; ?></span>
                                </div>
                                <div class="m-widget4__ext">
                                    <!--20.02.2019-->
                                </div>
                            </a>
                        </td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>


