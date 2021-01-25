<?php

/* @var $this yii\web\View */
/* @var $maxMin integer */
/* @var $maxMinArea array */
/* @var $price integer */
/* @var $areas array */
/* @var $typesOfOwnership array */
/* @var $roomCounts array */
/* @var $count integer */
/* @var $archives boolean */
/* @var $propertiesData array */
/* @var $filters array */

use yii\helpers\Url;

$this->title = 'Eiendomene til salgs, kjøpe eiendom';

?>

<?php $this->beginBlock('head') ?>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?= $this->title; ?>"/>
    <meta property="og:description"
          content="&Partners er en del av et white label system for levering av eiendomsmeglertjenester.
          Hvert enkelt kontor er organisert som egne aksjeselskap med særskilt
          tillatelse fra Finanstilsynet til å drive eiendomsmeglingsvirksomhet og
          drifter for egen regning og risiko. Nettsiden driftes av Involve Advertising AS,
           org. nr. 934252691. kontakt: partners@involve.no Personvern"/>
    <meta property="og:url" content="<?= Url::current([], true); ?>"/>
    <meta property="og:image" content="<?= Url::home(true); ?>img/property-default.jpg"/>
    <meta property="og:site_name" content="PARTNERS.NO"/>
<?php $this->endBlock() ?>

<?php $this->beginBlock('page_header') ?>
<header class="header bg_img bg_overlay" data-background="/img/header_catalog_bg.jpg">

</header>
<?php $this->endBlock() ?>

<section class="section_block">
    <div class="container mix_top">
        <div class="row">
            <div id="properties-filters" class="col-12 col-lg-3">
                <?= $this->render('@frontend/views/properties/filters.php',
                    compact('filters')
                ) ?>
            </div>
            <div class="col-12 col-lg-9">
                <div class="d-flex">
                    <h1 class="h4 mb-4 flex-grow-1">
                        <span id="properties-count"><?= $propertiesData['count'] ?></span> <?= $propertiesData['newBuildings'] ? 'prosjekter' : 'eiendommer' ?>
                    </h1>
                    <select aria-label="Sortering" class="custom-select custom-select-transparent w-auto js-properties-sort">
                        <option value="" selected>Sortering etter relevans</option>
                        <option value="price_desc">Pris høy-lav</option>
                        <option value="price_asc">Pris lav-høy</option>
                        <option value="area_desc">Kvm høy-lav</option>
                        <option value="area_asc">Kvm lav-høy</option>
                    </select>
                </div>

                <div id="properties-list">
                    <?= $this->render('@frontend/views/properties/list.php', $propertiesData) ?>
                </div>
            </div>
        </div>
    </div>
</section>
