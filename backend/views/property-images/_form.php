<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PropertyImages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="property-images-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'property_id')->textInput() ?>

    <?= $form->field($model, 'src')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'angle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Lagre', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
