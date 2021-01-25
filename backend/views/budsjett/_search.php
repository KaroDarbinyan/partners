<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BudsjettSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="budsjett-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'inntekt') ?>

    <?= $form->field($model, 'snittprovisjon') ?>

    <?= $form->field($model, 'hitrate') ?>

    <?php // echo $form->field($model, 'befaringer') ?>

    <?php // echo $form->field($model, 'salg') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Søk', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Nullstille', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
