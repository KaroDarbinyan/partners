<?php

/* @var $this yii\web\View */
/* @var $departments Department[] */

$this->title = 'Eiendommer til salgs i Oslo og hele Norge, PARTNERS';

use common\models\Department;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url; ?>

<?php $this->beginBlock('head') ?>
<meta property="og:type" content="website"/>
<meta property="og:title" content="<?= $this->title ?>"/>
<meta property="og:description"
      content="Vi bistår deg med salg av eiendom i ditt nærmiljø. Finn ditt nærmeste kontor eller bestill verdivurdering av din eiendom."/>
<meta property="og:url" content="<?= Url::current([], true); ?>"/>
<meta property="og:image" content="<?= Url::current([], true); ?>img/property-default.jpg"/>
<meta property="og:site_name" content="PARTNERS.NO"/>
<?php $this->endBlock() ?>

<?php $this->beginBlock('page_header') ?>
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-12 tac">
                <div class="header__description w-75 mx-auto">
                    <img class="w-50 mb-4" src="/img/partners-logo-white.svg" alt="<?= $this->title ?>">
                    <p> Velkommen til en nytenkende, uavhengig eiendomsmeglerkjede.<br/>
                        Våre stolte, lokalkjente meglere sikrer deg en best mulig bolighandel.<br/>
                        Finn nærmeste <a href="/kontorer">kontor</a>, <a href="/kontorer">megler</a> eller bestill <a href="/verdivurdering">verdivurdering</a>
                    </p>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="box_work">
                    <a href="/pristilbud" class="link"></a>
                    <div class="box_img">
                        <img src="/img/work_1.jpg" alt="">
                    </div>
                    <div class="box_text">
                        <h4>SELGE BOLIG</h4>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="box_work">
                    <a href="/eiendommer" class="link"></a>
                    <div class="box_img">
                        <img src="/img/work_3.jpg" alt="">
                    </div>
                    <div class="box_text">
                        <h4>KJØPE BOLIG</h4>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="box_work">
                    <a href="/verdivurdering" class="link"></a>
                    <div class="box_img">
                        <img src="/img/work_4.jpg" alt="">
                    </div>
                    <div class="box_text">
                        <h4>VERDIVURDERING</h4>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="box_work">
                    <a href="/kontorer" class="link"></a>
                    <div class="box_img">
                        <img src="/img/work_2.jpg" alt="">
                    </div>
                    <div class="box_text">
                        <h4>FINN MEGLER</h4>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>
<?php $this->endBlock() ?>

<div class="bg-white text-dark py-5">
    <div class="container mainpage">
        <div class="tac mx-auto py-5">
            <h2>Vi bistår deg med salg av eiendom i ditt nærmiljø. Finn ditt
                nærmeste kontor eller bestill verdivurdering av din eiendom.</h2>
            <div class="box_input_search mt-5 box_searches" id="office_search">
                <i class="icon" data-svg="/img/search-black.svg"></i>
                <input class="dark text-dark font-weight-bold" name="search" type="text" placeholder="Søk etter kontor">
                <p style="text-align: center"><br/>eller<br/><br/>
                
                    <?php if (count($departments)): ?>
                        <?php if (Yii::$app->mobileDetect->isMobile()): ?>
                            <div class="select">
                                <select id="offices-selector">
                                    <option value="" selected disabled>Velg kontor</option>
                                    <?php foreach ($departments as $department): ?>
                                        <option value="/office/<?= $department->url ?>">
                                            <?= $department->short_name ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        <?php else: ?>
                            <a id="offices-selector-modal" class="select" href="<?= Url::toRoute(['company/offices']) ?>">
                                <span>Velg kontor</span>
                            </a>
                        <?php endif; ?>
                    <?php endif ?>
                </p>
            </div>
        </div>
        <ul class="tac w-100 mx-auto mt-0 list_office"></ul>
    </div>
</div>
<div class="text-dark">
    <div class="container">
    </div>
</div>

<section class="section_block">
    <div class="container">
        <div class="row">
            <div class="portfolio_list">
                <!-- //////// -->
                <div class="box_flex_5">
                    <div class="portfolio_box">
                        <a href="/boligvarsling" class="link"></a>
                        <div class="box_img">
                            <img src="/img/portfolio_img_1.jpg" alt="">
                        </div>
                        <div class="box_text">
                            <h2>BOLIGVARSLING</h2>
                            <h4>Finn ut mer</h4>
                        </div>
                    </div>
                    <!-- //////// -->
                    <div class="portfolio_box">
                        <a href="/salgsprosessen" class="link"></a>
                        <div class="box_img">
                            <img src="/img/portfolio_img_3.jpg" alt="">
                        </div>
                        <div class="box_text">
                            <h2>SALGSPROSESSEN</h2>
                            <h4>Finn ut mer</h4>
                        </div>
                    </div>
                </div>
                <!-- //////// -->
                <div class="box_flex_7">
                    <div class="portfolio_box">
                        <a href="https://bolignyttpartners.no" target="_blank" class="link"></a>
                        <div class="box_img">
                            <img src="/img/portfolio_img_2.jpg" alt="">
                        </div>
                        <div class="box_text">
                            <h2>BOLIGNYTT</h2>
                            <h4>Finn ut mer</h4>
                        </div>
                    </div>
                </div>
                <!-- //////// -->
            </div>
        </div>
    </div>
</section>

<?= $this->render('@frontend/views/partials/jobs.php') ?>

<div class="modal fade" id="velg-modal" tabindex="-1" role="dialog" aria-labelledby="velgModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase" id="velgModalLabel">KONTORER</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php ArrayHelper::multisort($departments, "poststed", SORT_ASC);
                foreach ($departments as $department): ?>
                    <h3 class="dep-item">
                        <a class="d-block" href="/office/<?= $department->url; ?>"><?= $department->short_name; ?></a>
                    </h3>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>