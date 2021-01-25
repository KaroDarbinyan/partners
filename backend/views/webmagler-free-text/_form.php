<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WebmaglerFreeText */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webmagler-free-text-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'propertyDetailId')->textInput() ?>

    <?= $form->field($model, 'nr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visinettportaler')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'compositeTextId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gruppenavn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'overskrift')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tekst')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'htmltekst')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
