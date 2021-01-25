<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PropertySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="property-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'web_id') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'price') ?>

    <?= $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 's_meters') ?>

    <?php // echo $form->field($model, 'employee_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Søk', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Nullstille', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
