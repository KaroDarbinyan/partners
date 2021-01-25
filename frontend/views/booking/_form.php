<?php

use common\models\Forms;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\web\JqueryAsset;

/* @var $model Forms */
/* @var $showMessage bool */


?>

<?php $form = ActiveForm::begin([
    'id' => 'valuation-form',
    'fieldConfig' => ['options' => ['tag' => false]],
    'options' => [
        'class' => 'lead-form contact_form',
    ]
]); ?>
<div class="row">
    <div class="col-md-6 pl-5 pr-5">
        <?= DateTimePicker::widget([
            'model' => $model,
            'language' => 'no',
            'attribute' => 'megler_booking_date',
            'name' => 'dp_4',
            'type' => DateTimePicker::TYPE_INLINE,
            'options' => ['placeholder' => 'Velg dato og tid'],
            'pluginOptions' => [
                'format' => 'dd.mm.yyyy kl. hh:ii',
                'language' => 'no',
                'minuteStep' => 30,
                'startDate' => '-0d',
                'weekStart' => 1,
            ],
            'pluginEvents' => [
                "changeDay" => 'function (event) {
                        let datetimepicker = $(this).data("datetimepicker");
                        let date = new Date(event.date);
                        
                        let hoursDisabled = [6, 0].includes(event.date.getDay())
                        ? [0,1,2,3,4,5,6,7,8,9,10,11,17,18,19,20,21,22,23]   // пн-пт kl. 08:00-20:00.
                        : [0,1,2,3,4,5,6,7,20,21,22,23,24]; // 12:00-17:00.  //сб-вс: kl. 12:00-17:00.
                                                                        
                        let current_date = new Date();
                        current_date = current_date.getUTCMonth() + "/" + current_date.getUTCDate() + "/" + current_date.getUTCFullYear();
                        let select_date = event.date.getUTCMonth() + "/" + event.date.getUTCDate() + "/" + event.date.getUTCFullYear();
                                                
                        if (current_date === select_date) {
                            for(let i = 0; i < event.date.getUTCDate(); i++) {
                                hoursDisabled.push(i);
                            }
                        }

                        datetimepicker.setHoursDisabled(hoursDisabled);
                        date.setHours(datetimepicker.initialDate.getHours());
                        date.setMinutes(0);
                        datetimepicker.setDate(date);
                        setTimeout(function () {
                            $(".datetimepicker-hours tbody tr td span.disabled").remove();
                        },0);
                    }',
                "changeHour" => 'function () {
                       let datetimepicker = $(this).data("datetimepicker");
                       let date = new Date(datetimepicker.viewDate);
                       date.setMinutes(0);
                       datetimepicker.setUTCDate(date);
                    }',
            ],
        ]); ?>

    </div>
    <div class="col-md-6 pl-5 pr-5">

        <?= $form->field($model, 'phone')
            ->textInput(['class' => 'styler', 'placeholder' => 'Telefon'])
            ->label(false) ?>

        <?= $form->field($model, 'name')
            ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'Navn'])
            ->label(false) ?>

        <?= $form->field($model, 'post_number')
            ->textInput(['class' => 'styler', 'placeholder' => 'Postnummer'])
            ->label(false) ?>

        <?= $form->field($model, 'email')
            ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'E-post'])
            ->label(false) ?>

        <?= $form->field($model, 'type', ['errorOptions' => ['tag' => null]])
            ->hiddenInput(['value' => 'meglerbooking', 'class' => false])
            ->label(false) ?>

        <?= $form->field($model, 'department_id', ['errorOptions' => ['tag' => null]])
            ->hiddenInput(['class' => false])
            ->label(false) ?>

        <?= $form->field($model, 'broker_id', ['errorOptions' => ['tag' => null]])
            ->hiddenInput(['class' => false])
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
        <?= Html::submitButton('SEND', ['class' => 'order mt-4 w-50']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php

$js = <<<JS
    $(function () {
        $('#forms-megler_booking_date').after('<p class="help-block help-block-error booking_date"></p>')
        $('.datetimepicker.datetimepicker-inline')
            .after($('<button>', {
                text: 'Velg annen dato',
                class: 'order mt-1 w-100 font-weight-bold',
                click: function (e) {
                    e.preventDefault();
                    $("th.today").click();
                    $("th.clear").click();
                },
            }));
    });
JS;

$this->registerJs($js); ?>

<style>

    header {
        background-position-x: left !important;
    }

    form {
        border-radius: 0 !important;
        max-width: 100% !important;
        background-color: rgba(35, 31, 32, .69) !important;
    }

    form input[type=text]:not([readonly]) {
        border: none !important;
        border-bottom: 1px solid white !important;
        border-radius: 0 !important;
        background: transparent !important;
        padding-left: 5px !important;
        text-transform: uppercase;
        font-size: 15px;
        padding-bottom: 6px;
    }


    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
        -webkit-text-fill-color: white !important;
        transition: background-color 5500s ease-in-out 0s;
    }


    form label.label_check:before {
        background: white !important;
        border-radius: 0;
        width: 17px;
        height: 17px;
    }

    form label, form label a {
        font-weight: unset !important;
    }

    form label.label_check:after {
        border-right: 2px solid black;
        border-bottom: 2px solid black;
        width: 7px;
        height: 10px;
    }

    form .datetimepicker {
        font-size: 15px !important;
        font-weight: bold;
        background: transparent;
        color: white;
        border: none;
        text-transform: uppercase;
    }

    .datetimepicker thead tr:first-child th:hover, .datetimepicker tfoot th:hover {
        background: transparent !important;
    }

    .datetimepicker span.hour.active, .datetimepicker td.day.active, .datetimepicker span.minute.active {
        background: black !important;
    }

    .datetimepicker span.hour:hover, .datetimepicker td.day:hover, .datetimepicker span.minute:hover {
        background: black !important;
    }

    .datetimepicker span.hour.disabled:hover, .datetimepicker td.day.disabled:hover, .datetimepicker span.minute.disabled:hover {
        background: transparent !important;
    }

    .datetimepicker .datetimepicker-hours span.hour, .datetimepicker .datetimepicker-minutes span.minute {
        font-weight: 500 !important;
        font-family: 'FuturaPT-Light', sans-serif !important;
    }


    .datetimepicker span.glyphicon-arrow-left, .datetimepicker span.glyphicon-arrow-right {
        font-size: 12px !important;
    }


    #forms-megler_booking_date, #forms-megler_booking_date-datetime button {
        background: white !important;
        color: black !important;
        border-radius: 0 !important;
        border: 0 !important;
        outline: none !important;
        height: 35px;
        font-size: 20px;
        text-transform: uppercase;
        font-weight: 500 !important;
    }

    #forms-megler_booking_date-datetime button:hover {
        background: white !important;
        color: black;
    }

    #forms-megler_booking_date::placeholder {
        color: black !important;
        text-transform: uppercase;
    }
</style>
