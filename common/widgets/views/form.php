<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\CalendarEvent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calendar-form">
    <?php Pjax::begin()?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>
    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'everyDay')->checkbox() ?>


    <?= $form->field($model, 'description')->textInput() ?>

    <?= $form->field($model, 'start')->textInput() ?>

    <?= $form->field($model, 'end')->textInput() ?>

    <div class="form-group text-left">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success ']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end()?>
</div>
