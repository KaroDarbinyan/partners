<?php

use common\models\Department;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'navn')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tittel')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'mobiltelefon')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'urlstandardbilde')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'department_id')->dropDownList(
        ArrayHelper::map(Department::find()->all(), 'web_id', 'navn'),
        ['options' => [$model->department_id => ['selected' => true]]]
    ) ?>
    <?= $form->field($model, 'image')->fileInput()->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
