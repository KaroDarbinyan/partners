<?php

/* @var $this yii\web\View */

/* @var $data array */

use frontend\assets\MainAsset;

$this->title = 'Meglere booking';
$this->registerCssFile('@web/css/booking.css');
$this->registerJSFile('@web/js/booking/booking.js', ['depends' => MainAsset::className()]);

?>

<?php $this->beginBlock('page_header') ?>
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-12 tac">
                <div class="box_breadcrumb">
                    <ul class="box_text">
                        <li class="breadcrumb__inner step">
                            <div class="text-<?= Yii::$app->view->params["page"] === "main" ? "white" : "dark"; ?>">
                                <p class="breadcrumb__title">Steg 1</p>
                                <p class="breadcrumb__desc">Start</p>
                            </div>
                        </li>
                        <li class="breadcrumb__inner step">
                            <div class="text-<?= Yii::$app->view->params["page"] === "kontorer" ? "white" : "dark"; ?>">
                                <p class="breadcrumb__title">Steg 2</p>
                                <p class="breadcrumb__desc">Velg kontor</p>
                            </div>
                        </li>
                        <li class="breadcrumb__inner step">
                            <div class="text-<?= Yii::$app->view->params["page"] === "tjenester" ? "white" : "dark"; ?>">
                                <p class="breadcrumb__title">Steg 3</p>
                                <p class="breadcrumb__desc">Velg tjeneste</p>
                            </div>
                        </li>
                        <li class="breadcrumb__inner step">
                            <div class="text-<?= Yii::$app->view->params["page"] === "calendar" ? "white" : "dark"; ?>">
                                <p class="breadcrumb__title">Steg 4</p>
                                <p class="breadcrumb__desc">Velg tidspunkt</p>
                            </div>
                        </li>
                        <li class="breadcrumb__inner step">
                            <div class="text-<?= Yii::$app->view->params["page"] === "information" ? "white" : "dark"; ?>">
                                <p class="breadcrumb__title">Steg 5</p>
                                <p class="breadcrumb__desc">Fyll ut informasjon</p>
                            </div>
                        </li>
                        <li class="breadcrumb__inner">
                            <div class="text-<?= Yii::$app->view->params["page"] === "confirmation" ? "white" : "dark"; ?>">
                                <p class="breadcrumb__desc mt-2">Bekreftelse</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-lg-12">
                <div class="box_team">
                    <div class="box_text">
                        <?= $this->render("_" . Yii::$app->view->params["page"], compact("data")); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php $this->endBlock() ?>
