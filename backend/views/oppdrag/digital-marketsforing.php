<?php
/* @var $this yii\web\View */

/* @var $dm DigitalMarketing */

/* @var $dm_soc array */

use backend\assets\AppAsset;
use common\models\DigitalMarketing;

$this->title = 'Digital markedsføring';
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Oppdrag</span>',
    'url' => ['/oppdrag/'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = $this->title;


$this->registerJsFile('https://www.amcharts.com/lib/4/core.js',
    ['depends' => [AppAsset::className()]]);
$this->registerJsFile('https://www.amcharts.com/lib/4/charts.js',
    ['depends' => [AppAsset::className()]]);
$this->registerJsFile('https://www.amcharts.com/lib/4/themes/animated.js',
    ['depends' => [AppAsset::className()]]);
$this->registerJsFile(Yii::$app->getUrlManager()->getBaseUrl() . '/js/forsiden.js',
    ['depends' => [AppAsset::className()]]);


?>

<div data-dynamic-content="main-content" style="color: white; flex: 1; max-width: 100%;">

    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-content dm-header">
            <h1 class="forsiden-header">DIGITAL MARKEDSFØRING</h1>
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-portlet m-portlet--mobile">
                        <div class="m-portlet__head forsiden-head">
                            <p class="w-100 p-4 h2 text-center"><span>PERIODE</span> <?= $dm['start']; ?>
                                - <?= $dm['stop']; ?></p>
                        </div>
                        <div class="m-portlet__body m--block-center forsiden">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <b><?= $dm['cl_sum']; ?></b>
                                            <p>klikk</p>
                                        </div>
                                        <div class="col-md-4">
                                            <b><?= $dm['im_sum']; ?></b>
                                            <p>visninger</p>
                                        </div>
                                        <div class="col-md-4">
                                            <b><?= $dm['rc_sum']; ?></b>
                                            <p>unike visninger</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <!--<div class="row p-5">
                                <div class="col-md-6 p-5">
                                    <div id="pieChartDiv"></div>
                                </div>
                                <div class="col-md-6 p-5">
                                    <div id="columnChartDiv"></div>
                                </div>
                            </div>-->

                        </div>
                        <table class="table table-hover forsiden-table dm-table">
                            <thead>
                            <tr>
                                <th class="text-left pl-5">
                                    <div>KILDE</div>
                                </th>
                                <th>
                                    <div>CTR</div>
                                </th>
                                <th>
                                    <div>KLIKK</div>
                                </th>
                                <th>
                                    <div>VISNINGER</div>
                                </th>
                                <th>
                                    <div>UNIKE VIS.</div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($dm_soc as $item): ?>
                                <?php if ($item["tag"] == "td"): ?>
                                    <tr>
                                        <td class="text-left pl-5">
                                            <ins>
                                                <?= ucfirst($item["title"]); ?><i
                                                        class="<?= $item["class"]; ?> ml-3"></i>
                                            </ins>
                                        </td>
                                        <td><?= $item['clicks'] != 0 ? round($item['clicks'] / $item['impressions'] * 100, 2) . '%' : 0; ?></td>
                                        <td><?= $item['clicks']; ?></td>
                                        <td><?= $item['impressions']; ?></td>
                                        <td><?= $item['reach']; ?></td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <th class="text-left pl-5">
                                            <ins>
                                                <?= ucfirst($item["title"]); ?><i class="<?= $item["class"]; ?> ml-3"></i>
                                            </ins>
                                        </th>
                                        <th><?= $item['clicks'] != 0 ? round($item['clicks'] / $item['impressions'] * 100, 2) . '%' : 0; ?></th>
                                        <th><?= $item['clicks']; ?></th>
                                        <th><?= $item['impressions']; ?></th>
                                        <th><?= $item['reach']; ?></th>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-left pl-5">TOTALT</th>
                                <th><?= $dm['cl_sum'] != 0 ? round($dm['cl_sum'] / $dm['im_sum'] * 100, 2) . '%' : 0; ?></th>
                                <th><?= $dm['cl_sum']; ?></th>
                                <th><?= $dm['im_sum']; ?></th>
                                <th><?= $dm['rc_sum']; ?></th>
                            </tr>
                            </tfoot>
                        </table>
                        <div class="row">
                            <div class="col-md-12 p-5">
                                <p class="h5 pl-3 pr-3">Kombinasjonen mellom annonser er veldig viktig. Annonser i
                                    sosiale medier har høyere klikkprosent, men høyere kostnad for visning og mange av
                                    klikkene kommer av visninger på de store norske avisene som kommer gjennom
                                    programmatiske annonser. Programmatiske annonser har høy visibilitet og sikrer at
                                    både brand og objekt huskes lettere når man viser annonsene på nytt. Visningen av
                                    disse annonsene vil ikke direkte se ut som det har høy klikkverdi, men indirekte har
                                    det veldig god effekt. En god CTR på programmatisk retargeting er alt mellom 0,10%
                                    og 0,20%. Alt over er fantastisk.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



