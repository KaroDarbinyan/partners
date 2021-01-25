<?php

/* @var $this View */
/* @var $groupedDepartments array */

use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View; ?>

<?php $this->beginBlock('head') ?>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="Kontorer"/>
    <meta property="og:description" content="Finn megler eller kontor"/>
    <meta property="og:url" content="<?= Url::current([], true); ?>"/>
    <meta property="og:image" content="<?= Url::home(true); ?>img/property-default.jpg"/>
    <meta property="og:site_name" content="PARTNERS.NO"/>
<?php $this->endBlock() ?>

<?php $this->beginBlock('page_header') ?>
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-12 tac">
                <h1 class="mb_50">Finn megler eller kontor</h1>
                <form id="office-search-form">
                    <div class="box_input_search" id="office_search">
                        <input name="search" type="text" placeholder="Postnummer eller navn" aria-label="Kontorsøk">
                        <p class="help-block"></p>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <ul class="list_office">
                    <?= $this->render("@frontend/views/partials/_list_office", compact("groupedDepartments")); ?>
                </ul>
            </div>
        </div>
    </div>
</header>
<?php $this->endBlock() ?>

<?= $this->render('@frontend/views/partials/jobs.php') ?>
<?= $this->render('@frontend/views/partials/departmentsModal') ?>

