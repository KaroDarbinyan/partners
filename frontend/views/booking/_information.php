<?php

use common\models\Forms;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $model Forms */
/* @var $showMessage bool */

?>

<h2><b>Fyll ut informasion</b></h2>
<div class="row">
    <div class="col-10 offset-1">
        <?php $form = ActiveForm::begin([
            'id' => 'meglerbooking-form',
            'fieldConfig' => ['options' => ['tag' => false]],
            'options' => ['class' => 'lead-form']
        ]); ?>

        <?= $form->field($data, 'type', ['errorOptions' => ['tag' => null]])
            ->hiddenInput(['class' => false])
            ->label(false) ?>

        <?= $form->field($data, 'department_id', ['errorOptions' => ['tag' => null]])
            ->hiddenInput(['class' => false])
            ->label(false) ?>

        <?= $form->field($data, 'broker_id', ['errorOptions' => ['tag' => null]])
            ->hiddenInput(['class' => false])
            ->label(false) ?>

        <div class="form-row">
            <div class="col-12 col-md-6 mb-3 pr-3">
                <?= $form->field($data, 'phone')
                    ->textInput(['class' => 'input-lg mb-3', 'placeholder' => 'Telefon'])
                    ->label(false) ?>
            </div>
            <div class="col-12 col-md-6 mb-3 pl-3">
                <?= $form->field($data, 'post_number')
                    ->textInput(['class' => 'input-lg mb-3', 'placeholder' => 'Postnummer'])
                    ->label(false) ?>
            </div>
        </div>

        <div class="form-row">
            <div class="col-12 col-md-6 mb-3 pr-3">
                <?= $form->field($data, 'name')
                    ->textInput(['maxlength' => true, 'class' => 'input-lg mb-3', 'placeholder' => 'Navn'])
                    ->label(false) ?>
            </div>
            <div class="col-12 col-md-6 pl-3">
                <?= $form->field($data, 'email')
                    ->textInput(['maxlength' => true, 'class' => 'input-lg mb-3', 'placeholder' => 'E-post'])
                    ->label(false) ?>
            </div>
        </div>

        <?= $form->field($data, 'subscribe_email', [
            'template' => '{input} {label} {error}{hint}'
        ])
            ->checkbox(['class' => 'input_check'], false)
            ->label('Jeg ønsker å motta eiendomsrelatert informasjon (nyhetsbrev o.l.) på e-post', ['class' => 'label_check text-left'])
        ?>

        <?= $form->field($data, 'i_agree', [
            'template' => '{input} {label} {error}{hint}'
        ])
            ->checkbox(['class' => 'input_check'], false)
            ->label('Jeg har lest og godkjent <a href="/personvern" target="_blank">vilkårene</a>', ['class' => 'label_check text-left'])
        ?>

        <?= Html::submitButton('SEND', ['class' => 'order mt-4 w-100']) ?>

        <?php ActiveForm::end(); ?>


    </div>
</div>
<br>
<div class="mt-5 navigate-container">
    <button class="order" data-url="/booking/calendar">Gå tilbake</button>
</div>