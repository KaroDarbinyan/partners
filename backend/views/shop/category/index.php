<?php

use backend\components\UrlExtended;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ListView;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Categories';


?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile">
                    <?= $this->render('/shop/partials/_head', ['title' => $this->title]); ?>
                    <div class="m-portlet__body">
                        <div class="shop-product-index">
                            <?php if (Yii::$app->user->identity->hasRole("superadmin")): ?>
                                <p class="w-100">
                                    <?= Html::a('Create Category', UrlExtended::to(['category-create']), ['class' => 'btn btn-sm btn-primary font-weight-bold']); ?>
                                </p>
                            <?php endif; ?>
                            <?= ListView::widget([
                                'dataProvider' => $dataProvider,
                                'itemView' => '_category_list',
                                'options' => [
                                    'tag' => 'div',
                                    'class' => 'row',
                                    'id' => 'news-list',
                                ],
                                'summaryOptions' => [
                                    'tag' => 'div',
                                    'class' => 'summary col-md-12'
                                ],
                                'itemOptions' => [
                                    'tag' => 'div',
                                    'class' => 'col-md-4 p-3',
                                ]
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>