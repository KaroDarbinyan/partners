<?php

use backend\assets\AppAsset;
use backend\components\UrlExtended;
use common\models\Partner;
use common\models\PropertyDetails;
use common\models\PropertyDetailsAdsSearch;
use common\models\Vindulosning;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this View */
/* @var $dropdown array */
/* @var $properties PropertyDetails[] */
/** @var User $user */
/* @var $dataProvider ActiveDataProvider */
/* @var $searchModel PropertyDetailsAdsSearch */
/* @var $vindulosning Vindulosning */

$this->title = 'Vinduløsning';
$identity = Yii::$app->user->identity;

$this->registerJsFile("@web/js/vindulosning.js", ["depends" => AppAsset::class]);
//$this->registerJsFile("https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js", ["depends" => AppAsset::class]);
$this->registerCss('
.tooltip {
  position: relative;
  display: inline-block;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 140px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -75px;
  opacity: 1;
  transition: opacity 0.3s;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}

#vindulosning-link {
    cursor: pointer
}

button:disabled {
    cursor: not-allowed;
    opacity: 0.2 !important;
    background: white !important;
    border: white !important;
}
.solgt {
    position: absolute;
    width: 10%;
    left: 110px;
    margin-top: 35px;
}

.bootstrap-select .dropdown-toggle .filter-option {
    padding-top: 6px !important;
}

');

?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <div class="m-content">

        <div class="row print-hide">
            <div class="col-lg-12">
                <ul class="nav nav-tabs  m-tabs-line m-tabs-line--2x m-tabs-line--danger" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a href="<?= UrlExtended::toRoute(['vindulosning/index']); ?>"
                           class="nav-link m-tabs__link <?= isset(Yii::$app->view->params['index']) ? Yii::$app->view->params['index'] : ''; ?>">Visible</a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a href="<?= UrlExtended::toRoute(['vindulosning/create']); ?>"
                           class="nav-link m-tabs__link <?= isset(Yii::$app->view->params['create']) ? Yii::$app->view->params['create'] : ''; ?>">Create</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head h-auto">
                        <div class="m-portlet__head-caption pt-4 pb-4">Create</div>
                    </div>
                    <div class="m-portlet__body">

                        <?php $form = ActiveForm::begin(["id" => "vindulosning-form"]); ?>

                        <?= $form->field($vindulosning, "user_id")->hiddenInput(["value" => Yii::$app->user->id])->label(false); ?>

                        <?= $form->field($vindulosning, "property_ids")->hiddenInput()->label(false); ?>

                        <div class="row">
                            <?php if ($dropdown): ?>
                                <div class="col-md-2 col-sm">
                                    <label class="control-label w-100" for="prt-select">Partnere</label>
                                    <?= Html::dropDownList($dropdown["key"], null, $dropdown["items"], [
                                        "class" => "form-control selectpicker",
                                        "id" => "prt-select",
                                        "data-style" => "form-control-sm btn btn-sm btn-light"
                                    ]); ?>
                                </div>
                            <?php endif; ?>
                            <div class="col-md-2 col-sm">
                                <?= $form->field($vindulosning, "view")->dropDownList([
                                    "list" => "List", "carousel" => "Carousel"
                                ], [
                                    "class" => "selectpicker w-100",
                                    "data-style" => "form-control-sm btn btn-sm btn-light"
                                ])->label("View"); ?>
                            </div>

                            <div class="col-md-2 col-sm">
                                <?= $form->field($vindulosning, "column")->dropDownList([
                                    "12" => "1",
                                    "6" => "2",
                                    "4" => "3",
                                    "3" => "4",
                                ], [
                                    "class" => "selectpicker w-100",
                                    "data-style" => "form-control-sm btn btn-sm btn-light"
                                ])->label("Column"); ?>
                            </div>

                            <div class="col-md-2 pt-3">
                                <?= Html::button("Generate url", ["class" => "btn btn-success mt-3 btn-sm", "id" => "link", "disabled" => true]); ?>
                            </div>

                        </div>
                        <?php ActiveForm::end(); ?>

                        <div class="row pt-3 pb-5">
                            <div class="col-md-6 d-none" id="tooltip-container">
                                <div class="tooltip" style="opacity: 1">
                                    <span class="mr-2" id="copy-link"><i class="far fa-copy"></i></span>
                                    <span class="tooltiptext" id="myTooltip">Copy link</span>
                                </div>
                                <a target="_blank" id="vindulosning-link"></a>
                            </div>
                        </div>

                        <div class="row" id="property-template">

                            <?= $this->render("partials/create", compact('dataProvider')); ?>
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


