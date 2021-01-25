<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AllPostNumber */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="all-post-number-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'post_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'municipal_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'municipal_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Lagre', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
