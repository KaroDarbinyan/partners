<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PostNumber */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-number-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'index')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'department_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Lagre', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
