<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WebmeglerContactsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webmegler-contacts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id__') ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'har_tilgang_til_detaljer') ?>

    <?= $form->field($model, 'kontakttype') ?>

    <?= $form->field($model, 'id_kontakter__ny') ?>

    <?php // echo $form->field($model, 'id_kunder') ?>

    <?php // echo $form->field($model, 'fornavn') ?>

    <?php // echo $form->field($model, 'etternavn') ?>

    <?php // echo $form->field($model, 'firmanavn') ?>

    <?php // echo $form->field($model, 'organisasjonsnummer') ?>

    <?php // echo $form->field($model, 'adresse') ?>

    <?php // echo $form->field($model, 'postnummer') ?>

    <?php // echo $form->field($model, 'poststed') ?>

    <?php // echo $form->field($model, 'land') ?>

    <?php // echo $form->field($model, 'nyadresse') ?>

    <?php // echo $form->field($model, 'nypostnummer') ?>

    <?php // echo $form->field($model, 'nypoststed') ?>

    <?php // echo $form->field($model, 'nyadressefradato') ?>

    <?php // echo $form->field($model, 'nyland') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'telefon') ?>

    <?php // echo $form->field($model, 'mobiltelefon') ?>

    <?php // echo $form->field($model, 'personnummer') ?>

    <?php // echo $form->field($model, 'fodselsdato') ?>

    <?php // echo $form->field($model, 'id_ansatte__registrertav') ?>

    <?php // echo $form->field($model, 'id_ansatte__endretav') ?>

    <?php // echo $form->field($model, 'endretdato') ?>

    <?php // echo $form->field($model, 'registrertdato') ?>

    <?php // echo $form->field($model, 'relatertegrupper') ?>

    <?php // echo $form->field($model, 'budgiveroppdrag') ?>

    <?php // echo $form->field($model, 'andrekontakteroppdrag') ?>

    <?php // echo $form->field($model, 'interessentoppdrag') ?>

    <?php // echo $form->field($model, 'selgerkjoperoppdrag') ?>

    <?php // echo $form->field($model, 'samtykkeregistreringer') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
