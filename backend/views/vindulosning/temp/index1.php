<?php

use backend\assets\AppAsset;
use common\models\Partner;
use common\models\PartnerSettings;
use common\models\PropertyDetails;
use common\models\Sms;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $partners Partner[] */
/* @var $properties PropertyDetails[] */
/* @var $partnerSettings PartnerSettings */
/** @var User $user */

$this->title = 'Vinduløsning';

$this->registerJsFile("@web/js/vindulosning.js", ["depends" => AppAsset::class]);
$this->registerCss('
.nav.nav-tabs {
     border-bottom: 1px solid #1c1c1c;
     margin-bottom: -1px !important;
}

.nav-link {
     color: white !important;
     font-size: 1.5rem !important;
     text-decoration: none !important;
}

.nav-link:hover{
     border-color: transparent !important;
     color: #6c757d!important;
}

.nav-link.active {
     background-color: #2b2b2b !important;
     border-color: #1c1c1c #1c1c1c #2b2b2b !important;
     border-radius: 10px 10px 0 0 !important;
}

.checked {
     opacity: 0.3;
}

.solgt {
    position: absolute;
    width: 60%;
    left: 0;
    right: 0;
    margin: auto;
    top: 60px;
}

.disabled {
    cursor: not-allowed;
    opacity: 0.3;
}

');

?>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Brand</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main_nav">
            <ul class="navbar-nav">
                <li class="nav-item active"><a class="nav-link" href="#">Home </a></li>
                <li class="nav-item"><a class="nav-link" href="#"> About </a></li>
                <li class="nav-item"><a class="nav-link" href="#"> Services </a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link  dropdown-toggle" href="#" data-toggle="dropdown"> More items </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"> Submenu item 1</a></li>
                        <li><a class="dropdown-item" href="#"> Submenu item 2 </a></li>
                        <li><a class="dropdown-item" href="#"> Submenu item 3 </a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="#"> Menu item </a></li>
                <li class="nav-item"><a class="nav-link" href="#"> Menu item </a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link  dropdown-toggle" href="#" data-toggle="dropdown"> Dropdown right </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a class="dropdown-item" href="#"> Submenu item 1</a></li>
                        <li><a class="dropdown-item" href="#"> Submenu item 2 </a></li>
                    </ul>
                </li>
            </ul>
        </div> <!-- navbar-collapse.// -->
    </div><!-- container //  -->
</nav>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div style="clear: both; padding-top: 30px; display: block;"></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head h-auto">
                        <div class="m-portlet__head-caption">
                            <ul class="nav nav-tabs mb-0 mt-4" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-1" data-toggle="tab" href="#tab_1" role="tab"
                                       aria-controls="tab_1" aria-selected="true">Tab 1</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-2" data-toggle="tab" href="#tab_2" role="tab"
                                       aria-controls="tab_2" aria-selected="false">Tab 2</a>
                                </li>
                            </ul>
                        </div>
                        <div class="m-portlet__head-caption float-right">
                            <select class="selectpicker" data-style="tl-select" id="prt-select">
                                <?php foreach ($partners as $partner): ?>
                                    <option <?= $partner->id === Yii::$app->user->identity->partner->id ? "selected" : ""; ?>
                                            value="<?= $partner->id; ?>">
                                        <?= $partner->name; ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="m-portlet__body m--block-center">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tab_1" role="tabpanel" aria-labelledby="tab-1">
                                <div class="row" id="property-visible">
                                    <?= $this->render("visible", compact('properties')); ?>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="tab_2" role="tabpanel" aria-labelledby="tab-2">
                                <div class="row" id="property-template">
                                    <?= $this->render("template", compact('partnerSettings')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<button type="button" id="open-modal" class="btn btn-info btn-lg d-none" data-toggle="modal"
        data-target="#myModal"></button>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #2b2b2b">
            <div class="modal-body">
                <h3 class="text-center text-success">Vellykket sendt</h3>
            </div>
            <div class="modal-footer" style="border-top: none">
                <button type="button" class="btn btn-default m--block-center" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
