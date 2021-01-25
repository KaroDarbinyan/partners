<?php
/* @var $form \common\models\Forms */
?>

<?php if ($form->subscribe_email || $form->contact_me || $form->send_sms): ?>
    <br>Kunden har gitt følgende samtykker:<br>
<?php endif ?>

<ul>
    <?php if ($form->subscribe_email): ?>
        <li>Jeg ønsker å motta eiendomsrelatert informasjon (nyhetsbrev o.l.) på e-post</li>
    <?php endif ?>

    <?php if ($form->contact_me): ?>
        <li>Jeg skal selge bolig og vil bli kontaktet på telefon eller e-post</li>
    <?php endif ?>

    <?php if ($form->send_sms): ?>
        <li>Jeg ønsker budvarsel på sms</li>
    <?php endif ?>
</ul>