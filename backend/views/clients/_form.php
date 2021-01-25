<?php

/** @var Forms $lead */

/** @var Client $client */

use backend\components\UrlExtended;
use common\models\Client;
use common\models\Forms;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<?php yii\widgets\Pjax::begin([
    'id' => 'client_update',
    'submitEvent' => 'change',
    'enablePushState' => false, 'enableReplaceState' => false,
])
?>
<?php $form = ActiveForm::begin([
    'method' => 'post',
    'options' => ['data-pjax' => true],
    'action' => Url::toRoute(['clients/update-client', 'id' => $lead->id,]),
]); ?>
<?= $client ? $form->field($client, 'blocked')->checkbox(array(
    'label' => 'Ønsker ikke å bli fulgt opp <span></span>',
    'labelOptions' => ['class' => 'm-checkbox m-checkbox--solid m-checkbox--danger'],
)) : ''; ?>
<?php ActiveForm::end(); ?>

<?php yii\widgets\Pjax::end() ?>

<?php if ($lead->hasType('book_visning')): ?>
  <label class="m-checkbox m-checkbox--solid m-checkbox--success m-checkbox--disabled">
    <input disabled type="checkbox" <?= $lead->book_visning ? 'checked' : '' ?>>
    Jeg har lest og forstått <a href="/site/info-corona-virus" target="_blank">informasjonen om Coronavirus</a>
    <span></span>
  </label>
<?php endif ?>

<!-- verdivurdering -->
<label class="m-checkbox m-checkbox--solid m-checkbox--success m-checkbox--disabled">
  <input disabled type="checkbox" <?= $lead->subscribe_email ? 'checked' : '' ?>>
  Jeg ønsker å motta eiendomsrelatert informasjon (nyhetsbrev o.l.) på e-post
  <span></span>
</label>

<?php if ($lead->hasType(['salgsoppgave', 'book_visning'])): ?>
  <label class="m-checkbox m-checkbox--solid m-checkbox--success m-checkbox--disabled">
    <input disabled type="checkbox" <?= $lead->send_sms ? 'checked' : '' ?>>
    Jeg ønsker budvarsel på sms
    <span></span>
  </label>
<?php endif ?>

<?php if (!$lead->hasType(['skal_selge', 'kontakt'])): ?>
  <label class="m-checkbox m-checkbox--solid m-checkbox--success m-checkbox--disabled">
    <input disabled type="checkbox" <?= $lead->contact_me ? 'checked' : '' ?>>
    Jeg skal selge bolig og vil bli kontaktet på telefon eller e-post
    <span></span>
  </label>
<?php endif ?>

<?php if ($lead->hasType('download_sales_report')): ?>
  <label class="m-checkbox m-checkbox--solid m-checkbox--success m-checkbox--disabled">
    <input disabled type="checkbox" <?= $lead->download_sales_report ? 'checked' : '' ?>>
    Last ned salgsoppgave
    <span></span>
  </label>
<?php endif ?>

<?php if ($lead->hasType(['salgsoppgave', 'book_visning'])): ?>
  <label class="m-checkbox m-checkbox--solid m-checkbox--success m-checkbox--disabled">
    <input disabled type="checkbox" <?= $lead->boligvarsling_id ? 'checked' : '' ?>>
    Jeg ønsker tips om liknende eiendommer på e-post
      <?php if ($lead->boligvarsling_id): ?>
        (<a href="<?= UrlExtended::toRoute(['clients/boligvarsling-edit', 'id' => $lead->boligvarsling_id]) ?>">Redigere</a>)
      <?php endif ?>
    <span></span>
  </label>
<?php endif ?>

<?php if ($lead->hasType('visningliste')): ?>
  <label class="m-checkbox m-checkbox--solid m-checkbox--success m-checkbox--disabled">
    <input disabled type="checkbox" checked>
    Jeg har deltatt på visning og har lest og godkjent <a href="/personvern"
                                target="_blank">vilkårene</a> <?= $lead->hasType('budvarsel') ? 'og ønsker budvarsel på SMS' : '' ?>
    <span></span>
  </label>
<?php else: ?>
  <label class="m-checkbox m-checkbox--solid m-checkbox--success m-checkbox--disabled">
    <input disabled type="checkbox" checked>
    Jeg har lest og godkjent <a href="/personvern"
                                target="_blank">vilkårene</a> <?= $lead->hasType('budvarsel') ? 'og ønsker budvarsel på SMS' : '' ?>
    <span></span>
  </label>
<?php endif ?>
