<?php

use backend\components\UrlExtended;
use common\components\ShopHelper;
use common\components\StaticMethods;
use common\models\ShopProduct;
use yii\bootstrap\Html;
use yii\helpers\StringHelper;

/* @var $this View */
/* @var $model ShopProduct */

?>

<div class="product-card">
    <?php if (Yii::$app->user->identity->hasRole("superadmin")): ?>
        <div class="card-actions">
            <?= Html::a('<i class="fas fa-eye"></i>', UrlExtended::to(['product-view', 'id' => $model->id]), ['title' => 'View']); ?>
            <?= Html::a('<i class="fas fa-edit"></i>', UrlExtended::to(['product-update', 'id' => $model->id]), ['class' => 'mr-2 ml-2', 'title' => 'Rediger']); ?>
            <?= Html::a('<i class="fas fa-trash"></i>', UrlExtended::to(['product-delete', 'id' => $model->id]), [
                'title' => Yii::t('app', 'Fjern'),
                'data-confirm' => Yii::t('app', 'Er du sikker at du vil fjerne category?'),
                'data-method' => 'post']); ?>
        </div>
    <?php endif; ?>
    <div class="card">
        <a href="<?= UrlExtended::to(['product-view', 'id' => $model->id]); ?>">
            <img class="card-img-top"
                 src="<?= ShopHelper::productImage($model); ?>"
                 alt="Card image cap">
        </a>
        <div class="card-body">
            <h5 class="card-title"><?= $model->name; ?></h5>
            <p class="card-text"><?= StringHelper::truncate($model->description, 20); ?></p>
            <div class="row">
                <div class="col-md-4 pt-2 font-weight-bold text-danger">
                    <span class="h5 single-product-price" data-id="<?= $model->id; ?>"
                          data-price="<?= $model->price; ?>"><?= StaticMethods::number_format($model->price); ?></span>
                    <span class="h6"> NOK</span>
                </div>
                <?php if ($model->active == 1): ?>
                    <div class="col-md-4 d-flex pt-1">
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
                    <div class="col-md-4">
                        <a data-buy-id="<?= $model->id; ?>" href="javascript:;"
                           class="btn btn-outline-primary btn-sm float-right font-weight-bold">Kjøpe
                            <i class="ml-2 fas fa-shopping-cart"></i>
                        </a>
                    </div>
                    <div class="kjope_modal"></div>
                <?php else: ?>
                    <div class="col-md-8">
                        <button class="btn btn-outline-primary btn-sm float-right font-weight-bold" disabled>Ikke tilgjengelig</button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>