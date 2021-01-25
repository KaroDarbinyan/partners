<?php

use common\models\Department;
use common\models\Partner;
use common\models\User;
use dosamigos\tinymce\TinyMce;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
/* @var User $user */

$user = Yii::$app->user->identity;

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
        'id' => 'news-form'
    ]
]);
?>


<?= $form->field($model, 'name')->textInput([
    'placeholder' => 'Name',
    'style' => 'background: #1b1b1a; border: none; border-radius: 10px',
    'maxlength' => true
])->label(false); ?>

<?= $form->field($model, 'type')
    ->dropDownList([
        'nyheter' => 'Nyheter',
        'profilering' => 'Profilering',
        'idedatabase' => 'Idedatabase'
    ])->label('Typen'); ?>

<?= $this->render("fields/_text_field", compact("model", "form")); ?>

<?= $form->field($model, 'show_img')->checkbox([
    'label' => '<span>Vise bilde inne artikkel</span>'
]); ?>

<?= $this->render("fields/_texts_field", compact("model")); ?>

<div class="form-group">
    <?= Html::submitButton('Lagre', ['class' => 'btn btn-success', 'style' => 'margin-top: 20px;border-radius: 7px']) ?>
</div>

<?php ActiveForm::end(); ?>



