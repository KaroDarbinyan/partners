<?php

/* @var $this View */

/* @var $model Forms */

use common\models\Forms;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\View;

?>

<div
        id="contact-modal"
        data-dynamic-form="contact-modal"
        class="modal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="contactModalLabel"
        aria-hidden="true"
>
  <div class="modal-dialog modal-md modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="contactModalLabel">KONTAKT OSS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <?php $form = ActiveForm::begin([
              'id' => 'contact-form',
              'fieldConfig' => ['options' => ['tag' => false]],
              'options' => ['class' => 'lead-form']
          ]) ?>

          <?= $form->field($model, 'type', ['errorOptions' => ['tag' => null]])
              ->hiddenInput(['class' => false])
              ->label(false) ?>

          <?= $form->field($model, 'broker_id', ['errorOptions' => ['tag' => null]])
              ->hiddenInput(['class' => false])
              ->label(false) ?>

          <?= $form->field($model, 'department_id', ['errorOptions' => ['tag' => null]])
              ->hiddenInput(['class' => false])
              ->label(false) ?>

          <?= $form->field($model, 'target_id', ['errorOptions' => ['tag' => null]])
              ->hiddenInput(['class' => false])
              ->label(false) ?>

        <div class="row">
          <div class="col-12 col-lg-12">
              <?= $form->field($model, 'phone')
                  ->textInput(['class' => 'styler', 'placeholder' => 'Telefon'])
                  ->label(false) ?>
          </div>
          <div class="col-12 col-lg-12">
              <?= $form->field($model, 'post_number')
                  ->textInput(['class' => 'styler', 'placeholder' => 'Postnummer'])
                  ->label(false) ?>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-12 col-lg-12">
              <?= $form->field($model, 'name')
                  ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'Navn'])
                  ->label(false) ?>
          </div>
          <div class="col-12 col-lg-12">
              <?= $form->field($model, 'email')
                  ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'E-post'])
                  ->label(false) ?>
          </div>
        </div>
          <?php if (false && isset($this->params['booking_field'])): ?>
            <div class="forms-booking_date default-hidden pb-1" style="display: none">
                <?= $form->field($model, 'booking_date')->dropDownList($this->params['booking_field']['items'], [
                    'class' => 'form-control booking-date-selectpicker',
                    'options' => $this->params['booking_field']['options']
                ])->label(false); ?>
            </div>
          <?php endif; ?>
        <div class="forms-message default-hidden" style="display: none">
            <?= $form->field($model, 'message')
                ->textarea(['rows' => 4, 'class' => 'input-lg mb-3', 'placeholder' => 'Melding'])
                ->label(false) ?>
        </div>

        <div class="forms-book_visning default-hidden" style="display: none">
            <?= $form->field($model, 'book_visning', [
                'template' => '{input} {label} {error}{hint}'
            ])
                ->checkbox(['class' => 'input_check'], false)
                ->label('Jeg har lest og forstått <a href="' . Url::toRoute('site/info-corona-virus') . '" target="_blank">informasjonen om Coronavirus</a>', ['class' => 'label_check'])
            ?>
        </div>

          <?= $form->field($model, 'subscribe_email', [
              'template' => '{input} {label} {error}{hint}'
          ])
              ->checkbox(['class' => 'input_check'], false)
              ->label('Jeg ønsker å motta eiendomsrelatert informasjon (nyhetsbrev o.l.) på e-post', ['class' => 'label_check'])
          ?>

        <div class="forms-send_sms default-hidden" style="display: none">
            <?= $form->field($model, 'send_sms', [
                'template' => '{input} {label} {error}{hint}'
            ])
                ->checkbox(['class' => 'input_check'], false)
                ->label('Jeg ønsker budvarsel på sms', ['class' => 'label_check'])
            ?>
        </div>

        <div class="forms-contact_me default-hidden" style="display: none">
            <?= $form->field($model, 'contact_me', [
                'template' => '{input} {label} {error}{hint}'
            ])
                ->checkbox(['class' => 'input_check'], false)
                ->label('Jeg skal selge bolig og vil bli kontaktet på telefon eller e-post', ['class' => 'label_check'])
            ?>
        </div>

        <div class="forms-download_sales_report default-hidden" style="display: none">
            <?= $form->field($model, 'download_sales_report', [
                'template' => '{input} {label} {error}{hint}'
            ])
                ->checkbox(['class' => 'input_check'], false)
                ->label('Last ned salgsoppgave', ['class' => 'label_check'])
            ?>
        </div>
        <div class="forms-subscribe_to_related_properties default-hidden" style="display: none">
            <?= $form->field($model, 'subscribe_to_related_properties', [
                'template' => '{input} {label} {error}{hint}'
            ])
                ->checkbox(['class' => 'input_check'], false)
                ->label('Jeg ønsker tips om liknende eiendommer på e-post', ['class' => 'label_check'])
            ?>
        </div>

          <?= $form->field($model, 'i_agree', [
              'template' => '{input} {label} {error}{hint}'
          ])
              ->checkbox(['class' => 'input_check'], false)// TODO: use url to route to get url for link
              ->label('Jeg har lest og godkjent <a href="/personvern" target="_blank">vilkårene</a> <span class="default-hidden" style="display: none">og ønsker budvarsel på SMS</span>', ['class' => 'label_check'])
          ?>

          <?= Html::submitButton('SEND', ['class' => 'order mt-4']) ?>

          <?php ActiveForm::end() ?>
      </div>
    </div>
  </div>
</div>