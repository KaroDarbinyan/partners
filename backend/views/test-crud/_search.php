<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FormsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="forms-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'surname') ?>

    <?= $form->field($model, 'delegated') ?>

    <?= $form->field($model, 'post_number') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'message') ?>

    <?php // echo $form->field($model, 'subscribe_email') ?>

    <?php // echo $form->field($model, 'contact_me') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'target_id') ?>

    <?php // echo $form->field($model, 'send_sms') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
