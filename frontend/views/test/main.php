<?php

/* @var $this yii\web\View */

$this->title = 'Eiendommer til salgs i Oslo og hele Norge, SCHALA & PARTNERS';

?>

<?php $this->beginBlock('page_header') ?>
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-12 tac">
                <div class="header__description w-50 mx-auto">
                    <img class="w-75 mb-4" src="/img/partners-logo-white.svg" alt="<?= $this->title ?>">
                    <p>Vi bistår deg med salg av eiendom i ditt nærmiljø. Finn nærmeste <a href="/kontorer">kontor</a>, <a
                                href="/ansatte">megler</a> eller bestill <a href="/verdivurdering">verdivurdering</a>
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
                    <a href="/kontorer" class="link"></a>
                    <div class="box_img">
                        <img src="/img/work_2.jpg" alt="">
                    </div>
                    <div class="box_text">
                        <h4>FINN MEGLER</h4>
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

            <div class="col-12">
                <div class="box_searches d-flex justify-content-between">
                    <h2>Finn Partners kontor</h2>
                    <div class="box_input_search">
                        <i class="icon" data-svg="/img/icon_search.svg"></i>
                        <input type="search" placeholder="Skriv inn postnummer">
                    </div>
                    <div class="select">
                        <select name="" id="">
                            <option value="1">Velg kontor</option>
                            <option value="2">Velg kontor 2</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php $this->endBlock() ?>

<div class="bg-white text-dark py-5">
    <div class="container">
        <div class="tac w-75 mx-auto py-5">
            <h2>Vi bistår deg med salg av eiendom i ditt nærmiljø. Finn ditt
                nærmeste kontor eller bestill verdivurdering av din eiendom.</h2>
            <div class="box_input_search mt-5">
                <i class="icon" data-svg="/img/search-black.svg"></i>
                <input class="dark" type="search" placeholder="Hva leter du etter ?">
            </div>
        </div>
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
                        <a href="#" class="link"></a>
                        <div class="box_img">
                            <img src="/img/portfolio_img_3.jpg" alt="">
                        </div>
                        <div class="box_text">
                            <h2>BOLIGPRIS-STATISTIKK</h2>
                            <h4>Finn ut mer</h4>
                        </div>
                    </div>
                </div>
                <!-- //////// -->
                <div class="box_flex_7">
                    <div class="portfolio_box">
                        <a href="#" class="link"></a>
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
