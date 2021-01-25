<?php

use common\models\Forms;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\web\JqueryAsset;

/* @var $model Forms */
/* @var $showMessage bool */


?>

<?php $form = ActiveForm::begin([
    'id' => 'valuation-form',
    'fieldConfig' => ['options' => ['tag' => false]],
    'options' => ['class' => 'lead-form contact_form']
]); ?>

<?= $form->field($model, 'type', ['errorOptions' => ['tag' => null]])
    ->hiddenInput(['value' => 'meglerbooking', 'class' => false])
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

<?= $form->field($model, 'name')
    ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'Navn'])
    ->label(false) ?>

<?= $form->field($model, 'post_number')
    ->textInput(['class' => 'styler', 'placeholder' => 'Postnummer'])
    ->label(false) ?>


<?= $form->field($model, 'address')
    ->textInput(['class' => 'styler', 'placeholder' => 'Adresse'])
    ->label(false) ?>


<?= $form->field($model, 'email')
    ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'E-post'])
    ->label(false) ?>


<?= $form->field($model, 'megler_booking_date')
    ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'Velg dato og tid', 'readonly' => 'readonly'])
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

<?php

$js = <<<JS
  $(function () {
        let booking_date_field = $('#forms-megler_booking_date');
        let booking_date = booking_date_field.datetimepicker({
            language: "no",
            autoclose: true,
            format: 'dd.mm.yyyy kl. hh:ii',
            minView: true,
            startDate: '-0d',
            // daysOfWeekDisabled: '6',
            hoursDisabled: '0,1,2,3,4,5,6,7,22,23,24',
            onRenderHour: function () {
                setTimeout(function () {
                    let hour = $(".datetimepicker-hours tbody tr td");
                    hour.find("span.disabled").remove();
                }, 0);
            }
        }).on("changeDate", function (ev) {
            let date = ev.date;
            date.setMinutes(0);
            booking_date.data("datetimepicker").setDate(date);
        });
   });
JS;

$this->registerJsFile("@web/js/bootstrap-datetimepicker.js", ['depends' => JqueryAsset::class]);
$this->registerJs($js); ?>