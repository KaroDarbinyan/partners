<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $model \common\models\Forms */
/* @var $showMessage bool */

?>

<?php $form = ActiveForm::begin([
    'id' => 'valuation-form',
    'fieldConfig' => ['options' => ['tag' => false]],
    'options' => ['class' => 'lead-form contact_form']
]); ?>

<?= $form->field($model, 'type', ['errorOptions' => ['tag' => null]])
    ->hiddenInput(['value' => 'verdivurdering', 'class' => false])
    ->label(false) ?>

<?= $form->field($model, 'department_id', ['errorOptions' => ['tag' => null]])
    ->hiddenInput(['class' => false])
    ->label(false) ?>

<?= $form->field($model, 'broker_id', ['errorOptions' => ['tag' => null]])
    ->hiddenInput(['class' => false])
    ->label(false) ?>

<?= $form->field($model, 'phone')
    ->textInput(['class' => 'styler', 'placeholder' => 'Telefon'])
    ->label(false) ?>

<?= $form->field($model, 'post_number')
    ->textInput(['class' => 'styler', 'placeholder' => 'Postnummer'])
    ->label(false) ?>

<?= $form->field($model, 'name')
    ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'Navn'])
    ->label(false) ?>

<?= $form->field($model, 'email')
    ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'E-post'])
    ->label(false) ?>

<?php if ($showMessage): ?>
    <?= $form->field($model, 'message')
        ->textarea(['rows' => 4, 'class' => 'styler', 'placeholder' => 'Melding'])
        ->label(false) ?>
<?php endif ?>

<?= $form->field($model, 'subscribe_email', [
    'template' => '{input} {label} {error}{hint}'
])
    ->checkbox(['class' => 'input_check'], false)
    ->label('Jeg ønsker å motta eiendomsrelatert informasjon (nyhetsbrev o.l.) på e-post', ['class' => 'label_check'])
?>

<?= $form->field($model, 'i_agree', [
    'template' => '{input} {label} {error}{hint}'
])
    ->checkbox(['class' => 'input_check'], false)
    ->label('Jeg har lest og godkjent <a href="/personvern" target="_blank">vilkårene</a>', ['class' => 'label_check'])
?>

<?= Html::submitButton('SEND', ['class' => 'order mt-4']) ?>

<?php ActiveForm::end(); ?>

