<?php

/* @var $this yii\web\View */

use backend\assets\AppAsset;

$this->title = 'Markedsforing';
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Prospekter</span>',
    'url' => ['/oppdrag/befaringsmappe/omrade'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/lead-solgte.js',
    ['depends' => [AppAsset::className()]]);
?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <div class="m-content">

        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs  m-tabs-line m-tabs-line--2x m-tabs-line--danger" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a href="/admin/clients/detaljer" class="nav-link m-tabs__link">Detaljer</a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a href="/admin/clients/potensielle" class="nav-link m-tabs__link">Potensielle interessenter <sup
                                    class="orange">432</sup></a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a href="/admin/clients/markedsforing" class="nav-link m-tabs__link active">Digital
                            markedsføring</a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a href="/admin/clients/solgte" class="nav-link m-tabs__link">Solgte i nærheten <sup
                                    class="orange">432</sup></a>
                    </li>
                </ul>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__body">

                        <ul class="nav nav-tabs  m-tabs-line m-tabs-line--success" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_tabs_7_1"
                                   role="tab" aria-selected="true"><i class="la la-list"></i> Pakker</a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_7_2" role="tab"
                                   aria-selected="false"><i class="la la-bullhorn"></i> FAQ</a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_7_3" role="tab"
                                   aria-selected="false"><i class="la la-bank"></i> Leverandør</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="m_tabs_7_1" class="tab-pane active show" role="tabpanel">


                                <div class="m-pricing-table-2">
                                    <div class="m-pricing-table-2__head">
                                        <div class="m-pricing-table-2__title m--font-light">
                                            <h1>Vi kan tilby følgende pakker for <strong>Digital markedsføring</strong>
                                            </h1>
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="m-pricing-table_content1" aria-expanded="true">
                                            <div class="m-pricing-table-2__content">
                                                <div class="m-pricing-table-2__container">
                                                    <div class="m-pricing-table-2__items row">
                                                        <div class="m-pricing-table-2__item col-lg-4">
                                                            <div class="m-pricing-table-2__visual">
                                                                <div class="m-pricing-table-2__hexagon"></div>
                                                                <span class="m-pricing-table-2__icon m--font-info"><i
                                                                            class="fa flaticon-gift"></i></span>
                                                            </div>
                                                            <h2 class="m-pricing-table-2__subtitle">Standardpakke</h2>
                                                            <div class="m-pricing-table-2__features">
                                                                <img src="/admin/images/man.svg">
                                                                <img src="/admin/images/man.svg">
                                                                <img src="/admin/images/man.svg">
                                                                <img src="/admin/images/man-gray.svg">
                                                                <img src="/admin/images/man-gray.svg">
                                                                <img src="/admin/images/man-gray.svg">
                                                                <br/>
                                                                <br/>
                                                                <h4>Medium rekkevidde</h4>
                                                            </div>
                                                            <span class="m-pricing-table-2__price">2 265</span>
                                                            <span class="m-pricing-table-2__label">NOK</span>
                                                            <div class="m-pricing-table-2__btn">
                                                                <button type="button"
                                                                        class="btn m-btn--pill  btn-info m-btn--wide m-btn--uppercase m-btn--bolder m-btn--lg">
                                                                    Bestill
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="m-pricing-table-2__item col-lg-4">
                                                            <div class="m-pricing-table-2__visual">
                                                                <div class="m-pricing-table-2__hexagon"></div>
                                                                <span class="m-pricing-table-2__icon m--font-info"><i
                                                                            class="fa flaticon-confetti"></i></span>
                                                            </div>
                                                            <h2 class="m-pricing-table-2__subtitle">Oppgraderingspakke
                                                                1</h2>
                                                            <div class="m-pricing-table-2__features">
                                                                <img src="/admin/images/man.svg">
                                                                <img src="/admin/images/man.svg">
                                                                <img src="/admin/images/man.svg">
                                                                <img src="/admin/images/man.svg">
                                                                <img src="/admin/images/man-gray.svg">
                                                                <img src="/admin/images/man-gray.svg">
                                                                <br/>
                                                                <br/>
                                                                <h4>Stor rekkevidde</h4>
                                                            </div>
                                                            <span class="m-pricing-table-2__price">2 265 +</span>
                                                            <span class="m-pricing-table-2__label">NOK</span>
                                                            <div class="m-pricing-table-2__btn">
                                                                <button type="button"
                                                                        class="btn m-btn--pill  btn-info m-btn--wide m-btn--uppercase m-btn--bolder m-btn--lg">
                                                                    Bestill
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="m-pricing-table-2__item col-lg-4">
                                                            <div class="m-pricing-table-2__visual">
                                                                <div class="m-pricing-table-2__hexagon"></div>
                                                                <span class="m-pricing-table-2__icon m--font-info"><i
                                                                            class="fa  flaticon-rocket"></i></span>
                                                            </div>
                                                            <h2 class="m-pricing-table-2__subtitle">Oppgraderingspakke
                                                                2</h2>
                                                            <div class="m-pricing-table-2__features">
                                                                <img src="/admin/images/man.svg">
                                                                <img src="/admin/images/man.svg">
                                                                <img src="/admin/images/man.svg">
                                                                <img src="/admin/images/man.svg">
                                                                <img src="/admin/images/man.svg">
                                                                <img src="/admin/images/man.svg">
                                                                <br/>
                                                                <br/>
                                                                <h4>Maksimal rekkevidde</h4>
                                                            </div>
                                                            <span class="m-pricing-table-2__price">4 530 +</span>
                                                            <span class="m-pricing-table-2__label">NOK</span>
                                                            <div class="m-pricing-table-2__btn">
                                                                <button type="button"
                                                                        class="btn m-btn--pill  btn-info m-btn--wide m-btn--uppercase m-btn--bolder m-btn--lg">
                                                                    Bestill
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed font-size-16">
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-1"></div>
                                            <div class="col-lg-5">
                                                <ul class="target-list">
                                                    <li>Sosiale medier - Facebook og Instagram</li>
                                                    <li>Bannerannonsering i utvalgte medier tilpasset lokale forhold,
                                                        valgt ut fra våre 1000 tilgjengelige nettsteder
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-5">
                                                <ul class="target-list">
                                                    <li>Profesjonelt oppsett og oppfølging</li>
                                                    <li>Splitt-testing og løpende optimalisering</li>
                                                    <li>Markedsledende teknologi som sikrer at du treffer boligkjøperne
                                                        der de er
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-1"></div>
                                        </div>
                                    </div>

                                    <div class="center">
                                        <a href="https://files.partners.no/dokumenter/digitalmarkedsf%C3%B8ring.pdf"
                                           target="_blank" class="btn btn-danger m-btn m-btn--outline-2x btn-lg"
                                           style="padding: 20px 50px !important;">
                                            <img src="/admin/app/media/img/files/pdf.svg" alt="" style="width: 40px;">
                                            PRODUKTARK
                                        </a>
                                    </div>

                                    <div class="markedsicons">
                                        <img src="/admin/images/vg-icon.svg">
                                        <img src="/admin/images/facebook-icon.svg">
                                        <img src="/admin/images/instagram-icon.svg">
                                        <img src="/admin/images/dagbladet-icon.svg">
                                        <img src="/admin/images/aftenposten-icon.svg">
                                        <img src="/admin/images/google-icon.svg">
                                        <img src="/admin/images/tv2-icon.svg">
                                    </div>

                                </div>


                            </div>
                            <div id="m_tabs_7_2" class="tab-pane" role="tabpanel">


                                <h4>Hva er Digital markedsføring?</h4>
                                <p>Digital markedsføring er Partners program for digital annonsering. Ved hjelp av
                                    markedsledende og intelligent teknologi treffer boligselger riktig publikum.</p>

                                <h4>Hva gjør Digital markedsføring bra?</h4>
                                <p>Digital markedsføring er bygget på teknologi som er helt i front med tanke på
                                    identifisering av potensielle interessenter — dette er viktig for å kunne oppnå god
                                    match mellom interesser, preferanser og riktig bolig.</p>

                                <h4>Hva er programmatisk annonsekjøp?</h4>
                                <p>Enkelt forklart er programmatisk annonsering automatisert kjøp og salg av
                                    nettannonser ved hjelp av avanserte programvare, eller algoritmer. Handelen foregår
                                    via en en børs der tilknyttede medier har lagt ut annonseplasser, eller visninger,
                                    for salg. Annonsekjøpere kan kan på sin side legge inn bud på hva man ønsker å
                                    betale for en visning, basert på definerte kriterier. Når alle kriteriene matcher
                                    med en tilbudt annonseplass gjennomføres kjøpet automatisk og annonsen vises i da i
                                    sanntid (Real Time Bidding (RTB) = programmatiske kjøp gjennom en børs).</p>

                                <h4>Målgruppesentrisk versus mediesentrisk</h4>
                                <p>Mens en mediesentrisk tankegang fokuserer på breddedekning og tilstedeværelse i flest
                                    mulig medier, vil en målgruppesentrisk tilnærming etterstrebe en nærmest kirurgisk
                                    målretting i forhold til å nå de rette målgruppene. Målgruppesentrisk annonsering av
                                    høy kvalitet evner å treffe rette målgrupper og dermed oppnå høy grad av
                                    treffsikkerhet.</p>
                                <p>Partners Digital markedsføring har analysert og samlet unike norske forbrukerdata,
                                    feks. alder, bosted, økonomi og boligtype (kilde: SSB, Matrikkelen, Ligninsdata,
                                    folkeregisteret, TNS Gallup) som legges til grunn for å sikre at boligannonsen
                                    presenteres for riktige kjøpere.</p>
                                <p>Ekslusivt for Digital markedsføring er det utviklet egne datasett som legges til
                                    grunn for valg av målgrupper. Dataene er basert på verdens ledende analyseverktøy
                                    for klassifisering av forbrukere som gir Norges mest presise innsikt om norske
                                    forbrukere.</p>

                                <h4>Hvorfor er algoritmer viktig i denne sammenheng?</h4>
                                <p>Enkelt sagt er det algoritmene som definerer kvaliteten på handelen. Kriterier som
                                    omfatter alder, postnummer, søkehistorikk og en rekke andre skreddersydde
                                    forutsetninger skal treffe riktig publikum akkurat der de bruker nettet i
                                    øyeblikket. Derfor representerer disse algoritmene kritiske konkurransefortrinn. Det
                                    handler om å eksponere de riktige menneskene for det riktige innholdet til den
                                    riktige tid.</p>

                                <h4>Hva betyr egentlig optimalisering?</h4>
                                <p>Programmatisk annonsekjøp forutsetter teknologi som påvirker annonsens kvalitet på to
                                    måter. For det første generer den match mellom definerte kriterier og tilgjengelige
                                    annonsevisninger. For det andre evalueres resultatene løpende slik at annonsen til
                                    enhver tid følger de sporene som gir best resultat</p>

                                <h4>Hvorfor er Digital markedsføring et av markedets beste digitale annonseprogram?</h4>
                                <p>Digital markedsføring bygger på markedsledende programvare med algoritmer som
                                    identifiserer flest mulig kvalifiserte boligkjøpere. Digital markedsføring er et
                                    fleksibelt annonseprogram som gir boligselger anledning til å velge blant tre ulike
                                    pakker. Alle pakkene er nøye utvalgt av Partners for å gi best mulig effekt og ikke
                                    minst value for money. Digital markedsføring har størst rekkevidde i Norge og sikrer
                                    at boligselger har de beste forutsetninger for å nå relevant publikum – og følgelig
                                    oppnå flest mulig på visning. Digital markedsføring dekker opptil 1000 norske
                                    nettsteder, bl.a. E24, Hegnar, Dagbladet, lokale nettaviser, Google, Facebook,
                                    Instagram, foruten norske lesere av utenlanske nettaviser.</p>

                                <h4>Høyere pris på boligen</h4>
                                <p>Med Digital markedsføring når boligselger ut til et større og mer relevant publikum.
                                    Dette kan bety flere på visning og mulighet for en høyere pris på boligen.</p>

                                <h4>Leveringstid</h4>
                                <p>Bestillingen blir produsert innen 24 timer alle virkedager. Fredag må bestillingen
                                    inn før 13.00 om vi kan garantere at den leveres før helg.</p>


                            </div>
                            <div id="m_tabs_7_3" class="tab-pane" role="tabpanel">


                                <h4>Kontakt oss</h4>
                                <ul class="ul-padding-0">
                                    <li><a href="maitlo:tobias@ekkomedia.no">tobias@ekkomedia.no</a><br><span>+47 952 78 186</span>
                                    </li>
                                </ul>


                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>
</div>