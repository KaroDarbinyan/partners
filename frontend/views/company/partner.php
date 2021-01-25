<?php

use common\models\Forms;
use common\models\Partner;
use frontend\widgets\BrokersWidget;
use frontend\widgets\PartnerBrokersWidget;
use frontend\widgets\PartnerDepartmentsWidget;
use frontend\widgets\PropertyWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $partner Partner */
/* @var $formModel Forms */

?>

<?php $this->beginBlock('head') ?>
<?= $partner->head_stack ?>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?= $this->title; ?>"/>
    <meta property="og:description"
          content="<?= $partner->description; ?>"/>
    <meta property="og:url" content="<?= Url::current([], true); ?>"/>
    <meta property="og:image" content="<?= Url::base(true) . str_replace("/logo/", "/logo/black_fill/", $partner->logo); ?>"/>
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="531" />
    <meta property="og:image:height" content="220" />
    <meta property="og:site_name" content="PARTNERS.NO"/>
<?php $this->endBlock() ?>

<?php $this->beginBlock('page_header') ?>
<header class="header bg_img bg_overlay" data-background="/img/header_office_bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="box_office_info">
                    <img src="<?= $partner->logo ?>" alt="<?= $partner->name ?>" class="partner_logo">
                    <h1><?= $partner->name ?></h1>
                    <p class="box_adres"><?= $partner->address; ?></p>
                    <div class="box_info">
                        <a href="mailto:<?= $partner->email; ?>"><?= $partner->email; ?></a><br>
                        <a href="tel:<?= $partner->telefon; ?>"><?= $partner->telefon; ?></a>
                        <?php if ($partner->bolignytt): ?>
                            <br><br><a href="https://<?= $partner->bolignytt; ?>"
                                       target="_blank"><?= $partner->bolignytt; ?></a>
                        <?php endif; ?>
                    </div>
                    <p><?= $partner->description ?></p>
                </div>
            </div>

            <ul class="list_link">
                <li><a href="#verdivurdering" class="order"
                       data-title="VERDIVURDERING"
                       data-toggle="modal"
                       data-target="#contact-modal"
                       data-type="verdivurdering">VERDIVURDERING</a></li>
                <li><a href="#office-properties" class="order">EIENDOMMER</a></li>
                <li><a href="#office-employers" class="order">ANSATTE</a></li>
                <?php /* <li><a href="#" class="order">MITT SALG</a></li>
                <li><a href="#" class="order">MITT EIENDOMSØK</a></li> */ ?>
            </ul>

        </div>
    </div>
</header>
<?php $this->endBlock() ?>

<section class="section_block">
    <div class="container">
        <div class="row">
            <?= PartnerDepartmentsWidget::widget(['id' => $partner->id, 'textHeader' => 'KONTORER']) ?>
        </div>
        <div class="row">
            <?= PartnerBrokersWidget::widget(['id' => $partner->id, 'textHeader' => 'ANSATTE']) ?>
        </div>
        <?= PropertyWidget::widget(['id' => $partner->id, 'textHeader' => 'EIENDOMMER', 'partner' => true]) ?>
    </div>
</section>

<?= $this->render('@frontend/views/partials/jobs.php') ?>

<?= $this->render('@frontend/views/partials/contactModal.php', [
    'model' => $formModel
]) ?>

