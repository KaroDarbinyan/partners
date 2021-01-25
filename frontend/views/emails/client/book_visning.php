<?php

/* @var $this yii\web\View */
/* @var $form \common\models\Forms */
/* @var $user \common\models\User */

?>

Hei, <?= $form->name ?>.<br/>

Du er nå påmeldt til visning på <?= $form->propertyDetails->adresse ?>.
Husk å gi beskjed om du er forhindret i å komme.

<?php if ($form->user): ?>
    Vennlig Hilsen <?= $form->user->navn ?>
<?php endif ?>

<?= $this->render('../_footer') ?>
