<?php

use common\models\Forms;
use common\models\Sms;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Sms */
/* @var $lead Forms */


/** @var User $user */
$user = Yii::$app->user->identity;
$partner = $user->partner;

$model = new Sms();
$delegatedUser = isset($lead->delegatedUser) ? $lead->delegatedUser : false;

$this->registerCss('
.btn.dropdown-toggle.btn-light, .form-control {
     background: #1b1b1a;
     border: 1px solid #1b1b1a; 
     border-radius: 10px!important
}

button.btn.dropdown-toggle.btn-light {
     color: #9699a2;
     font-weight: bold;
}

.close {
    position: absolute;
    right: 10px;
    top: 5px;
    font-size: 30px;
    color: red;
    box-shadow: unset;
    opacity: 1;
}

');

?>

<div id="send_sms" class="modal fade" role="dialog">
    <div class="modal-dialog mw-800px pl-5 pr-5">
        <div class="m-grid__item m-grid__item--fluid m-wrapper modal-content bg-dark">
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress- bg-dark">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="" style="margin-top: 15px;">
                                    <h4 class="text-white">Send Sms</h4>
                                    <button type="button" class="close float-right" data-dismiss="modal"
                                            aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body m--block-center">
                            <?php $form = ActiveForm::begin([
                                'id' => 'send-sms-form',
                                'method' => 'post',
                                'action' => '/admin/send-sms',
                                'options' => [
                                    'data-lead_id' => $lead->id
                                ]
                            ]); ?>

                            <?= $form->field($model, 'message')->textarea([
                                'rows' => '10',
                                'placeholder' => 'Message',
                            ])->label(false); ?>

                            <?php if ($lead->phone || $lead->phone !== ""): ?>
                                <?= $form->field($model, 'phone')->hiddenInput(["value" => $lead->phone])->label(false); ?>
                            <?php else: ?>
                                <?= $form->field($model, 'phone')->textInput()->label(false); ?>
                            <?php endif; ?>

                            <?php if ($delegatedUser): ?>
                                <?= $form->field($model, 'from')->hiddenInput(["value" => $delegatedUser->mobiltelefon])->label(false); ?>
                            <?php else: ?>
                                <?= $form->field($model, 'from')->dropDownList([
                                    "PARTNERS" => "Send som {$partner->name}",
                                    $user->mobiltelefon => "Send som {$user->short_name}"
                                ], [
                                    "value" => $user->mobiltelefon,
                                    'class' => 'form-control selectpicker',
                                ])->label(false); ?>
                            <?php endif; ?>

                            <div class="form-group">
                                <?= Html::submitButton('Send', ['class' => 'btn btn-success w-25', 'style' => 'margin-top: 20px;border-radius: 7px']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$text = 'Hei ' . $lead->name . '.\n\n\nMed vennlig hilsen\n' . $user->short_name . '\nwww.partners.no';

$this->registerJs("
    $(function (){
        let focused = true;
        let message = $('#send-sms-form textarea#sms-message');
        message.text('{$text}');
        let position = message.val().substr(0, message.val().selectionStart).split('.')[0].length + 2;
        let data = {
            search : {
                'PARTNERS' : '{$user->short_name}',
                '{$user->mobiltelefon}' : '{$partner->name}'
            },
            replace : {
                'PARTNERS' : '{$partner->name}',
                '{$user->mobiltelefon}' : '{$user->short_name}'
            }
        };

        message.focus(function(){
            if (focused) {
                focused = false;
                setTimeout(function(){ 
                    setSelectionRange(message[0], position, position);
                }, 0);
            }
        });
        
        $('#sms-from').change(function () {
            let val = message.val().replace(data.search[$(this).val()], data.replace[$(this).val()]);
            message.val(val);
        });
        
        function setSelectionRange(input, selectionStart, selectionEnd) {
            if (input.setSelectionRange) {
                input.focus();
                input.setSelectionRange(selectionStart, selectionEnd);
            } else if (input.createTextRange) {
                var range = input.createTextRange();
                range.collapse(true);
                range.moveEnd('character', selectionEnd);
                range.moveStart('character', selectionStart);
                range.select();
            }
        }
    })"
); ?>
