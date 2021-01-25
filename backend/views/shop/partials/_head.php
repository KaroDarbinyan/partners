<?php

use backend\components\UrlExtended;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;

/* @var $this View */
/* @var $title string */
/* @var $actions string */

$basket_count = Yii::$app->view->params['basket-count'];

$this->params['shop_breadcrumbs'][] = "<span class='ml-1 mr-1'> / </span>{$this->title}";

?>

<div class="m-portlet__head">
    <div class="m-portlet__head-caption">
        <div>
            <?= Breadcrumbs::widget([
                'homeLink' => [
                    'label' => '<span class="m-nav__link-text">Shop</span>',
                    'url' => UrlExtended::to(['shop/index']),
                    'class' => 'm-nav__link',
                ],
                'links' => isset($this->params['shop_breadcrumbs']) ? $this->params['shop_breadcrumbs'] : [],
                'itemTemplate' => '<li class="m-nav__item">{link}</li>',
                'activeItemTemplate' => '<li class="m-nav__item" style="color: #898b96">{link}</li>',
                'encodeLabels' => false,
                'options' => [
                    'class' => 'm-subheader__breadcrumbs m-nav m-nav--inline',
                ],
            ]); ?>
        </div>
    </div>
    <div class="m-portlet__head-caption">
        <?php if (Yii::$app->user->identity->hasRole("superadmin") && isset($actions)): ?>
            <div class="mt-3 mr-4"><?= $actions; ?></div>
        <?php endif; ?>
        <div class="shop-cart">
            <a href="<?= UrlExtended::to(['order-history']); ?>"><i class="fas fa-history"></i></a>
            <a href="<?= UrlExtended::to(['basket']); ?>">
                <span <?= $basket_count > 0 ? '' : 'class="d-none"'; ?>
                        id="basketListCountCont" data-count="<?= $basket_count; ?>">
                    <?= $basket_count; ?>
                </span>
                <i class="fas fa-shopping-cart"></i></a>
        </div>
    </div>
</div>
