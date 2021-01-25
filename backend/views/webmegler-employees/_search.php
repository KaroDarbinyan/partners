<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WebmeglerEmployeesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webmegler-employees-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id__') ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'avdeling_id') ?>

    <?= $form->field($model, 'navn') ?>

    <?= $form->field($model, 'tittel') ?>


    <?php // echo $form->field($model, 'inaktiv') ?>

    <?php // echo $form->field($model, 'mobiltelefon') ?>

    <?php // echo $form->field($model, 'email') ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
