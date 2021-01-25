<?php

/* @var $this yii\web\View */
/* @var $model common\models\Forms */
/* @var $broker common\models\User */

/* @var $property common\models\PropertyDetails */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $this->beginBlock('page_header') ?>
<header class="header bg_img bg_overlay" data-background="/img/header_broker_bg.jpg" style="padding: 50px 0;">
  <div class="container">
    <div class="row">
      <div class="col-12 tac">
        <h1 class="mb-2"><?= $property->title; ?>, <?= $property->adresse ?></h1>
        <h4><?= money($property->prisantydning) ?></h4>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-5 order-2 order-md-1">
          <?php $form = ActiveForm::begin(['id' => 'visningliste-form',
              'fieldConfig' => [
                  'options' => [
                      'tag' => false
                  ],
              ],
              'options' => [
                  'class' => 'lead-form contact_form'
              ]]) ?>

          <?= $form->field($model, 'type', ['errorOptions' => ['tag' => null]])
              ->hiddenInput(['value' => 'visningliste', 'class' => false])
              ->label(false) ?>

          <?= $form->field($model, 'post_number', ['errorOptions' => ['tag' => null]])
              ->hiddenInput(['value' => '0000'])
              ->label(false) ?>

          <?= $form->field($model, 'target_id', ['errorOptions' => ['tag' => null]])
              ->hiddenInput()
              ->label(false); ?>

          <?= $form->field($model, 'broker_id', ['errorOptions' => ['tag' => null]])
              ->hiddenInput()
              ->label(false); ?>

          <?= $form->field($model, 'phone')
              ->textInput(['class' => 'styler', 'placeholder' => 'Telefon'])
              ->label(false) ?>

          <?= $form->field($model, 'name')
              ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'Navn'])
              ->label(false) ?>

          <?= $form->field($model, 'email')
              ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'E-post'])
              ->label(false) ?>

          <?= $form->field($model, 'message')
              ->textarea(['rows' => 4, 'class' => 'styler', 'placeholder' => 'Kommentar'])
              ->label(false) ?>

          <?= $form->field($model, 'subscribe_email', [
              'template' => '{input} {label} {error}{hint}'
          ])
              ->checkbox(['class' => 'input_check'], false)
              ->label('Jeg ønsker å motta eiendomsrelatert informasjon (nyhetsbrev o.l.) på e-post', ['class' => 'label_check'])
          ?>

          <?= $form->field($model, 'contact_me', [
              'template' => '{input} {label} {error}{hint}'
          ])
              ->checkbox(['class' => 'input_check'], false)
              ->label('Jeg skal selge bolig og vil bli kontaktet på telefon eller e-post', ['class' => 'label_check'])
          ?>

          <?= $form->field($model, 'send_sms', [
              'template' => '{input} {label} {error}{hint}'
          ])
              ->checkbox(['class' => 'input_check', 'checked' => true], false)
              ->label('Jeg ønsker budvarsel på sms', ['class' => 'label_check'])
          ?>

          <?= $form->field($model, 'subscribe_to_related_properties', [
              'template' => '{input} {label} {error}{hint}'
          ])
              ->checkbox(['class' => 'input_check'], false)
              ->label('Jeg ønsker tips om liknende eiendommer på e-post', ['class' => 'label_check'])
          ?>

          <?= $form->field($model, 'i_agree', [
              'template' => '{input} {label} {error}{hint}'
          ])
              ->checkbox(['class' => 'input_check', 'checked' => true], false)
              ->label('Jeg har deltatt på visning og har lest og godkjent <a href="/personvern" target="_blank">vilkårene</a>', ['class' => 'label_check'])
          ?>

          <?= Html::submitButton('Registrer', ['class' => 'order mt-4']) ?>

          <?php ActiveForm::end() ?>
      </div>
      <div class="col-12 col-md-5 order-1 order-md-2">
        <div class="box_office_info box_broker_info box_visning">
          <div class="box_img">
            <img src="<?= $broker->urlstandardbilde ?>" alt="<?= $broker->navn ?>">
          </div>
          <div class="box_text">
            <h1 style="font-size: 30px;"><?= $broker->navn ?></h1>
            <p><?= $broker->tittel ?></p>
            <div class="box_info">
              <a href="mailto:<?= $broker->email ?>"><?= $broker->email ?></a>
              <br><a href="tel:<?= $broker->mobiltelefon ?>"><?= $broker->mobiltelefon ?></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-2">
      </div>
    </div>
  </div>
</header>
<?php $this->endBlock() ?>
