<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $this \yii\web\View */
/* @var $model \common\models\Forms */

?>

<?php $this->beginBlock('page_header') ?>


<header class="header bg_img bg_overlay" data-background="/img/header_contact_bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <h1 class="align-center uppercase regular">PRISTILBUD</h1>
                <h4 class="align-center">Ønsker du et uforpliktende tilbud fra en av våre meglere?<br/>Fyll ut skjema, så kontakter vi deg i løpet av kort tid!</h4>

                <?php $form = ActiveForm::begin([
                    'id' => 'pristibud-form',
                    'fieldConfig' => ['options' => ['tag' => false]],
                    'options' => ['class' => 'lead-form contact_form']
                ]) ?>

                <?= $form->field($model, 'type', ['errorOptions' => ['tag' => null]])
                    ->hiddenInput(['value' => 'pristilbud', 'class' => false])
                    ->label(false) ?>

                <?= $form->field($model, 'phone')
                    ->textInput(['class' => 'input-lg mb-3', 'placeholder' => 'Telefon'])
                    ->label(false) ?>
                <?= $form->field($model, 'post_number')
                    ->textInput(['class' => 'input-lg mb-3', 'placeholder' => 'Postnummer'])
                    ->label(false) ?>

                <?= $form->field($model, 'name')
                    ->textInput(['maxlength' => true, 'class' => 'input-lg mb-3', 'placeholder' => 'Navn'])
                    ->label(false) ?>
                    
                <?= $form->field($model, 'email')
                    ->textInput(['maxlength' => true, 'class' => 'input-lg mb-3', 'placeholder' => 'E-post'])
                    ->label(false) ?>
                    
                <?= $form->field($model, 'message')
                    ->textarea(['rows' => 4, 'class' => 'input-lg mb-3', 'placeholder' => 'Melding'])
                    ->label(false) ?>

                <?= $form->field($model, 'subscribe_email', [
                    'template' => '{input} {label} {error}{hint}'
                ])
                    ->checkbox(['class' => 'input_check'], false)
                    ->label('Jeg ønsker å motta eiendomsrelatert informasjon (nyhetsbrev o.l.) på e-post', ['class' => 'label_check'])
                ?>

                <?= $form->field($model, 'i_agree', [
                    'template' => '{input} {label} {error}{hint}'
                ])
                    ->checkbox(['class' => 'input_check'], false)
                    ->label('Jeg har lest og godkjent <a href="/personvern" target="_blank">vilkårene</a>', ['class' => 'label_check'])
                ?>

                <?= Html::submitButton('SEND', ['class' => 'order mt-4']) ?>
                
                <?php ActiveForm::end() ?>

                <p class="center">Lang og bred erfaring, sammen med best mulig eksponering av din bolig i riktige kanaler, sørger for at du som kunde oppnår best mulig pris. Megleren fra Partners ivaretar deg gjennom hele salgsprosessen, og sikrer deg en trygg og god handel.</p>
            </div>
        </div>
    </div>
</header>

<?php $this->endBlock() ?>
