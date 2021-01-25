<?php

$this->title = 'Eiendomsverdi';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__body">
                        <div class="row">
                            <form class="col-md-6 offset-md-3 p-5 mt-5 mb-5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 class="text-center">Eiendomsverdi</h1>
                                        <p class="h2 text-center">Søk opp adrese eller fyll inn martrikkel</p>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-4 mb-3"><input class="ev-api-input" type="number" name="knr"
                                                                 placeholder="knr"></div>
                                    <div class="col-md-4 mb-3"><input class="ev-api-input" type="number" name="gnr"
                                                                 placeholder="gnr"></div>
                                    <div class="col-md-4 mb-3"><input class="ev-api-input" type="number" name="bnr"
                                                                 placeholder="bnr"></div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-2 offset-md-5">
                                        <button class="btn btn-success w-100 btn-lg">Søk</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>