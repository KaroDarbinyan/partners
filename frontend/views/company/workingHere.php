<?php

/* @var $this \yii\web\View */

/* @var $vacancies \common\models\LedigeStillinger[] */
/* @var $directors \common\models\User[] */
/* @var $formModel \common\models\Forms */

?>

<?php $this->beginBlock('page_header') ?>
<header class="header bg_img bg_overlay" data-background="/img/header_contact_bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12 tac">
                <h1><?= Yii::$app->view->params['header'] ?></h1>
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <h3>VI SØKER</h3>
                        <p>- og har ALLTID plass til personer som virkelig ønsker å lykkes i bransjen vår! </p>
                        <p>Enten du har ambisjoner om å bli partner, drive eget kontor, om du er en toppmegler, eller ønsker å
                            bli det – hos oss kan du vokse enda mer og få ut ditt fulle potensiale.</p>
                        <p>For oss er de beste meglerne trivelige, effektive og ambisiøse folk, som opptrer ryddig. Vi har det
                            dyreste folk eier i vår varetekt – og det tar vi på alvor. Hos oss tar meglerne hverandre med på
                            befaringer, visninger, kontraktsmøter eller hva det måtte være – så vi lærer av hverandre. Ingen er
                            så dyktig at de ikke kan bli bedre. </p>
                        <p>Vi lever etter vårt eget slagord: Schala & Partners – Eiendomsmegleren du anbefaler videre.</p>
                        <p><em><strong>Alle henvendelser behandles konfidensielt.</strong></em></p>
                    </div>
                    <div class="col-12 col-lg-8">
                        <ul class="nav list_link" role="tablist">
                            <?php if (count($vacancies)): ?>
                                <li><a href="#main" class="order active" id="main-tab" data-toggle="tab" role="tab" aria-controls="main" aria-selected="true">LEDIGE STILLINGER</a></li>
                            <?php endif ?>
                            <?php if (count($directors)): ?>
                                <li><a href="#directors" class="order <?= !count($vacancies) ? 'active' : '' ?>" id="directors-tab" data-toggle="tab" role="tab" aria-controls="directors" aria-selected="false">KONTAKTPERSONER</a></li>
                            <?php endif ?>
                            <li><a href="#" data-toggle="modal" data-target="#contact-modal" data-broker="3000216" class="order">KONTAKT OSS</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane <?= count($vacancies) ? 'active' : '' ?>" id="main" role="tabpanel" aria-labelledby="main-tab">
                                <table class="table table-dark">
                                    <thead>
                                    <tr>
                                        <th scope="col">TITTEL</th>
                                        <th scope="col">KONTOR</th>
                                        <th scope="col">FRIST</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($vacancies as $vacancy): ?>
                                        <tr>
                                            <th scope="row"><?= $vacancy->title ?></th>
                                            <td><?= $vacancy->department ? $vacancy->department->name : '' ?></td>
                                            <td><?= $vacancy->showDate() ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane <?= !count($vacancies) ? 'active' : '' ?>" id="directors" role="tabpanel" aria-labelledby="directors-tab">
                                <div class="row">
                                    <?php foreach ($directors as $director): ?>
                                        <div class="col-12 col-lg-4">
                                            <div class="box_office_info box_broker_info">
                                                <div class="box_img">
                                                    <img src="<?= $director->urlstandardbilde ?>" alt="<?= $director->navn ?>">
                                                </div>
                                                <div class="box_text">
                                                    <h1><?= $director->navn ?></h1>
                                                    <p><?= $director->tittel ?></p>
                                                    <div class="box_info">
                                                        <a href="mailto:<?= $director->email ?>"><?= $director->email ?></a>
                                                        <br><a href="tel:<?= $director->mobiltelefon ?>"><?= $director->mobiltelefon ?></a>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <a href="#" data-toggle="modal" data-target="#contact-modal" data-broker="<?= $director->web_id ?>" class="order">KONTAKT MEG</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php $this->endBlock() ?>

<?= $this->render('@frontend/views/partials/contactModal.php', [
    'type' => 'jobb',
    'model' => $formModel
]) ?>