<?php

/* @var $this yii\web\View */
/* @var $form \common\models\Forms */
/* @var $user \common\models\User */

?>

Hei, <?= $user->navn ?>.<br/>
En interessent har meldt seg på visning. Ta kontakt direkte med kunden for å avtale nærmere. <br/><br/>

<?= $this->render('../_info', compact('form')) ?>
<?= $this->render('../_checkboxes', compact('form')) ?>
<?= $this->render('../_footer') ?>
