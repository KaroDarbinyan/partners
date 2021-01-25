<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PropertyImagesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="property-images-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'property_id') ?>

    <?= $form->field($model, 'src') ?>

    <?= $form->field($model, 'alt') ?>

    <?= $form->field($model, 'angle_name') ?>

    <?php // echo $form->field($model, 'type') ?>

    <div class="form-group">
        <?= Html::submitButton('Søk', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Nullstille', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
