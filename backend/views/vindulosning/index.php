<?php

use backend\assets\AppAsset;
use backend\components\UrlExtended;
use common\models\Partner;
use common\models\PartnerSettings;
use common\models\PropertyDetails;
use common\models\PropertyDetailsAdsSearch;
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

$this->title = 'Vinduløsning';

$this->registerJsFile("@web/js/vindulosning.js", ["depends" => AppAsset::class]);
$this->registerCss('

.solgt {
    position: absolute;
    width: 10%;
    left: 110px;
    margin-top: 35px;
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
                        <div class="m-portlet__head-caption pt-3 pb-3"></div>
                        <div class="m-portlet__head-caption pt-3 pb-3 float-right">
                            <?= Html::a("Create new vindulosning", UrlExtended::toRoute(['vindulosning/create']), ["class" => "btn btn-success"]); ?>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <?php if ($dropdown): ?>
                        <div class="row pt-3 pb-4">
                            <div class="col-md-12">
                                <?= Html::dropDownList($dropdown["key"], null, $dropdown["items"], ["class" => "selectpicker", "id" => "prt-select"]); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="row" id="property-visible">
                            <?= $this->render("partials/index", compact('dataProvider')); ?>
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


