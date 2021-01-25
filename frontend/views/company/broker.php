<?php

/* @var $this yii\web\View */
/* @var $employer User */

/* @var $formModel Forms */

use common\models\Forms;
use common\models\User;
use frontend\widgets\BrokersWidget;
use frontend\widgets\PropertyWidget;
use yii\helpers\Url;

?>

<?php $this->beginBlock('head') ?>
<?= $employer->partner->head_stack ?? '' ?>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?= $this->title; ?>"/>
    <meta property="og:description"
          content="<?= $employer->tittel; ?>"/>
    <meta property="og:url" content="<?= Url::current([], true); ?>"/>
    <meta property="og:image" content="<?= Url::base(true) . $employer->urlstandardbilde; ?>"/>
    <meta property="og:site_name" content="PARTNERS.NO"/>
<?php $this->endBlock() ?>

<?php $this->beginBlock('page_header') ?>
    <header class="header bg_img bg_overlay" data-background="/img/header_broker_bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="box_office_info box_broker_info">
                        <div class="box_img">
                            <img src="<?= $employer->urlstandardbilde ?>" alt="<?= $employer->navn ?>">
                        </div>
                        <div class="box_text">
                            <h1><?= $employer->navn ?></h1>
                            <p><?= $employer->tittel ?></p>
                            <div class="box_info">
                                <a href="mailto:<?= $employer->email ?>"><?= $employer->email ?></a>
                                <br><a href="tel:<?= $employer->mobiltelefon ?>"><?= $employer->mobiltelefon ?></a>
                            </div>
                            <p class="box_adres">
                                <?= $employer->department->getFullAddress() ?><br>
                                <?= $employer->department->navn ?>
                            </p>

                            <div class="d-flex flex-wrap">
                                <a href="#kontakt_broker"
                                   data-toggle="modal"
                                   data-title="KONTAKT MEG"
                                   data-target="#contact-modal"
                                   data-type="kontakt_broker"
                                   data-broker_id="<?= $employer->web_id ?>"
                                   data-includes="message"
                                   class="order order-sm mr-1 mb-3 p-2"
                                >KONTAKT MEG</a>
                                <?php /* <a href="#e_takst"
                                   data-toggle="modal"
                                   data-title="Е-takst"
                                   data-target="#contact-modal"
                                   data-type="e_takst"
                                   data-broker_id="<?= $employer->web_id ?>"
                                   data-includes="message"
                                   class="order order-sm mr-2 mb-3 p-2"
                                >Е-TAKST</a> */ ?>
                                <a href="#verdivurdering"
                                   data-toggle="modal"
                                   data-title="VERDIVURDERING"
                                   data-target="#contact-modal"
                                   data-type="verdivurdering"
                                   data-broker_id="<?= $employer->web_id ?>"
                                   class="order order-sm mr-1 mb-3 p-2"
                                >VERDIVURDERING</a>
                                <?php /*<a href="<?= Url::to(['/meglerbooking']) ?>" class="order order-sm mb-3 p-2">MEGLERBOOKING</a>*/ ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
<?php $this->endBlock() ?>

    <section class="section_block">
        <div class="container">
            <div class="row mb-5">
                <?= PropertyWidget::widget([
                    'id' => $employer->web_id,
                    'textHeader' => 'EIENDOMMER'
                ]) ?>
            </div>
            <div class="row">
                <?= BrokersWidget::widget([
                    'id' => $employer->id_avdelinger,
                    'textHeader' => 'KOLLEGAER',
                    'except' => [$employer->web_id]])
                ?>
            </div>
        </div>
    </section>

<?= $this->render('@frontend/views/partials/contactModal.php', [
    'model' => $formModel
]) ?>