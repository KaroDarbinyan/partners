<?php

/* @var $this yii\web\View */
/** @var $model common\models\PropertyDetails */
/** @var $sp_boosts SpBoost[] */

use backend\assets\AppAsset;
use backend\components\UrlExtended;
use common\components\StaticMethods;
use common\models\SpBoost;
use yii\helpers\Url;

$this->title = 'Detaljer';
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Oppdrag</span>',
    'url' => ['/oppdrag/'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = $this->title;

//$this->registerJsFile('//maps.google.com/maps/api/js?key=AIzaSyBigZy49qUlMNHKyai6MSjdMW3Bl-p2HqM&callback=initMap',
//    [
//        'depends' => AppAsset::className(),
//        'async' => true, 'defer' => true
//    ]);
//$this->registerJsFile('admin/js/google-maps.js',
//    ['depends' => [AppAsset::className()]]);
$this->registerJsFile('admin/js/oppdrag-detaljer.js',
    ['depends' => [AppAsset::className()]]);
$this->registerJs("window.property_boosts = {$sp_boosts}");

$postNumber = $model->postnummer;
\common\components\Befaring::numFormat($postNumber);
$model->postnummer = $postNumber;

$overPrisantydning = $model->salgssum ? (
    number_format($model->salgssum - $model->prisantydning, 0, '', ' ') . ",- (" .
    round(($model->salgssum - $model->prisantydning) * 100 / $model->salgssum, 1) . " % )"
):$model->prisantydning;

?>

<div class="row">
    <div class="col-lg-5">

        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="" style="margin-top: 15px;">
                        <h4 style="color: white;">
                            DETALJER
                        </h4>
                        <!-- Render Update client form -->
                        <?= $this->render('_checkbox', [
                            'model' => $model,
                        ]) ?>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                <?php if ( Yii::$app->mobileDetect->isMobile() ) { ?>
                <?php /* MOBILE VERSION */ ?>

                    <div class="dropdown right">
                        <button class="btn btn-success m-btn dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            Handlinger
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <?= $this->render('_button', [
                                'model' => $model,
                            ]) ?>
                            <a href="<?= Url::toRoute(['oppdrag/moreadds', 'id' => $model->id]) ?>" class="dropdown-item js-sp-boost">Boost</a>
                            <a href="/befaring/<?= $model->id ?>" target="_blank" class="dropdown-item">Befaring</a>
                            <a href="/visning/<?= $model->id ?>" target="_blank" class="dropdown-item">Visning</a>
                            <a href="<?= Url::toRoute(['eiendomsverdi/index', 'address' => $model->adresse . ' ' . $model->postnummer]); ?>" target="_blank" class="dropdown-item">Eiendomsverdi</a>
                        </div>
                    </div>

                <?php } else { ?>
                <?php /* DESKTOP VERSION */ ?>
                    <?php //Merge: dev-clone -> ringeliste ?>
                    <div class="dropdown right">
                        <button class="btn btn-success m-btn dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            Handlinger
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <?= $this->render('_button', [
                                'model' => $model,
                            ]) ?>
                            <a href="<?= Url::toRoute(['oppdrag/moreadds', 'id' => $model->id]) ?>" class="dropdown-item js-sp-boost">Boost</a>
                            <a href="/befaring/<?= $model->id ?>" target="_blank" class="dropdown-item">Befaring</a>
                            <a href="/visning/<?= $model->id ?>" target="_blank" class="dropdown-item">Visning</a>
                            <a href="<?= Url::toRoute(['eiendomsverdi/index', 'address' => $model->adresse . ' ' . $model->postnummer]); ?>" target="_blank" class="dropdown-item">Eiendomsverdi</a>
                        </div>
                    </div>
                <?php } ?>

                </div>
            </div>
            <div class="m-portlet__body">

                <!--begin::Section-->
                <div class="">
                    <div class="m-section__content">
                        <table class="table m-table m-table--head-no-border table-hover">
                            <tbody>
                            <tr>
                                <th scope="row">Veinavn</th>
                                <td><?= $model->adresse ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Postadresse</th>
                                <td>
                                    <?= $model->postnummer ?>
                                    <?= $model->poststed ?>
                                </td>
                            </tr>
                            <!--<tr>
                                <th scope="row">Type</th>
                                <td><?= $model->tinde_oppdragstype ?></td>
                            </tr>-->
                            <tr>
                                <th scope="row">Primærrom</th>
                                <td><?= $model->prom ?> m<sup>2</sup></td>
                            </tr>
                            <!--<tr>
                                <th scope="row">Prisantydning</th>
                                <td><?= $model->prisantydning ?>,-</td>
                            </tr>-->
                            <tr>
                                <th scope="row">Byggeår</th>
                                <td><?= $model->byggeaar ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Type / Eierform</th>
                                <td><?= $model->type_eiendomstyper ?> / <?= $model->type_eierformbygninger ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Tomt</th>
                                <td><?= number_format($model->tomteareal, 0, '', ' ') . " m² / {$model->type_eierformtomt}" ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Oppdragsnummer</th>
                                <td><a href="/eiendom/<?= $model->id ?>"
                                       target="_blank"><?= $model->oppdragsnummer ?></a></td>
                            </tr>

                            <tr>
                                <th scope="row">Forventet salgspris</th>
                                <td class="forventet_salgspris" data-action="/admin/oppdrag/update/<?= $model->id; ?>">
                                    <input type="text" value="<?= $model->forventet_salgspris ? StaticMethods::number_format($model->forventet_salgspris) : ''; ?>">
                                    <a href="#" class="btn btn-xs btn-outline-success ml-2 is-save"><i class="fas fa-check" aria-hidden="true"></i></a>
                                </td>
                            </tr>

                            <?php if ($parent = $model->parent): ?>
                                <tr>
                                    <th>Hovedannonse</th>
                                    <td>
                                        <a href="<?= UrlExtended::toRoute(['oppdrag/detaljer', 'id' => $parent->id]) ?>">
                                            <?= $parent->oppdragsnummer ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endif ?>

                            <?php if ($selgers = $model->selgers): ?>
                                <tr>
                                    <th>Selger</th>
                                    <td>
                                        <?php foreach (StaticMethods::mix_archive_form_data($selgers) as $selger): ?>
                                            <p>
                                                <span class="table-schala-time"><?= $selger["name"]; ?></span>
                                                <span class="table-schala-time-ago"><?= $selger["phone"] ? StaticMethods::convertPhone($selger["phone"]) : ""; ?></span>
                                                <span class="table-schala-time-ago"><?= $selger["email"]; ?></span>
                                            </p>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                            <?php endif ?>

                            <?php if ($model->isSold() && $kjopers = $model->kjopers): ?>
                                <tr>
                                    <th>Kjoper</th>
                                    <td>
                                        <?php foreach (StaticMethods::mix_archive_form_data($kjopers) as $kjoper): ?>
                                            <p>
                                                <span class="table-schala-time"><?= $kjoper["name"]; ?></span>
                                                <span class="table-schala-time-ago"><?= $kjoper["phone"] ? StaticMethods::convertPhone($kjoper["phone"]): ""; ?></span>
                                                <span class="table-schala-time-ago"><?= $kjoper["email"]; ?></span>
                                            </p>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                            <?php endif ?>

                            <tr>
                                <th>Megler</th>
                                <td>
                                    <?php $user = $model->user; ?>
                                    <p><img src="<?= $user->urlstandardbilde; ?>"
                                            class="m--img-rounded m--marginless table-schala-img" alt="">
                                        <span class="table-schala-time"><?= $user->navn; ?></span>
                                        <span class="table-schala-time-ago"><?= $user->department->short_name; ?></span>
                                    </p>
                                    <?php if ($ansatte2 = $model->ansatte2): ?>
                                        <p><img src="<?= $ansatte2->urlstandardbilde; ?>"
                                                class="m--img-rounded m--marginless table-schala-img" alt="">
                                            <span class="table-schala-time"><?= $ansatte2->navn; ?></span>
                                            <span class="table-schala-time-ago"><?= $ansatte2->department->short_name ?? ''; ?></span>
                                        </p>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php if (isset($model->propertyAds)): ?>
                            <tr>
                                <td class="font-weight-bold text-white">FINN.no</td>
                                <td>
                                    <a href="https://www.finn.no/realestate/homes/ad.html?finnkode=<?= $model->propertyAds->finn_adid ?>"
                                        target="_blank" style="text-decoration: underline; color: white;">
                                        <?= $model->propertyAds->finn_adid ?>
                                    </a>
                                </td>
                            </tr>
                            <?php endif; ?>

                            <!--<tr>
                                <th scope="row">FINN nummer</th>
                                <td><?= $model->finn_orderno ?></td>
                            </tr>-->
                            </tbody>
                        </table>
                        <?php if ($model->propertyImage): ?>
                            <div class="oppdrag-gallery">
                                <div class="m-section__content">
                                    <img src="<?= $model->propertyImage->urlstorthumbnail ?>">
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                </div>

                <!--end::Section-->
            </div>
        </div>

        <?php if ($model->properties): ?>
            <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="" style="margin-top: 15px;">
                            <h4 style="color: white;">BOLIGER</h4>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="">
                        <div class="m-section__content">
                                <div class="table-responsive">
                                    <table class="table m-table m-table--head-no-border table-hover table-cell-center">
                                        <thead>
                                        <tr>
                                            <th scope="col">Bolig</th>
                                            <th scope="col">Soverom</th>
                                            <th scope="col">Etg</th>
                                            <th scope="col">P-rom</th>
                                            <th scope="col">BRA</th>
                                            <th scope="col">Prisantydning</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($model->properties as $prop): ?>
                                            <tr>
                                                <th scope="row"><a href="<?= UrlExtended::toRoute(['oppdrag/detaljer', 'id' => $prop->id]) ?>"><?= $prop->oppdragsnummer ?></a></th>
                                                <td><?= $prop->soverom ?></td>
                                                <td><?= $prop->etasje ?></td>
                                                <td><?php if ($prop->prom): ?><?= $prop->prom ?> m<sup>2</sup><?php endif ?></td>
                                                <td><?= $prop->bruksareal ?> m<sup>2</sup></td>
                                                <td><?= $prop->isSold() ? 'Solgt' : money($prop->prisantydning) ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <?php /*
        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
            <div class="m-portlet__body">
                <div id="map" style="height:300px; border-radius: 1rem;"></div>
            </div>
        </div>
        */ ?>

    </div>
    <div class="col-lg-7">

    
    <?php if ($model->solgt === -1): ?>
            <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="" style="margin-top: 15px;">
                            <h4 style="color: white;">
                                SALGSSTATISTIKK
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">

                    <!--begin::Section-->
                    <div class="">
                        <div class="m-section__content">
                            <table class="table m-table m-table--head-no-border table-hover">
                                <tbody>
                                <tr>
                                    <th scope="row">Salgssum</th>
                                    <td><?= number_format($model->salgssum, 0, '', ' '); ?>,-</td>
                                </tr>
                                <tr>
                                    <th scope="row">Prisantydning</th>
                                    <td><?= number_format($model->prisantydning, 0, '', ' '); ?>,-</td>
                                </tr>
                                <tr>
                                    <th scope="row">Over prisantydning</th>
                                    <td><?= $overPrisantydning ?></td>
                                </tr>
                                <?php if($model->prom): ?>
                                <tr>
                                    <th scope="row">Kvadratmeterpris</th>
                                    <td><?= number_format($model->salgssum / $model->prom, 0, '', ' '); ?>,-
                                    </td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <th scope="row"></th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">Salgstid</th>
                                    <td><?= $model->markedsforingsdato !== 0 ? round((strtotime(date($model->akseptdato)) - $model->markedsforingsdato) / (86400)) . ' dager' : '-'; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Befaringsdato</th>
                                    <td><?= $model->befaringsdato !== '' ? date('j. F Y', strtotime(date($model->befaringsdato))) : '-'; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Oppdragsdato</th>
                                    <td><?= date('j. F Y', $model->oppdragsdato); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Markedsføringsdato</th>
                                    <td><?= $model->markedsforingsdato !== 0 ? date('j. F Y', $model->markedsforingsdato) : '-'; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Akseptdato</th>
                                    <td><?= date('j. F Y', strtotime(date($model->akseptdato))); ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <!--NABOLAGSPROFIL-->
        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="" style="margin-top: 15px;">
                        <h4 style="color: white;">
                            NABOLAGSPROFIL
                        </h4>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin::Section-->
                <div class="">
                    <div class="m-section__content">
                        <table class="table m-table m-table--head-no-border table-hover table-cell-center"
                               data-table='oppdrag-details'
                        >
                            <thead>
                            <tr>
                                <th>Type</th>
                                <th>Navn</th>
                                <th>Avstand, km</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($model->propertyNeighbourhoods as $neighbour) { ?>
                                <tr>
                                    <td>
                                        <?=
                                            $neighbour->type == 'Higher education'
                                                ? 'Høyere utdanning'
                                                : (
                                                    $neighbour->type == 'Green environment'
                                                        ? 'Grøntområde'
                                                        : $neighbour->type
                                                )
                                        ?>
                                    </td>
                                    <td><?= $neighbour->name ?></td>
                                    <td><?= $neighbour->distance ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="m_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Har du husket å postere kostnad i WebMegler</h5>
                <button type="submit" class="close" data-dismiss="modal" aria-label="Close">Ja</button>
            </div>
            <div class="modal-body">
                <?= $this->render('_form',['prop'=>$model]) ?>
            </div>
            <div class="modal-footer special">
            </div>
        </div>
    </div>
</div>