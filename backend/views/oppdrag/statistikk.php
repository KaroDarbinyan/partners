<?php

/* @var $this yii\web\View */

use backend\components\UrlExtended;
use common\models\Forms;

/* @var $model \common\models\Property */

$this->title = 'Statistikk';
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Oppdrag</span>',
    'url' => ['/oppdrag/'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = $this->title;

$model = $this->params['model'];
$partners_data = Forms::getLeadsCount($model->id);
$digital_marketing_data = $model->digitalMarketingDeltaStandard;
$impressions = 0;
$clicks = 0;

foreach ($digital_marketing_data as $item) {
    $arr = json_decode($item, true);
    if (isset($arr['clicks'])){
        $clicks += $arr['clicks'];
    }
    if(isset($arr['impressions'])) {
        $impressions += $arr['impressions'];
    }
}

?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="row">
        <div class="col-lg-4">
            <a class="w-100 p-0">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body m--block-center forsiden">
                        <img alt="" src="/img/logo.svg" class="logotype w-100 center-block mt-5 pt-4" style="height: 100px">
                        <hr>
                        <b><?= isset($model->propertyAds) ? $model->propertyAds->eiendom_viewings : 0; ?></b>
                        <p>besøk på partners.no</p>
                        <hr>
                        <b><?= $partners_data['salgsoppgave']; ?></b>
                        <p>har bestilt salgsoppgave</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4">
            <?php //Merge: dev-clone -> ringeliste ?>
            <?php if (count($model->digitalMarketing) > 0): ?>
            <a href="<?= UrlExtended::toRoute(['oppdrag/digital-marketsforing/', 'id' => $model->id]); ?>"
               class="btn w-100 p-0">
                <?php else: ?>
                <a class="w-100 p-0" style="cursor: unset">
                    <?php endif; ?>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body m--block-center forsiden">
                        <img alt="" src="/img/dm.png" class="logotype w-100 center-block mt-5 pt-4" style="height: 100px; width: auto !important;">
                        <hr>
                        <b><?= $clicks; ?></b>
                        <p>har besøkt annonsen</p>
                        <hr>
                        <b><?= $impressions; ?></b>
                        <p>har sett annonsen</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4">
            <a class="w-100 p-0">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body m--block-center forsiden">
                        <img alt="" src="/img/finn.svg" class="logotype w-100 center-block mt-5 pt-4" style="height: 100px">
                        <hr>
                        <b><?= $model->propertyAds->finn_viewings ?? 0 ?></b>
                        <p>har besøkt annonsen</p>
                        <hr>
                        <b><?= $model->propertyAds->finn_emails ?? 0; ?></b>
                        <p>har fått boligen din på e-post</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

