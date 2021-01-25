<?php

/* @var $this yii\web\View */
/* @var $form \common\models\Forms */
?>

    Hei <?= $form->name ?>!<br>
    Tusen takk for din interesse for en av våre boliger!<br><br>

<?php if ($property = $form->propertyDetails): ?>
    Oppdragsnummer:
        <a href="<?= Yii::$app->params['baseUrl'] . "eiendommer/{$property->oppdragsnummer}" ?>"
        ><?= $property->oppdragsnummer ?></a><br>
    Adresse: <?= $property->postnummer ?> <?= $property->adresse ?><br><br>
<?php endif ?>

<?php if ($form->hasType('salgsoppgave') && $form->propertyDetails->getPdfLinkSalgsoppgave()): ?>
    Salgsoppgave:
        <a href="<?= $form->propertyDetails->getPdfLinkSalgsoppgave() ?>"
        >Denne linken tar deg til salgsoppgaven</a><br><br>
<?php endif ?>
<?php if ($form->user): ?>
    Vennlig hilsen, <?= $form->user->navn ?><br>
<?php endif; ?>
<?= $form->department ? $form->department->navn : 'PARTNERS EIENDOMSMEGLIN' ?>

<?= $this->render('../_footer') ?>

