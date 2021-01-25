<?php

/**
 * Created by PhpStorm.
 * User: FSW10
 * Date: 15.03.2019
 * Time: 14:21
 */

/* @var $this \yii\web\View */
/* @var $model \common\models\Forms */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>


<div class="forms-form">
    <div class="main">
        <div class="ic_body">
            <h1><?= Yii::$app->view->params['header'] ?></h1>
            <p>Ønsker du å vite din boligs antatte verdi? <br>Fyll ut skjema, så kontakter vi deg i løpet av kort tid!</p>
        </div>
        <?php $form = ActiveForm::begin([
            'id' => 'verdivurdering-form',
            'fieldConfig' => [
                'options' => [
                    'tag' => false
                ],
            ],
            'options' => [
                'class' => 'ic_form forms'
            ]
        ]); ?>
        <div class="icf_l">
            <div class="frow">
                <?= $form->field($model, 'phone')
                    ->textInput(['class' => 'styler', 'placeholder' => 'Telefon'])->label(false) ?>
                <?= $form->field($model, 'type', ['errorOptions' => ['tag' => null]])
                    ->hiddenInput(['value' => 'verdivurdering', 'class' => false])->label(false) ?>
            </div>
            <div class="frow">
                <?= $form->field($model, 'post_number')
                    ->textInput(['class' => 'styler', 'placeholder' => 'Postnummer'])->label(false) ?>
            </div>
            <div class="frow">
                <?= $form->field($model, 'name')
                    ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'Navn'])->label(false) ?>
            </div>
            <div class="frow">
                <?= $form->field($model, 'email')
                    ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'E-post'])->label(false) ?>
            </div>
        </div>
        <div class="icf_r">
            <div class="frow">
                <?= $form->field($model, 'message')
                    ->textarea(['rows' => 6, 'class' => 'styler hidden-xs', 'placeholder' => 'Melding'])->label(false) ?>
            </div>
            <div class="frow">
                <?= $form->field($model, 'subscribe_email')
                    ->checkbox(['class' => 'styler', 'label' => '<span>Jeg ønsker å motta eiendomsrelatert informasjon (nyhetsbrev o.l.) på e-post</span>'])
                    ->label(false) ?>
            </div>
            <div class="frow">
                <?= $form->field($model, 'i_agree')
                    ->checkbox(['class' => 'styler', 'label' => '<span>Jeg har lest og godkjent <a href="/personvern" target="_blank">vilkårene</a></span>'])->label(false) ?>
            </div>
        </div>
        <div class="icf_b">
            <div class="icfb_l">
            </div>
            <div class="icfb_r">
                <a href="#lagre_ditt_sok_result" style="display: none" class="popup" id="popup"></a>
                <?= Html::submitButton('SEND', ['class' => 'btn btn_s btn_more']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
