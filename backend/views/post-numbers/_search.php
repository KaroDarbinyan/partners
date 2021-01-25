<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PostNumberSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-number-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'index') ?>

    <?= $form->field($model, 'department_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Søk', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Nullstille', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
