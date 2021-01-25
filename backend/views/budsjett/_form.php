<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Budsjett */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="budsjett-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'inntekt')->textInput() ?>

    <?= $form->field($model, 'snittprovisjon')->textInput() ?>

    <?= $form->field($model, 'hitrate')->textInput() ?>

    <?= $form->field($model, 'befaringer')->textInput() ?>

    <?= $form->field($model, 'salg')->textInput() ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Lagre', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
