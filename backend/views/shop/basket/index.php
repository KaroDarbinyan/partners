<?php

use backend\components\UrlExtended;
use common\components\ShopHelper;
use common\components\StaticMethods;
use common\models\ShopOrder;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */
/* @var $order ShopOrder */

$this->title = 'Basket';
$general_sum = 0;

foreach ($dataProvider->getModels() as $basket) {
    $general_sum += $basket->product->price * $basket->count;
}


?>


<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile">
                    <?= $this->render('/shop/partials/_head', ['title' => $this->title]); ?>
                    <div class="m-portlet__body">
                        <div class="shop-basket-index">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'emptyText' => 'Ingen resultater funnet. ' . Html::a('Go to shop', UrlExtended::to(['shop/index']), ['class' => 'btn btn-sm btn-primary ml-2']),
                                'showHeader' => false,
                                'tableOptions' => [
                                    'id' => 'basket-table',
                                    'class' => 'table table-striped table-bordered'
                                ],
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\Column',
                                        'options' => [
                                            'style' => 'width: 20%'
                                        ],
                                        'content' => function ($model) {

                                            return Html::img(
                                                ShopHelper::productImage($model->product),
                                                ['class' => 'w-50']
                                            );

                                        }
                                    ], [
                                        'class' => 'yii\grid\Column',
                                        'options' => [
                                            'style' => 'width: 20%'
                                        ],
                                        'content' => function ($model) {
                                            return Html::a(
                                                $model->product->name,
                                                UrlExtended::to(['product-view', 'id' => $model->product->id]),
                                                ['class' => 'h4', 'target' => '_blank']
                                            );

                                        }
                                    ], [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{minus}{product-count}{plus}',
                                        'buttons' => [
                                            'minus' => function ($url, $model) {
                                                return Html::tag('span',
                                                    '<i class="fas fa-minus border rounded-circle p-2"></i>',
                                                    ['class' => 'minus', 'data-id' => $model->id]);
                                            },
                                            'product-count' => function ($url, $model) {
                                                return Html::tag('span',
                                                    $model->count,
                                                    ['class' => 'mr-4 ml-4 h3 product-count', 'data-id' => $model->id, 'data-count' => $model->count]);
                                            },
                                            'plus' => function ($url, $model) {
                                                return Html::tag('span',
                                                    '<i class="fas fa-plus border rounded-circle p-2"></i>',
                                                    ['class' => 'plus', 'data-id' => $model->id]);
                                            }
                                        ]
                                    ],
                                    [
                                        'class' => 'yii\grid\Column',
                                        'options' => [
                                            'style' => 'width: 20%; height: 50px'
                                        ],
                                        'content' => function ($model) {
                                            $price_sum = $model->product->price ? $model->product->price * $model->count : 0;
                                            return Html::tag('span',
                                                    StaticMethods::number_format($price_sum),
                                                    [
                                                        'class' => 'h4 product-price-sum',
                                                        'data-id' => $model->id,
                                                        'data-price' => $model->product->price ?? 0,
                                                        'data-price-sum' => $price_sum
                                                    ]) . '<b class="h5"> NOK</b>';
                                        }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{basket-delete}',
                                        'options' => [
                                            'style' => 'width: 1%'
                                        ],
                                        'buttons' => [
                                            'basket-delete' => function ($url, $model) {
                                                return Html::a('<i class="fas fa-trash"></i>', '#', [
                                                    'data-href' => $url,
                                                    'data-id' => $model->id,
                                                    'title' => Yii::t('app', 'Fjern'),
                                                ]);
                                            }
                                        ]
                                    ],
                                ],
                            ]); ?>
                            <div class="row <?= $general_sum > 0 ? "" : "d-none"; ?>">
                                <div class="col-md-12">
                                    <p class="float-right mt-4 text-primary h3" id="basket-general-sum">
                                        <span>Generell</span>
                                        <span id="general-sum">
                                            <?= StaticMethods::number_format($general_sum); ?>
                                        </span>
                                        <span> NOK</span>
                                    </p>
                                    <?php $form = ActiveForm::begin([
                                        'action' => UrlExtended::to(['order-create']),
                                        'id' => 'shopOnlineBaskForm'
                                    ]); ?>

                                    <?= $form->field($order, "index")->hiddenInput(['value' => uniqid()])->label(false); ?>
                                    <?= $form->field($order, "comment")->textarea(['placeholder' => 'Comment', 'rows' => 8])->label(false); ?>
                                    <?= Html::submitButton("Kjøpe", ['class' => 'btn btn-outline-primary font-weight-bold']); ?>
                                    <?php ActiveForm::end() ?>
                                    <?php foreach ($dataProvider->getModels() as $model): ?>
                                        <?= Html::hiddenInput("count[{$model->product->id}]", $model->count, [
                                            'data-basket-id' => $model->id,
                                            'data-id' => $model->product->id,
                                            'data-sum' => $model->product->price * $model->count
                                        ]); ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="shop-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #2b2b2b">
            <div class="modal-body">
                <h3 class="text-center text-success" id="shop-modal-title"></h3>
                <p class="text-center h4 pt-4" id="shop-modal-body"></p>
            </div>
            <div class="modal-footer" style="border-top: none">
                <button type="button" class="btn btn-default m--block-center" data-dismiss="modal">Lukke</button>
            </div>
        </div>
    </div>
</div>

