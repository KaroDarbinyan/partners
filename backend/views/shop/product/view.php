<?php

use backend\components\UrlExtended;
use common\components\ShopHelper;
use common\components\StaticMethods;
use common\models\ShopProduct;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model ShopProduct */

$this->title = $model->name;

$category = $model->category;

$this->params['shop_breadcrumbs'][] = '<span class="ml-1 mr-1">/</span>';

$this->params['shop_breadcrumbs'][] = [
    'label' => "<span class='m-nav__link-text'>{$category->name}</span>",
    'url' => UrlExtended::to(['category-view', 'id' => $category->id]),
    'class' => 'm-nav__link',
];

$this->title = $model->name;

$update = Html::a('Update Product',
    UrlExtended::to(['product-update', 'id' => $model->id]),
    ['class' => 'btn btn-sm btn-primary mr-1 font-weight-bold']);

$delete = Html::a('Delete Product',
    UrlExtended::to(['product-delete', 'id' => $model->id]),
    ['class' => 'btn btn-sm btn-danger ml-1 font-weight-bold',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]);

$actions = Yii::$app->user->identity->hasRole("superadmin") ? "<p class='w-100'>{$update} {$delete}</p>" : false;

?>


<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile">
                    <?= $this->render('/shop/partials/_head', [
                        'title' => $this->title,
                        'actions' => $actions
                    ]); ?>
                    <div class="m-portlet__body">
                        <div class="shop-product-view row">
                            <div class="col-md-7">
                                <div id="gallery" class="d-none">
                                    <?php $productImages = ShopHelper::productImages($model);
                                    $imagesCount = count($productImages);
                                    foreach ($productImages as $key => $image): ?>
                                        <img data-image-number="<?= $image->main; ?>"
                                             src="<?= $image->name; ?>"
                                             alt="<?= $image->name ?>"
                                             data-image="<?= $image->name; ?>"
                                             data-description="<strong><?= $key + 1 ?> av <?= $imagesCount ?></strong>">
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="col-md-5">

                                <div class="row">
                                    <div class="col-md-12">
                                        <?= DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                'id',
                                                [                                                  // the owner name of the model
                                                    'label' => 'Category',
                                                    'value' => $model->category->name,
                                                    'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                                                    'captionOptions' => ['tooltip' => 'Tooltip'],  // HTML attributes to customize label tag
                                                ],
                                                'name',
                                                [
                                                    'attribute' => 'price',
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return Html::tag(
                                                                "span",
                                                                StaticMethods::number_format($model->price), [
                                                                "class" => "h6 single-product-price",
                                                                "data" => [
                                                                    "id" => $model->id,
                                                                    "price" => $model->price
                                                                ]
                                                            ]) . Html::tag("span", " NOK", ["class" => "h6"]);
                                                    },
                                                ], [
                                                    'attribute' => 'created_at',
                                                    'value' => function ($model) {
                                                        return date('d.m.y H:i', $model->created_at);
                                                    },
                                                ],
                                            ]
                                        ]); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php if ($model->active == 1): ?>
                                        <div class="col-4 col-md-3 d-flex pt-1">
                                        <span class="minus" data-change="down" data-id="<?= $model->id; ?>">
                                            <i class="fas fa-minus border border-right-0 rounded-left p-1"></i>
                                        </span>
                                            <input type="number" data-id="<?= $model->id; ?>"
                                                   class="form-control form-control-sm border text-center prodCount"
                                                   value="1">
                                            <span class="plus" data-change="up" data-id="<?= $model->id; ?>">
                                            <i class="fas fa-plus border border-left-0 rounded-right p-1"></i>
                                        </span>
                                        </div>
                                        <div class="col-8 col-md-9">
                                            <a data-buy-id="<?= $model->id; ?>" href="javascript:;"
                                               class="btn btn-outline-primary btn-sm w-100 font-weight-bold">Kjøpe
                                                <i class="ml-2 fas fa-shopping-cart"></i></a>
                                        </div>
                                        <div class="kjope_modal"></div>
                                    <?php else: ?>
                                        <div class="col-md-12">
                                            <button class="btn btn-outline-primary btn-sm float-right font-weight-bold"
                                                    disabled>Ikke tilgjengelig
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                Description:<br>
                                <?= $model->description; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

