<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use devgroup\jsoneditor\Jsoneditor;
/* @var $this yii\web\View */
/* @var $model common\models\DepartmentsAvdeling */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="departments-avdeling-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_firma')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'navn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'juridisknavn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'organisasjonsnummer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'urlhtmlpresentasjon_avdeling')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'urlhtmlpresentasjon_konsern')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logo_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'besoksadresse')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'postadresse')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'postnummer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'poststed')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hjemmeside')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inaktiv')->textInput(['maxlength' => true]) ?>

    <label class="control-label" for="departmentsavdeling-dagligleder">Dagligleder</label>
    <?= Jsoneditor::widget(
            [
                'editorOptions' => [
                    'mode' => 'code', // current mode
                ],
                'model' => $model,
                'attribute' =>  'dagligleder',
            ]
        )
    ?>

    <label class="control-label" for="departmentsavdeling-avdelingsleder">Avdelingsleder</label>
    <?= Jsoneditor::widget(
        [
            'editorOptions' => [
                'mode' => 'code', // current mode
            ],
            'model' => $model,
            'attribute' =>  'avdelingsleder',
        ]
    )
    ?>


    <label class="control-label" for="departmentsavdeling-fagansvarlig">Fagansvarlig</label>
    <?= Jsoneditor::widget(
        [
            'editorOptions' => [
                'mode' => 'code', // current mode
            ],
            'model' => $model,
            'attribute' =>  'fagansvarlig',
        ]
    )
    ?>


    <label class="control-label" for="departmentsavdeling-superbruker">Superbruker</label>
    <?= Jsoneditor::widget(
        [
            'editorOptions' => [
                'mode' => 'code', // current mode
            ],
            'model' => $model,
            'attribute' =>  'superbruker',
        ]
    )
    ?>


    <label class="control-label" for="departmentsavdeling-fritekster">Fritekster</label>
    <?= Jsoneditor::widget(
        [
            'editorOptions' => [
                'mode' => 'code', // current mode
            ],
            'model' => $model,
            'attribute' =>  'fritekster',
        ]
    )
    ?>


    <?= $form->field($model, 'bilder')->textarea(['maxlength' => true, 'rows' => '6']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
