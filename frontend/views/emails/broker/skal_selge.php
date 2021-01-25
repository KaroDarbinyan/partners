<?php

/* @var $this yii\web\View */
/* @var $form \common\models\Forms */
/* @var $user \common\models\User */

?>

Hei, <?= $user->navn ?>.<br/>
Partners.no har registrert en ny skal_selge: <br/><br/>

<?= $this->render('../_info', compact('form')) ?>
<?= $this->render('../_checkboxes', compact('form')) ?>
<?= $this->render('../_footer') ?>
