<?php

use backend\components\UrlExtended;
use common\components\ShopHelper;
use common\models\ShopCategory;
use common\models\ShopProduct;
use yii\bootstrap\Html;
use yii\helpers\StringHelper;

/* @var $this View */
/* @var $model ShopCategory */

?>

<div class="product-card">
    <?php if (Yii::$app->user->identity->hasRole("superadmin")): ?>
        <div class="card-actions">
            <?= Html::a('<i class="fas fa-eye"></i>', UrlExtended::to(['category-view', 'id' => $model->id]), ['title' => 'View']); ?>
            <?= Html::a('<i class="fas fa-edit"></i>', UrlExtended::to(['category-update', 'id' => $model->id]), ['class' => 'mr-2 ml-2', 'title' => 'Rediger']); ?>
            <?= Html::a('<i class="fas fa-trash"></i>', UrlExtended::to(['category-delete', 'id' => $model->id]), [
                'title' => Yii::t('app', 'Fjern'),
                'data-confirm' => Yii::t('app', 'Er du sikker at du vil fjerne category?'),
                'data-method' => 'post']); ?>
        </div>
    <?php endif; ?>
    <div class="card">
        <a href="<?= UrlExtended::to(['category-view', 'id' => $model->id]); ?>">
            <img class="card-img-top"
                 src="<?= ShopHelper::categoryImage($model); ?>"
                 alt="Card image cap">
        </a>
        <div class="card-body">
            <h5 class="card-title"><?= $model->name; ?></h5>
            <p class="card-text"><?= StringHelper::truncate($model->description, 20); ?></p>
        </div>
    </div>
</div>