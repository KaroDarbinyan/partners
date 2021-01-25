<?php

use common\models\Mail;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Mail */


$this->title = 'Send epost';
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

');
?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div style="clear: both; padding-top: 30px; display: block;"></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="" style="margin-top: 15px;">
                                <h4 style="color: white;">
                                    Send epost
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body m--block-center">
                        <?php $form = ActiveForm::begin([
                            'id' => 'mailing-form',
                            'method' => 'post',
                        ]); ?>

                        <?= $form->field($model, 'subject')->textInput([
                            'placeholder' => 'Subject',
                        ])->label(false); ?>

                        <?= $form->field($model, 'message')->widget(TinyMce::class, [
                            'options' => [
                                'rows' => 35,
                                'class' => 'form-control is-tinymce'
                            ],
                            'language' => 'en',
                            'clientOptions' => [
                                'plugins' => [
                                    'advlist autolink lists link charmap hr preview pagebreak',
                                    'searchreplace wordcount textcolor visualblocks visualchars code fullscreen nonbreaking',
                                    'save insertdatetime media table contextmenu template paste image',
                                ],
                                'force_br_newlines' => false,
                                'force_p_newlines' => true,
                                'forced_root_block' => '',
                                'default_link_target' => "_blank",
                                'toolbar' => "undo redo | styleselect | bold italic | fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image blockquote",
                                'relative_urls' => false,
                                'images_upload_url' => '/admin/news/upload',
                                'automatic_uploads' => true,
                                'file_picker_types' => 'file image media',
                                'image_dimensions' => false
                            ]
                        ])->label(false); ?>

                        <?= $form->field($model, 'email')->textInput([
                            'placeholder' => 'Email',
                        ])->label(false); ?>

                        <?= $form->field($model, 'from')->dropDownList([
                            'Partners <post@partners.no>' => 'Send som Partners',
                            "{$user->short_name} <{$user->email}>" => "Send som {$user->short_name}"
                        ], [
                            'class' => 'form-control selectpicker',
                        ])->label(false); ?>

                        <div class="form-group">
                            <?= Html::submitButton('Send', ['class' => 'btn btn-success', 'style' => 'margin-top: 20px; border-radius: 7px']) ?>
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
