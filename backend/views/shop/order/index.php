<?php

use backend\components\UrlExtended;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */
/* @var $orders_sum integer */

$this->title = 'Orders History';
?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile">
                    <?= $this->render('/shop/partials/_head', ['title' => $this->title]); ?>
                    <div class="m-portlet__body">
                        <div class="shop-order-index">

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'emptyText' => 'Ingen resultater funnet. ' . Html::a('Go to shop', UrlExtended::to(['shop/index']), ['class' => 'btn btn-sm btn-primary ml-2 font-weight-bold']),
                                'showHeader' => $dataProvider->getModels() ? true : false,
                                'tableOptions' => [
                                    'id' => 'order-table',
                                    'class' => 'table table-striped table-bordered'
                                ],
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\Column',
                                        'header' => '№',
                                        'options' => ['style' => 'width: 10%'],
                                        'content' => function ($model) {
                                            return Html::a(
                                                $model['id'],
                                                UrlExtended::to(['order-view', 'id' => $model['id']]),
                                                ['class' => 'h5']
                                            );

                                        }
                                    ],
                                    [
                                        'header' => 'Dato',
                                        'attribute' => 'date',
                                        'options' => ['style' => 'width: 20%'],
                                        'value' => function ($model) {
                                            return date('d.m.y H:i', $model["date"]);
                                        },
                                    ], [
                                        'header' => 'Comment',
                                        'attribute' => 'comment',
                                        'contentOptions' => ['class' => 'truncate'],
                                        'options' => ['style' => 'width: 50%'],
                                        'value' => function ($model) {
                                            return StringHelper::truncate($model["comment"], 200);
                                        }
                                    ],
                                    [
                                        'header' => 'Sum',
                                        'headerOptions' => ['class' => 'text-right'],
                                        'options' => ['style' => 'width: 20%'],
                                        'contentOptions' => ['class' => 'text-right'],
                                        'value' => function ($model) {
                                            return $model["sum"];
                                        },
                                    ]
                                ]
                            ]); ?>
                            <?php if ($orders_sum > 0): ?>
                                <p class="w-100 text-right pr-2 h4">
                                    <?= $orders_sum; ?>
                                    <span class="h5"> NOK</span>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
