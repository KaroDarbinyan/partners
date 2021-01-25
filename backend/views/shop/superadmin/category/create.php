<?php

use common\models\ShopCategory;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model ShopCategory */
/* @var $initial array */

$this->title = 'Create Category';

?>


<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile">
                    <?= $this->render('/shop/partials/_head', ['title' => $this->title]); ?>
                    <div class="m-portlet__body">
                        <div class="shop-category-create">
                            <?= $this->render('_form', [
                                'model' => $model,
                                'initial' => $initial
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
