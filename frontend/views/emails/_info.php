<?php

/* @var $this yii\web\View */
/* @var $form \common\models\Forms */
/* @var $user \common\models\User */

$link = Yii::$app->params['baseUrl'] . "admin/clients/detaljer/$form->id";
$propertyLink = Yii::$app->params['baseUrl'] . "annonse/$form->target_id"

?>

Navn: <?= $form->name ?><br/>
Postnr: <?= $form->post_number ?><br/>
Telefon: <?= $form->phone ?><br/>
Epost: <?= $form->email ?><br/>
Kommentar: <?= $form->message ?><br/><br/>

<?php if ($form->propertyDetails): ?>
    Oppdragsnummer: <a href="<?= $propertyLink ?>"><?= $form->propertyDetails->oppdragsnummer ?></a><br>
    Adresse: <?= $form->propertyDetails->postnummer ?> <?= $form->propertyDetails->adresse ?><br><br>
<?php endif ?>

Registrert: <?= date('F j, Y, g:i a', $form->created_at) ?><br/>

<?php if ($form->referer_source): ?>
    Kilde: <a href="<?= $form->referer_source ?>"><?= $form->referer_source ?></a><br/>
<?php endif ?>

Lenke: <a href="<?= $link ?>"><?= $link ?></a><br/>

<?php if ($form->hasType('salgsoppgave') && $form->propertyDetails->salgsoppgaveDownloadLink): ?>
    <a href="<?= $form->propertyDetails->salgsoppgaveDownloadLink->url ?>">Laste ned komplett salgsoppgave</a><br>
<?php endif ?>
