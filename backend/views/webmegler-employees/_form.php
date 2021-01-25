<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WebmeglerEmployees */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webmegler-employees-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'avdeling_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'navn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tittel')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'inaktiv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobiltelefon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
