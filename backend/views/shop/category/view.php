<?php

use backend\components\UrlExtended;
use common\models\ShopCategory;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ListView;

/* @var $this View */
/* @var $model ShopCategory */
/* @var $dataProvider ActiveDataProvider */

$this->title = $model->name;
$update = Html::a('Update Category',
    UrlExtended::to(['category-update', 'id' => $model->id]),
    ['class' => 'btn btn-sm btn-primary mr-1 font-weight-bold']);
$delete = Html::a('Delete Category',
    UrlExtended::to(['category-delete', 'id' => $model->id]),
    ['class' => 'btn btn-sm btn-danger ml-1 font-weight-bold',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ]);

$actions = "<p class='w-100'>{$update} {$delete}</p>";

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
                        <div class="shop-category-view">
                            <?php if (Yii::$app->user->identity->hasRole("superadmin")): ?>
                                <p class="w-100">
                                    <?= Html::a('Create Product', UrlExtended::to(['product-create', 'categoryId' => $model->id]),
                                        ['class' => 'btn btn-sm btn-primary font-weight-bold']); ?>
                                </p>
                            <?php endif; ?>
                            <?= ListView::widget([
                                'dataProvider' => $dataProvider,
                                'itemView' => '_product_list',
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