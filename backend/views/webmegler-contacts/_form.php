<?php

use devgroup\jsoneditor\Jsoneditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WebmeglerContacts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webmegler-contacts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'har_tilgang_til_detaljer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kontakttype')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_kontakter__ny')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_kunder')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fornavn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'etternavn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'firmanavn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'organisasjonsnummer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'adresse')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'postnummer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'poststed')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'land')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nyadresse')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nypostnummer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nypoststed')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nyadressefradato')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nyland')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobiltelefon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'personnummer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fodselsdato')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_ansatte__registrertav')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_ansatte__endretav')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'endretdato')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'registrertdato')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'relatertegrupper')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'budgiveroppdrag')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'andrekontakteroppdrag')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'interessentoppdrag')->textInput(['maxlength' => true]) ?>


    <label class="control-label" for="departmentsavdeling-selgerkjoperoppdrag">Selgerkjoperoppdrag</label>
    <?= Jsoneditor::widget(
        [
            'editorOptions' => [
                'mode' => 'code', // current mode
            ],
            'model' => $model,
            'attribute' =>  'selgerkjoperoppdrag',
        ]
    )
    ?>


    <?= $form->field($model, 'samtykkeregistreringer')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
