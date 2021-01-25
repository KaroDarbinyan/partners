<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AllPostNumberSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="all-post-number-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'post_number') ?>

    <?= $form->field($model, 'city') ?>

    <?= $form->field($model, 'municipal_number') ?>

    <?= $form->field($model, 'municipal_name') ?>

    <?php // echo $form->field($model, 'category') ?>

    <div class="form-group">
        <?= Html::submitButton('Søk', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Nullstille', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
