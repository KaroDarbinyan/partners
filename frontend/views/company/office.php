<?php

use common\models\Department;
use common\models\Forms;
use common\models\User;
use frontend\widgets\BrokersWidget;
use frontend\widgets\PropertyWidget;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

/* @var $this yii\web\View */
/* @var $employer User */
/* @var $department Department */
/* @var $formModel Forms */

?>

<?php $this->beginBlock('head') ?>
<?= $department->partner->head_stack ?? '' ?>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?= $this->title ?>"/>
    <meta property="og:description"
          content="<?= $department->navn ?> er din lokale eiendomsmegler i <?= $department->part_of_city ?? $department->poststed ?>
              og har bred erfaring med eiendomsmegling i området. Vi hjelper deg med både kjøp og salg av bolig.
              Klikk på eiendommer for å se hvilke boliger vi har til salgs, eller be om verdivurdering av din bolig."/>
    <meta property="og:url" content="<?= Url::current([], true); ?>"/>
    <meta property="og:image"
          content="<?= Url::base(true) . str_replace("/logo/", "/logo/black_fill/", $department->partner->logo); ?>"/>
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
                    <?php if ($partner = $department->partner): ?>
                        <a href="<?= Url::toRoute(['company/partner', 'slug' => $partner->slug]) ?>">
                            <img src="<?= $partner->logo ?>" alt="<?= $partner->name ?>" class="partner_logo">
                        </a>
                    <?php endif ?>
                    <h1><?= $department->navn ?></h1>
                    <p class="box_adres"><?= $department->getFullAddress(); ?></p>
                    <div class="box_info">
                        <a href="mailto:<?= $department->email; ?>"><?= $department->email; ?></a><br>
                        <a href="tel:<?= $department->telefon; ?>"><?= $department->telefon; ?></a>
                        <?php if ($department->bolignytt): ?>
                            <br><br><a href="https://<?= $department->bolignytt; ?>" target="_blank"><?= $department->bolignytt; ?></a>
                        <?php endif; ?>
                    </div>
                    <?php if ($department->description): ?>
                        <p><?= $department->description; ?></p>
                    <?php else: ?>
                        <p><?= $department->navn ?> er din lokale eiendomsmegler
                            i <?= $department->part_of_city ?? $department->poststed ?> og har bred erfaring med
                            eiendomsmegling i området. Vi hjelper deg med både kjøp og salg av bolig. Klikk på
                            eiendommer for å se hvilke boliger vi har til salgs, eller be om verdivurdering av din
                            bolig.</p>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!$department->isAdministration()): ?>
                <ul class="list_link">
                    <li><a href="#verdivurdering" class="order"
                           data-title="VERDIVURDERING"
                           data-toggle="modal"
                           data-target="#contact-modal"
                           data-type="verdivurdering"
                           data-department_id="<?= $department->original_id ?? $department->web_id ?>">VERDIVURDERING</a></li>
                    <li><a href="#office-properties" class="order">EIENDOMMER</a></li>
                    <li><a href="#office-employers" class="order">ANSATTE</a></li>
                    <li><a href="<?= Url::toRoute(['dwelling/form']) ?>" class="order">Boligvarsling</a></li>
                    <?php if ($department->bolignytt): ?>
                        <li><a href="https://<?= $department->bolignytt ?>" target="_blank" class="order">Bolignytt</a></li>
                    <?php endif ?>
                    <?php /*<li><a href="<?= Url::to(['/meglerbooking']) ?>" class="order">MEGLERBOOKING</a></li>*/ ?>
                </ul>
            <?php endif ?>
        </div>
    </div>
</header>
<?php $this->endBlock() ?>

<section class="section_block">
    <div class="container">
        <div class="row">
            <?= BrokersWidget::widget(['id' => $department->web_id, 'textHeader' => 'ANSATTE'])?>
            <?= PropertyWidget::widget(['id' => $department->web_id, 'textHeader' => 'EIENDOMMER', 'office' => true])?>
            <?php if ($department->price_list_url): ?>
                <div class="col-12 text-center my-5">
                    <a href="<?= $department->price_list_url ?>" class="order" download>Last ned prisliste</a>
                </div>
            <?php endif ?>
        </div>
    </div>
</section>

<?= $this->render('@frontend/views/partials/jobs.php') ?>

<?= $this->render('@frontend/views/partials/contactModal.php', [
    'model' => $formModel
]) ?>
