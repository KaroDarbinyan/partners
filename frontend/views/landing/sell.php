<?php

use common\models\Department;
use common\models\Forms;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var View $this */
/* @var Forms $formModel */
/* @var Department $department */

?>

<div class="container-fluid">
  <div class="d-flex align-items-center justify-content-lg-end min-vh-100">
    <div class="row pt-6">
      <div class="col-12 col-xl-10">
        <h1 class="font-weight-bold">Vurderer du å selge?</h1>
        <p>Skal du selge og ønsker å vite din boligs antatte verdi?<br>
          Fyll ut skjema, så kontakter vi deg i løpet av kort tid!</p>
          <?php $form = ActiveForm::begin(['id' => 'selge-form',
              'fieldConfig' => [
                  'options' => [
                      'tag' => false
                  ],
              ],
              'options' => [
                  'class' => 'lead-form'
              ]]) ?>

          <?= $form->field($formModel, 'type', ['errorOptions' => ['tag' => null]])
              ->hiddenInput(['value' => 'skal_selge', 'class' => false])
              ->label(false) ?>

          <?= $form->field($formModel, 'department_id', ['errorOptions' => ['tag' => null]])
              ->hiddenInput(['value' => $department->web_id ?? null, 'class' => false])
              ->label(false) ?>

          <?= $form->field($formModel, 'referer_source', ['errorOptions' => ['tag' => null]])
              ->hiddenInput(['value' => 'Involve Ads', 'class' => false])
              ->label(false) ?>

        <div class="row">
          <div class="col-12 col-lg-6">
              <?= $form->field($formModel, 'phone')
                  ->textInput(['class' => 'styler', 'placeholder' => 'Telefon'])
                  ->label(false) ?>

              <?= $form->field($formModel, 'post_number')
                  ->textInput(['class' => 'styler', 'placeholder' => 'Postnummer'])
                  ->label(false) ?>

              <?= $form->field($formModel, 'name')
                  ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'Navn'])
                  ->label(false) ?>

              <?= $form->field($formModel, 'email')
                  ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'E-post'])
                  ->label(false) ?>
          </div>
          <div class="col-12 col-lg-6">
              <?= $form->field($formModel, 'message')
                  ->textarea(['rows' => 6, 'class' => 'styler d-none d-md-block', 'placeholder' => 'Melding'])
                  ->label(false) ?>

              <?= $form->field($formModel, 'subscribe_email', [
                  'template' => '{input} {label} {error}{hint}'
              ])
                  ->checkbox(['class' => 'input_check'], false)
                  ->label('Jeg ønsker å motta eiendomsrelatert informasjon (nyhetsbrev o.l.) på e-post', ['class' => 'label_check'])
              ?>

              <?= $form->field($formModel, 'i_agree', [
                  'template' => '{input} {label} {error}{hint}'
              ])
                  ->checkbox(['class' => 'input_check'], false)
                  ->label('Jeg har lest og godkjent <a href="/personvern" target="_blank">vilkårene</a>', ['class' => 'label_check'])
              ?>

              <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'order mt-4 float-lg-right']) ?>
          </div>
        </div>
          <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>