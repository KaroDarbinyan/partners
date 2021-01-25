<?php

use backend\components\UrlExtended;
use common\components\ShopHelper;
use common\components\StaticMethods;
use common\models\ShopOrder;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */
/* @var $shopOrder ShopOrder */
/* @var $orders_sum integer */

$this->title = "Order № {$shopOrder->id}";
$this->params['shop_breadcrumbs'][] = '<span class="ml-1 mr-1">/</span>';
$this->params['shop_breadcrumbs'][] = [
    'label' => "<span class='m-nav__link-text'>Order History</span>",
    'url' => UrlExtended::to(['order-history']),
    'class' => 'm-nav__link',
];
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
                                        'header' => 'Product <br> image',
                                        'class' => 'yii\grid\Column',
                                        'options' => [
                                            'style' => 'width: 20%'
                                        ],
                                        'content' => function ($model) {
                                            return Html::img(
                                                ShopHelper::productImage($model["model"]),
                                                ['class' => 'w-50']
                                            );

                                        }
                                    ],
                                    [
                                        'header' => 'Navn',
                                        'class' => 'yii\grid\Column',
                                        'content' => function ($model) {
                                            return $model["model"]->active ? Html::a(
                                                $model["model"]->name,
                                                ['product-view', 'id' => $model["model"]->id],
                                                ['class' => 'h4']
                                            ) : Html::tag('span', $model["model"]->name, [
                                                'class' => 'h4',
                                                "data" => [
                                                    "html" => "true",
                                                    'category-link' => UrlExtended::to(["category", "id" => $model["model"]->category_id]),
                                                    "toggle" => "popover",
                                                    "content" => "<p class='text-center text-white h4'>Varer selges ikke lenger</p>" . Html::a("Gå til seksjonen med lignende produkter ?", UrlExtended::to(["category-view", "id" => $model["model"]->category_id])),
                                                    "trigger" => "hover",
                                                    "placement" => "top",
                                                    "delay" => ["show" => 500, "hide" => 1000]
                                                ]
                                            ]);
                                        }
                                    ],
                                    [
                                        'header' => 'Category',
                                        'content' => function ($model) {
                                            return $model["model"]->category->name;
                                        }
                                    ],
                                    [
                                        'header' => 'Price',
                                        'content' => function ($model) {
                                            return StaticMethods::number_format($model["model"]->price) . ' NOK';
                                        }
                                    ],
                                    [
                                        'header' => 'Count',
                                        'content' => function ($model) {
                                            return $model["count"];
                                        }
                                    ],
                                    [
                                        'header' => 'Sum',
                                        'class' => 'yii\grid\Column',
                                        'options' => [
                                            'style' => 'text-align: right !important'
                                        ],
                                        'headerOptions' => ['class' => 'text-right'],
                                        'contentOptions' => ['class' => 'text-right'],
                                        'content' => function ($model) {
                                            return $model["sum"];
                                        }
                                    ]
                                ]
                            ]); ?>
                            <?php if ($orders_sum > 0): ?>
                                <p class="w-100 text-right pr-2 h4">
                                    <?= $orders_sum; ?>
                                    <span class="h5"> NOK</span>
                                </p>
                                <?php if ($shopOrder->comment): ?>
                                    <span class="mt-4 h4">Comment:</span>
                                    <p class="w-100 mt-2"><?= $shopOrder->comment; ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
