<?php

/** @var $this yii\web\View */
/** @var $users common\models\User[] */
/** @var string $title */

use yii\helpers\StringHelper;

?>

<div id="office-employers" class="col-12 tac">
    <h2><?= count($users) ?> <br><?= $title ?></h2>
</div>

<?php foreach ($users as $user): ?>
    <div class="col-6 col-md-6 col-lg-4 col-xl-3 mb_50">
        <div class="box_team">
            <div class="box_img">
                <a href="/ansatte/<?= $user->url ?>">
                    <img src="<?= $user->urlstandardbilde ?>" alt="<?= $user->navn ?>">
                </a>
            </div>
            <div class="box_text">
                <div class="job"><?= $user->tittel ?></div>
                <div class="name"><?= StringHelper::truncate($user->navn, 25) ?></div>
                <p><a href="tel:<?= $user->mobiltelefon ?>"><?= $user->mobiltelefon ?></a></p>
                <p>
                    <a href="mailto:<?= $user->email ?>"><?= $user->email ?></a>
                </p>
            </div>
            <?php if (!$user->department->isAdministration()): ?>
                <a href="/ansatte/<?= $user->url ?>" class="order">VERDIVURDERING</a>
            <?php else: ?>
                <a href="#"
                   data-toggle="modal"
                   data-title="KONTAKT MEG"
                   data-target="#contact-modal"
                   data-type="kontakt_broker"
                   data-broker_id="<?= $user->web_id ?>"
                   data-includes="message"
                   class="order">KONTAKT MEG</a>
            <?php endif ?>
        </div>
    </div>
<?php endforeach ?>
