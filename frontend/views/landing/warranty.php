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

<div class="container">
  <div class="d-flex align-items-xl-center min-vh-100">
    <div class="row pt-6">
      <div class="col-12">
        <h1 class="font-weight-bold">Hvilepulsgaranti fra <?= $department->short_name ?? 'Partners' ?></h1>
        <h2>– Økonomisk trygghet til deg som kjøper bolig før du selger</h2>

        <p><b>50 prosent kjøper ny bolig før den gamle er solgt.</b> Dessverre går ikke alltid boligsalget som planlagt.
          Enkelte ganger kan det
          nemlig ta litt lenger tid å få solgt boligen enn du hadde regnet med. Dermed kan du ende opp med å måtte
          betjene to boliglån
          samtidig, noe som kan knekke enhver familieøkonomi.</p>

        <p><b>Partners tilbyr deg Hvilepulsgaranti</b> – en forsikring med dobbel rentedekning, som dekker
          rentekostnaden og forsikringsutgiftene
          på den gamle boligen din. Hvilepulsgaranti er inkludert i Boligkjøperpakken, som gjør boligkjøp tryggere for
          deg. Boligkjøperpakken
          inneholder dobbel rentedekning, boligkjøperforsikring, innboforsikring og hus/hytteforsikring mm.</p>

        <p><b>Hvilepulsgaranti gir deg en mer avslappet bolighandel</b> med lavere puls, og tar brodden av stresset
          mange føler på i en slik
          situasjon. Hvilepulsgaranti er positivt for deg som kjøper en Partners-bolig, som igjen gjør det positivt for
          deg vi selger bolig for.</p>

        <div class="row mt-5">
          <div class="col-12">
            <h3>Snakk med oss om Hvilepulsgaranti</h3>
            <p>Vi gleder oss til å fortelle deg alt du trenger å vite om Hvilepulsgaranti
              med dobbel rentedekning. Og hvis du ønsker, gir vi deg gode råd og tips
              om kjøp og salg i tillegg.</p>

            <p>Ta kontakt for en hyggelig og uforpliktende prat med en lokalkjent
              Partners-megler.</p>
          </div>
          <div class="col-6">
              <?php $form = ActiveForm::begin(['id' => 'hvilepulsgaranti-form',
                  'fieldConfig' => [
                      'options' => [
                          'tag' => false
                      ],
                  ],
                  'options' => [
                      'class' => 'lead-form mb-4'
                  ]]) ?>

              <?= $form->field($formModel, 'type', ['errorOptions' => ['tag' => null]])
                  ->hiddenInput(['value' => 'kontakt', 'class' => false])
                  ->label(false) ?>

              <?= $form->field($formModel, 'referer_source', ['errorOptions' => ['tag' => null]])
                  ->hiddenInput(['value' => 'Involve Ads', 'class' => false])
                  ->label(false) ?>

              <?= $form->field($formModel, 'message', ['errorOptions' => ['tag' => null]])
                  ->hiddenInput(['value' => 'Kunde ønsker mer info om Hvilepulsgaranti', 'class' => false])
                  ->label(false) ?>

              <?= $form->field($formModel, 'department_id', ['errorOptions' => ['tag' => null]])
                  ->hiddenInput(['value' => $department->web_id ?? null, 'class' => false])
                  ->label(false) ?>

              <?= $form->field($formModel, 'broker_id', ['errorOptions' => ['tag' => null]])
                  ->hiddenInput(['value' => $department->avdelingsleder ?? null, 'class' => false])
                  ->label(false) ?>

              <?= $form->field($formModel, 'phone')
                  ->textInput(['class' => 'styler', 'placeholder' => 'Telefon'])
                  ->label(false) ?>

              <?= $form->field($formModel, 'name')
                  ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'Navn'])
                  ->label(false) ?>

              <?= $form->field($formModel, 'post_number')
                  ->textInput(['class' => 'styler', 'placeholder' => 'Postnummer'])
                  ->label(false) ?>

              <?= $form->field($formModel, 'i_agree', [
                  'template' => '{input} {label} {error}{hint}'
              ])
                  ->checkbox(['class' => 'input_check'], false)
                  ->label('Jeg har lest og godkjent <a href="/personvern" target="_blank">vilkårene</a>', ['class' => 'label_check'])
              ?>

              <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'order mt-4']) ?>

              <?php ActiveForm::end(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>