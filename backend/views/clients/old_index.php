<?php

/* @var $this yii\web\View */
/** @var ActiveDataProvider $dataProvider */
/** @var \common\models\FormsSearch $searchModel */
/** @var  string|null $title  */
/** @var yii\data\Sort $sort */

use backend\assets\AppAsset;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\base\view;
$this->title = $title;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="m-grid__item m-grid__item--fluid m-wrapper" >
    <div class="m-content">
        <!-- _mSubheader -->
        <?= $this->render('_mSubheader' ); ?>
        <!-- _collapseFilter -->
        <?= $this->render('_collapseFilter' ); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__body">
                        <!-- _listView -->
                        <?= $this->render('_listView', compact('dataProvider','sort') ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
