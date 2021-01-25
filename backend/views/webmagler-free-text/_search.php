<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WebmaglerFreeTextSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webmagler-free-text-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id__') ?>

    <?= $form->field($model, 'propertyDetailId') ?>

    <?= $form->field($model, 'nr') ?>

    <?= $form->field($model, 'visinettportaler') ?>

    <?= $form->field($model, 'compositeTextId') ?>

    <?php // echo $form->field($model, 'gruppenavn') ?>

    <?php // echo $form->field($model, 'overskrift') ?>

    <?php // echo $form->field($model, 'tekst') ?>

    <?php // echo $form->field($model, 'htmltekst') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
