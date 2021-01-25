<?php

/* @var $this yii\web\View */

$this->title = 'Leverandorer';
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Intranett</span>',
    'url' => ['/intranett/nyheter'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <!-- END: Subheader -->

    <div class="m-content">
        <button type="button" class="btn video-btn mb-4" data-toggle="modal" data-src="https://player.vimeo.com/video/400561123" data-target="#myModalVideo">
            <i class="flaticon-warning"></i> Instruksjonsvideo
        </button>
        <div class="row">
            <div class="col-xl-12">
                <div class="m-portlet">

                    <div class="m-portlet__body">
                        <!--begin::Section-->
                        <div class="">
                            <div class="">
                                <table class="table table-striped- table-bordered table-hover table-checkable dataTable dtr-inline">
                                    <thead>
                                    <tr>
                                        <th>Navn</th>
                                        <th>Kontakt</th>
                                        <th>Produkter</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><a href="https://hgmedia.no" target="_blank">HG Media</a></td>
                                        <td>
                                            <ul>
                                                <li>Jan-Erik Baglo</li>
                                                <li>4000 8551</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-printing"></span><em>printing</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ambita</td>
                                        <td>
                                            <ul>
                                                <li>Odd Inge Olsen</li>
                                                <li>920 41 500</li>
                                                <li><a href="mailto:oio@ambita.no;support@ambita.no" target="_blank">oio@ambita.no;support@ambita.no</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>eiendomsinformasjon</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Anticimex</td>
                                        <td>
                                            <ul>
                                                <li>Roger Zachariassen</li>
                                                <li>922 35 101</li>
                                                <li><a href="mailto:roger.zachariassen@anticimex.no" target="_blank">roger.zachariassen@anticimex.no</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>boligsalgsrapport</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="https://www.bdo.no" target="_blank">BDO</a></td>
                                        <td>
                                            <ul>
                                                <li>Hans Petter Urkeldal</li>
                                                <li>404 12 624</li>
                                                <li><a href="mailto:hans.petter.urkedal@bdo.no" target="_blank">hans.petter.urkedal@bdo.no</a></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-revisjon"></span><em>revisjon</em></span>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-obligatorisk"></span><em>obligatorisk</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Buysure</td>
                                        <td>
                                            <ul>
                                                <li>Kundesenter</li>
                                                <li>954 60 660</li>
                                                <li><a href="mailto:post@buysure.no" target="_blank">post@buysure.no</li>
                                                <li><a href="mailto:https://buysure.no" target="_blank">buysure.no</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>boligselgerforsikring</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cenera</td>
                                        <td>
                                            <ul>
                                                <li>Geir Engh</li>
                                                <li>924 21 433</li>
                                                <li><a href="mailto:geir.engh@cenera.no" target="_blank">geir.engh@cenera.no</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>skjermløsninger</em></span>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>Eiendom Norge</td>
                                        <td>
                                            <ul>
                                                <li>Peder Eckblad Tollersrud</li>
                                                <li><a href="mailto:pt@eiendomnorge.no" target="_blank">pt@eiendomnorge.no</li>
                                                <li><a href="mailto:post@eiendomnorge.no" target="_blank">post@eiendomnorge.no</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>foretaksforening</em></span>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>Eiendomsmegler.no</td>
                                        <td>
                                            <ul>
                                                <li>Alexander Jørgensen</li>
                                                <li><a href="mailto:alexander@eiendomsmegler.no" target="_blank">alexander@eiendomsmegler.no</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>leads</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="http://eiendomsverdi.no" target="_blank">Eiendomsverdi</a></td>
                                        <td>
                                            <ul>
                                                <li>Karl Frank Lindberg</li>
                                                <li>481 14 775</li>
                                                <li><a href="mailto:kfl@eiendomsverdi.no;post@eiendomsverdi.no" target="_blank">kfl@eiendomsverdi.no;post@eiendomsverdi.no</a></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-boligverdi"></span><em>eiendomsdata</em></span>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-boligstatistikk"></span><em>boligstatistikk</em></span>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td><a href="http://involve.no" target="_blank">INTRA CRM</a></td>
                                        <td>
                                            <ul>
                                                <li>Inger Føyen</li>
                                                <li>982 57 720</li>
                                                <li><a href="mailto:partners@involve.no" target="_blank">partners@involve.no</a></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-printing"></span><em>support</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Involve Advertising</td>
                                        <td>
                                            <ul>
                                                <li>Inger Føyen</li>
                                                <li>982 57 720</li>
                                                <li><a href="mailto:inger.foyen@involve.no" target="_blank">inger.foyen@involve.no</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>markedsavdeling</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="http://involve.no" target="_blank">Involve ProX</a></td>
                                        <td>
                                            <ul>
                                                <li>Pål Nilssen </li>
                                                <li>472 35 615</li>
                                                <li><a href="mailto:paal@involve.no" target="_blank">paal@involve.no</a></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-revisjon"></span><em>skilt</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Involve Profileringsartikler</td>
                                        <td>
                                            <ul>
                                                <li>Liv Hay Hordvik</li>
                                                <li>909 20 883</li>
                                                <li><a href="mailto:liv@profileringsartikler.no" target="_blank">liv@profileringsartikler.no</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>profileringsartikler</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Mettevoll</td>
                                        <td>
                                            <ul>
                                                <li>Johan Arnt Mettevoll</li>
                                                <li>924 27 240</li>
                                                <li><a href="mailto:mettevoll@mettevoll.no" target="_blank">mettevoll@mettevoll.no</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>fag</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Meglerfront</td>
                                        <td>
                                            <ul>
                                                <li>Jan Fredrik Gossner</li>
                                                <li>907 23 588</li>
                                                <li><a href="mailto:jfg@meglerfront.no" target="_blank">jfg@meglerfront.no</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>overtakelsesprotokoll / strøm</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Meglersiden</td>
                                        <td>
                                            <ul>
                                                <li>Ebba Emilie Nordahl-Fronth</li>
                                                <li>932 91 119</li>
                                                <li><a href="mailto:ebba.emilie.nordahl@schibsted.com" target="_blank">ebba.emilie.nordahl@schibsted.com</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>leads</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>NEF forsikringsfondet</td>
                                        <td>
                                            <ul>
                                                <li>Fredrik Langeland</li>
                                                <li>469 65 621</li>
                                                <li><a href="mailto:fredrik.langeland@howdengroup.no" target="_blank">fredrik.langeland@howdengroup.no</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>Sikkerhetsstillelse/forsikring</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nordic Easy</td>
                                        <td>
                                            <ul>
                                                <li>Ina Kristin Branting </li>
                                                <li>918 83 321</li>
                                                <li><a href="mailto:ina@nordiceasy.com" target="_blank">ina@nordiceasy.com</li>
                                                <li><a href="mailto:info@nordiceasy.com" target="_blank">info@nordiceasy.com</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>kalender</em></span>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>markedsweb</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="https://www.sagaservices.no" target="_blank">Saga Regnskap</a></td>
                                        <td>
                                            <ul>
                                                <li>Anne Pettersen</li>
                                                <li>482 72 746</li>
                                                <li><a href="mailto:anne@sagaservices.no" target="_blank">anne@sagaservices.no</a></li>
                                                <li><a href="mailto:post@sagaservices.no" target="_blank">post@sagaservices.no</a></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-regnskap"></span><em>regnskap</em></span>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-obligatorisk"></span><em>obligatorisk</em></span>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>SG Finans</td>
                                        <td>
                                            <ul>
                                                <li>Leif. F. Andersen</li>
                                                <li>906 92 296</li>
                                                <li><a href="mailto:leif-freddy.andersen@sgfinans.no" target="_blank">leif-freddy.andersen@sgfinans.no</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>factoring</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Schibsted / finn.no</td>
                                        <td>
                                            <ul>
                                                <li>Julie Bredal Guderud</li>
                                                <li>958 51 454</li>
                                                <li><a href="mailto:jbg@finn.no" target="_blank">jbg@finn.no</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>annonsering</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tjenestetorget</td>
                                        <td>
                                            <ul>
                                                <li>Aida Jansen</li>
                                                <li>951 59 975</li>
                                                <li><a href="mailto:aida@tjenestetorget.no " target="_blank">aida@tjenestetorget.no </li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>leads</em></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><a href="https://visolit.no" target="_blank">Visolit</a></td>
                                        <td>
                                            <ul>
                                                <li>Britt Godtfredsen</li>
                                                <li>911 04 540</li>
                                                <li><a href="mailto:support@visolit.no" target="_blank">support@visolit.no</a></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-e-post"></span><em>e-post</em></span>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-citrix"></span><em>citrix</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Weboppgjør</td>
                                        <td>
                                            <ul>
                                                <li>Morten Harberg Thorn</li>
                                                <li>555 08 596</li>
                                                <li><a href="mailto:morten@weboppgjor.no" target="_blank">morten@weboppgjor.no</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>oppgjør</em></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Websystemer</td>
                                        <td>
                                            <ul>
                                                <li>Andreas Wille Aasen</li>
                                                <li>995 23 259</li>
                                                <li><a href="mailto:awa@websystemer.as" target="_blank">awa@websystemer.as</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-meglerverktoy"></span><em>webmegler</em></span>
                                            <span class="schala-status"><span class="m-badge m-badge--dot schala-tag-obligatorisk"></span><em>obligatorisk</em></span>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--end::Section-->
                    </div>
                </div>
                <!--end::Form-->
            </div>
        </div>

    </div>
</div>