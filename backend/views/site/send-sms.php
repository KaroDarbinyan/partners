<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \common\models\Sms */
/** @var \common\models\User $user */

$this->title = 'Send tekstmelding';
$user = Yii::$app->user->identity;
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
#sms-phone{
     font-size: 18px;
}

');

$partner = Yii::$app->user->identity->partner;
?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div style="clear: both; padding-top: 30px; display: block;"></div>
        <div class="row">
            <div class="col-lg-5">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="" style="margin-top: 15px;">
                                <h4 style="color: white;">
                                    SMS sending
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body m--block-center">
                        <?php $form = ActiveForm::begin([
                            'id' => 'send-sms-form',
                            'method' => 'post',
                            'action' => '/admin/send-sms'
                        ]); ?>

                        <?= $form->field($model, 'message')->textarea([
                            'rows' => '10',
                            'placeholder' => 'Message',
                        ])->label(false); ?>

                        <?= $form->field($model, 'phone')->textInput()->label(false); ?>

                        <?= $form->field($model, 'from')->dropDownList([
                            "PARTNERS" => "Send som {$partner->name}",
                            $user->mobiltelefon => "Send som {$user->short_name}"
                        ], [
                            'class' => 'form-control selectpicker',
                        ])->label(false); ?>

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

<button type="button" id="open-modal" class="btn btn-info btn-lg d-none" data-toggle="modal"
        data-target="#myModal"></button>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #2b2b2b">
            <div class="modal-body">
                <h3 class="text-center text-success">Vellykket sendt</h3>
            </div>
            <div class="modal-footer" style="border-top: none">
                <button type="button" class="btn btn-default m--block-center" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
