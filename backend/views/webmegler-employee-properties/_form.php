<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WebmeglerEmployeeProperties */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webmegler-employee-properties-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oppdragsnummer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'markedsforingsklart')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_oppdragstatus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'adresse')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
