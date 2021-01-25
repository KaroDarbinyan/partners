<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = 'Rediger nyheter';
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Intranett</span>',
    'url' => [\backend\components\UrlExtended::toRoute(["/intranett/$model->type"])],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div style="clear: both; padding-top: 30px; display: block;"></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="" style="margin-top: 15px;">
                                <h1><?= Html::encode($this->title) ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body m--block-center">

                        <?= $this->render("_" . Yii::$app->user->identity->role . "_form", [
                            'model' => $model,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

