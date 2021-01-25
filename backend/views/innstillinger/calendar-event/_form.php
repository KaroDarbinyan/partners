<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CalendarEvent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calendar-event-form col-md-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Lagre'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<JS
    $("#calendarevent-classes").select2({
        placeholder: "Select a State",
        allowClear: true
    });
JS;
echo  $this->registerJs($js);
