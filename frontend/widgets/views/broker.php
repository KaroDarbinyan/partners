<?php

/* @var $this yii\web\View */
/* @var $title string */
/* @var $brokers \common\models\User[] */

?>

<div class="row">
    <div id="office-employers" class="col-12 tac">
        <h2><?= count($brokers) ?> <br><?= $title ?></h2>
    </div>

    <?php foreach ($brokers as $broker): ?>
        <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb_50">
            <div class="box_team">
                <div class="box_img">
                    <a href="/ansatte/<?= $broker->url ?>">
                        <img src="<?= $broker->urlstandardbilde ?>" alt="<?= $broker->navn ?>">
                    </a>
                </div>
                <div class="box_text">
                    <div class="job"><?= $broker->tittel ?></div>
                    <div class="name"><?= $broker->navn ?></div>
                    <p><a href="tel:<?= $broker->mobiltelefon ?>"><?= $broker->mobiltelefon ?></a></p>
                    <p>
                        <a href="mailto:<?= $broker->email ?>"><?= $broker->email ?></a>
                    </p>
                </div>
                <a href="#"
                   data-toggle="modal"
                   data-title="KONTAKT MEG"
                   data-target="#contact-modal"
                   data-type="kontakt_broker"
                   data-broker_id="<?= $broker->web_id ?>"
                   data-includes="message"
                   class="order">KONTAKT MEG</a>
            </div>
        </div>
    <?php endforeach ?>
</div>
