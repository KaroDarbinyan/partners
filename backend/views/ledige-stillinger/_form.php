<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LedigeStillinger */
/* @var $form yii\widgets\ActiveForm */
$departments = \common\models\Department::find()->indexBy('id')->select('short_name')->column();
?>

<div class="ledige-stillinger-form col-md-8">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kontor')->dropDownList($departments,  ['prompt' => 'Velg kontor']) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'status')->checkbox([ 'label' => 'aktiv / inaktiv']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Lagre'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$this->registerJs(
        <<<JS
            $(function () {
                if ( $('#ledigestillinger-date').length) {
                    $('#ledigestillinger-date').datepicker({
                        // format: 'LT'
                    });
                } 
            });
JS
        , \yii\web\View::POS_END
);
