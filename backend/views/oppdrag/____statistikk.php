<?php

/* @var $this yii\web\View */

$this->title = 'Statistikk';
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Oppdrag</span>',
    'url' => ['/oppdrag/'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-lg-12">

        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="" style="margin-top: 15px;">
                        <h4 style="color: white;">
                            Not Found
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php return; ?>


<!-- hidden for now  -->
<div class="row">
    <div class="col-lg-12">

        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="" style="margin-top: 15px;">
                        <h4 style="color: white;">
                            Mitt Salg
                        </h4>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <ul class="">
                    <li class="nav-item m-tabs__item ">
                        <a href="/admin/oppdrag/fremdrift" class="nav-link m-tabs__link active">
                            Fremdrift
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a href="/admin/oppdrag/bilder" class="nav-link m-tabs__link">
                            Bilder
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a href="/admin/oppdrag/documenter" class="nav-link m-tabs__link">
                            Dokumenter
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a href="/admin/oppdrag/annonser" class="nav-link m-tabs__link">
                            Annonser
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a href="/admin/oppdrag/meldinger" class="nav-link m-tabs__link">
                            Meldinger
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a href="/admin/oppdrag/markedsforing" class="nav-link m-tabs__link">
                            Unik markedsføring
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>

</div>
