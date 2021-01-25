<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $form \common\models\Forms */
/* @var $user \common\models\User */
/* @var $args array */

/** @var \common\models\PropertyDetails $property */
$property = $args['property']
?>

<p>
    Hei, <?= $user->navn ?>.<br/>
    Partners.no har registrert <?= count($args['forms']) ?> stk. 'Be om salgssum' skjemaer til:<br/>
    Oppdragsnummer: <?= $property->oppdragsnummer; ?><br/>
    Adresse: <?= $property->adresse; ?><br/>
    <?= Yii::$app->params['baseUrl'] . "admin/oppdrag/detaljer/{$property->id}" ?>
</p>


<?php foreach ($args['forms'] as $form): ?>
    <p>
        Navn: <?= $form->name ?><br/>
        Telefon: <?= $form->phone ?><br/>
        Lenke: <?= Yii::$app->params['baseUrl'] . "admin/clients/detaljer/{$form->id}" ?><br/>
        Dato: <?= date('Y/m/d H:i', $form->created_at) ?><br/>
        -------------
    </p>
<?php endforeach; ?>

<?= $this->render('../_footer') ?>