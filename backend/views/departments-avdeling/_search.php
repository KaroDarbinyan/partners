<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DepartmentsAvdelingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="departments-avdeling-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id__') ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_firma') ?>

    <?= $form->field($model, 'navn') ?>

    <?= $form->field($model, 'juridisknavn') ?>

    <?php // echo $form->field($model, 'organisasjonsnummer') ?>

    <?php // echo $form->field($model, 'urlhtmlpresentasjon_avdeling') ?>

    <?php // echo $form->field($model, 'urlhtmlpresentasjon_konsern') ?>

    <?php // echo $form->field($model, 'logo_url') ?>

    <?php // echo $form->field($model, 'besoksadresse') ?>

    <?php // echo $form->field($model, 'postadresse') ?>

    <?php // echo $form->field($model, 'postnummer') ?>

    <?php // echo $form->field($model, 'poststed') ?>

    <?php // echo $form->field($model, 'telefon') ?>

    <?php // echo $form->field($model, 'telefax') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'hjemmeside') ?>

    <?php // echo $form->field($model, 'inaktiv') ?>

    <?php // echo $form->field($model, 'dagligleder') ?>

    <?php // echo $form->field($model, 'avdelingsleder') ?>

    <?php // echo $form->field($model, 'fagansvarlig') ?>

    <?php // echo $form->field($model, 'superbruker') ?>

    <?php // echo $form->field($model, 'bilder') ?>

    <?php // echo $form->field($model, 'fritekster') ?>

    <div class="form-group">
        <?= Html::submitButton('Søk', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Nullstille', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
