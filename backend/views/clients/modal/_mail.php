<?php

use common\models\Forms;
use common\models\Mail;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use common\models\User;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Mail */
/* @var $lead Forms */


/** @var User $user */
$user = Yii::$app->user->identity;
$partner = $user->partner;

$model = new Mail();

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

.tox.tox-tinymce {
    height: 350px !important;
}

');
?>

<div id="send_email" class="modal fade" role="dialog">
    <div class="modal-dialog mw-800px pl-5 pr-5">
        <div class="m-grid__item m-grid__item--fluid m-wrapper modal-content bg-dark">
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress- bg-dark">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="" style="margin-top: 15px;">
                                    <h4 class="text-white">Send E-post</h4>
                                    <button type="button" class="close float-right" data-dismiss="modal"
                                            aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body m--block-center pb-0">
                            <?php $form = ActiveForm::begin([
                                'id' => 'mailing-form',
                                'method' => 'post',
                                'action' => '/admin/mailing',
                                'options' => [
                                    'data-lead_id' => $lead->id
                                ]
                            ]); ?>

                            <?= $form->field($model, 'subject')->textInput([
                                'placeholder' => 'Subject',
                            ])->label(false); ?>

                            <?= $form->field($model, 'message')->widget(TinyMce::class, [
                                'options' => [
                                    'rows' => 12,
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

                            <?php if ($lead->email || $lead->email !== ""): ?>
                                <?= $form->field($model, 'email')->hiddenInput(["value" => $lead->email])->label(false); ?>
                            <?php else: ?>
                                <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email',])->label(false); ?>
                            <?php endif; ?>

                            <?php if ($delegatedUser): ?>
                                <?= $form->field($model, 'from')->hiddenInput(["value" => "{$delegatedUser->short_name} <{$delegatedUser->email}>"])->label(false); ?>
                            <?php else: ?>
                                <?= $form->field($model, 'from')->dropDownList([
                                    'Partners <post@partners.no>' => 'Send som Partners',
                                    "{$user->short_name} <{$user->email}>" => "Send som {$user->short_name}"
                                ], [
                                    "value" => "{$user->short_name} <{$user->email}>",
                                    "class" => "form-control selectpicker",
                                ])->label(false); ?>
                            <?php endif; ?>

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
</div>


<?php

$text = "<p>Hei {$lead->name}</p><p></p><p>Med vennlig hilsen</p><p>{$user->short_name}</p><p>www.partners.no</p>";

$this->registerJs("
    $(function (){
        let m_focused = true;
        let m_message = $('#mailing-form textarea#mail-message');
        m_message.text('{$text}');
        let m_position = m_message.val().substr(0, m_message.val().selectionStart).split('.')[0].length + 2;
        let m_data = {
            search : {
                'Partners <post@partners.no>' : '{$user->short_name}',
                '{$user->short_name} <{$user->email}>' : '{$partner->name}'
            },
            replace : {
                'Partners <post@partners.no>' : '{$partner->name}',
                '{$user->short_name} <{$user->email}>' : '{$user->short_name}'
            }
        };

        m_message.focus(function(){
            if (m_focused) {
                m_focused = false;
                setTimeout(function(){ 
                    setSelectionRange(m_message[0], m_position, m_position);
                }, 0);
            }
        });
        
        $('#mail-from').change(function () {
            let editor = tinymce.get()[0];
            let val = editor.getContent().replace(m_data.search[$(this).val()], m_data.replace[$(this).val()]);
            console.log($(this).val())
            console.log(m_data.search[$(this).val()])
            console.log(m_data.replace[$(this).val()])
            editor.setContent(val);
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

