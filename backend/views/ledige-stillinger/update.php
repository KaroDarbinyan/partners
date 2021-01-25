<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LedigeStillinger */

$this->title = 'Ny stilling';
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Ledige stillinger</span>',
    'url' => ['/ledige-stillinger/'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="ledige-stillinger-create">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="" style="margin-top: 15px;">
                                    <h1>Rediger stillingen</h1>    
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">   
                            <?= $this->render('_form', [
                                'model' => $model,
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
