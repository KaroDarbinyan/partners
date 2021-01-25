<?php
/* @var $this yii\web\View */

use backend\assets\AppAsset;

$this->title = 'Team';
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Oppdrag</span>',
    'url' => ['/oppdrag/'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Befaringsmappe</span>',
    'url' => ['/oppdrag/befaringsmappe/omrade'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('//maps.google.com/maps/api/js?key=AIzaSyBigZy49qUlMNHKyai6MSjdMW3Bl-p2HqM&callback=initMap',
    [
        'depends' => AppAsset::className(),
        'async' => true, 'defer' => true
    ]);
$this->registerJsFile('admin/js/google-maps.js',
    ['depends' => [AppAsset::className()]]);
$this->registerJsFile('admin/js/befaringsmappe/omrade.js',
    ['depends' => [AppAsset::className()]]);

?>
<div class="m-portlet__body" style="padding: 0;">

    <div class="row">
        <div class="col-md-6">
            <div id="map"
                 style="height:calc(100vh - 165px); border-bottom-left-radius: 1rem;"></div>
        </div>
        <div class="col-md-6" style="padding-right: 30px; padding-top: 15px;">

            <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--danger additional"
                role="tablist">
                <li class="nav-item m-tabs__item ">
                    <a class="nav-link m-tabs__link active" data-toggle="tab" role="tab"
                       href="#m_tabs_1_1">
                        Bilder
                    </a>
                </li>
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" role="tab"
                       href="#m_tabs_1_2">
                        Detaljer
                    </a>
                </li>
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" role="tab"
                       href="#m_tabs_1_3">
                        Statistikk
                    </a>
                </li>
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" role="tab"
                       href="#m_tabs_1_4">
                        Nabolagsprofil
                    </a>
                </li>
            </ul>


            <div class="tab-content">
                <div class="tab-pane active" id="m_tabs_1_1" role="tabpanel">
                    <div class="m-section__content">
                        <div class="oppdrag-gallery">
                            <div class="m-section__content">
                                <img src="/admin/images/oppdrag-gallery.jpg">
                                <div class="row" style="margin-top: 20px">
                                    <div class="col-xs-4 col-sm-4">
                                        <img src="/admin/images/oppdrag-gallery.jpg">
                                    </div>
                                    <div class="col-xs-4 col-sm-4">
                                        <img src="/admin/images/oppdrag-gallery.jpg">
                                    </div>
                                    <div class="col-xs-4 col-sm-4">
                                        <img src="/admin/images/oppdrag-gallery.jpg">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane" id="m_tabs_1_2" role="tabpanel">

                    <div class="m-scrollable" data-scrollable="true" data-height="550"
                         data-scrollbar-shown="true">
                        <span class="schala-status" style="margin: 0px 0 0 0;"><span
                                    class="m-badge m-badge-xxl m-badge--dot schala-status-kontaktet"></span><em>kontaktet</em></span>
                        <table class="table m-table m-table--head-no-border table-hover">
                            <tbody>
                            <tr>
                                <th style="border-top: 0;"></th>
                                <td style="border-top: 0;"></td>
                            </tr>
                            <tr>
                                <th scope="row">Veinavn</th>
                                <td>Hausmanns gate 19A</td>
                            </tr>
                            <tr>
                                <th scope="row">Postadresse</th>
                                <td>0182 OSLO</td>
                            </tr>
                            <tr>
                                <th scope="row">Type</th>
                                <td>Leilighet</td>
                            </tr>
                            <tr>
                                <th scope="row">Primærrom</th>
                                <td>52 m<sup>2</sup></td>
                            </tr>
                            <tr>
                                <th scope="row">Prisantydning</th>
                                <td>3 500 000,-</td>
                            </tr>
                            <tr>
                                <th scope="row">Andel fellesgjeld</th>
                                <td>28 762,-</td>
                            </tr>
                            <tr>
                                <th scope="row">Byggeår</th>
                                <td>1896</td>
                            </tr>
                            <tr>
                                <th scope="row">Eiertype</th>
                                <td>Borettslag</td>
                            </tr>
                            <tr>
                                <th scope="row">Borettslag</th>
                                <td>Hausmannsgaten 19 Borettslag (Reg=2011.03.14 av SMO) /
                                    967155799
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Oppdragsnummer</th>
                                <td>17180252</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="m_tabs_1_3" role="tabpanel">

                </div>
                <div class="tab-pane" id="m_tabs_1_4" role="tabpanel">

                    <div>
                        <table class="table m-table m-table--head-no-border table-hover table-cell-center"
                               id="m_table_1">
                            <thead>
                            <tr>
                                <th>Type</th>
                                <th>Navn</th>
                                <th>Avstand</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Dagligvare</td>
                                <td>Coop Prix Hausmannsgate</td>
                                <td>10</td>
                            </tr>
                            <tr>
                                <td>Bussholdeplass</td>
                                <td>Calmeyers gate</td>
                                <td>30</td>
                            </tr>
                            <tr>
                                <td>Apotek</td>
                                <td>Ditt apotek Anker</td>
                                <td>30</td>
                            </tr>
                            <tr>
                                <td>Kiosk/video</td>
                                <td>Narvesen Anker Studentboliger</td>
                                <td>60</td>
                            </tr>
                            <tr>
                                <td>Trikkeholdeplass</td>
                                <td>Hausmanns gate</td>
                                <td>100</td>
                            </tr>
                            <tr>
                                <td>Treningssenter</td>
                                <td>Actic - Storgata</td>
                                <td>110</td>
                            </tr>
                            <tr>
                                <td>Barnehage</td>
                                <td>Eventyrbrua steinerbarnehage (1-6 år)</td>
                                <td>120</td>
                            </tr>
                            <tr>
                                <td>Bysykkel</td>
                                <td>Legevakten</td>
                                <td>140</td>
                            </tr>
                            <tr>
                                <td>Bysykkel</td>
                                <td>Jakob kirke</td>
                                <td>150</td>
                            </tr>
                            <tr>
                                <td>Kiosk/video</td>
                                <td>7-Eleven Torgt./Osterhaugsgate</td>
                                <td>150</td>
                            </tr>
                            <tr>
                                <td>Barnehage</td>
                                <td>Kristent interkulturell arbeidsbhg.</td>
                                <td>170</td>
                            </tr>
                            <tr>
                                <td>Steder</td>
                                <td>Legevakten</td>
                                <td>170</td>
                            </tr>
                            <tr>
                                <td>Steder</td>
                                <td>Ankerbrua</td>
                                <td>180</td>
                            </tr>
                            <tr>
                                <td>Treningssenter</td>
                                <td>Harald's Gym</td>
                                <td>200</td>
                            </tr>
                            <tr>
                                <td>Bysykkel</td>
                                <td>Hausmanns gate</td>
                                <td>200</td>
                            </tr>
                            <tr>
                                <td>Ladepunkt for elbil</td>
                                <td>Chr. Kroghkvartalet p-hus</td>
                                <td>210</td>
                            </tr>
                            <tr>
                                <td>Barnehage</td>
                                <td>Hausmannsgate Espira barnehage (0-6 år)</td>
                                <td>220</td>
                            </tr>
                            <tr>
                                <td>Ladepunkt for elbil</td>
                                <td>Christian Krohgs gate, Oslo</td>
                                <td>230</td>
                            </tr>
                            <tr>
                                <td>Steder</td>
                                <td>Nybrua</td>
                                <td>230</td>
                            </tr>
                            <tr>
                                <td>Ladepunkt for elbil</td>
                                <td>Bernt Ankers gate, Oslo</td>
                                <td>230</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

