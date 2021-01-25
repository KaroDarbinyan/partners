<?php

/* @var $this View */
/* @var $model Forms */

use common\models\Forms;
use yii\helpers\Url;
use yii\web\View;
use \yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?php $this->beginBlock('head') ?>
<meta property="og:type" content="website"/>
<meta property="og:title" content="KONTAKT OSS"/>
<meta property="og:description"
      content="Selge, kjøpe eller få rådgivning om bolig? Fyll ut skjema, så kontakter vi deg i løpet av kort tid!"/>
<meta property="og:url" content="<?= Url::current([], true); ?>"/>
<meta property="og:image" content="<?= Url::home(true); ?>img/property-default.jpg"/>
<meta property="og:site_name" content="PARTNERS.NO"/>
<?php $this->endBlock() ?>

<?php $this->beginBlock('page_header') ?>
<header class="header bg_img bg_overlay" data-background="/img/header_contact_bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <h1 class="align-center uppercase regular"><?= Yii::$app->view->params['header'] ?></h1>
                <h4 class="align-center">Selge, kjøpe eller få rådgivning om bolig?<br> Fyll ut skjema, så kontakter vi deg i løpet av kort tid!</h4>

                <?php $form = ActiveForm::begin(['id' => 'kontakt-form',
                    'fieldConfig' => [
                        'options' => [
                            'tag'=>false
                        ],
                    ],
                    'options' => [
                        'class' => 'lead-form contact_form'
                    ]]) ?>

                <?= $form->field($model, 'type', ['errorOptions' => ['tag' => null]])
                    ->hiddenInput(['value' => 'kontakt', 'class' => false])
                    ->label(false) ?>

                <?= $form->field($model, 'phone')
                    ->textInput(['class' => 'styler', 'placeholder' => 'Telefon'])
                    ->label(false) ?>

                <?= $form->field($model, 'post_number')
                    ->textInput(['class' => 'styler', 'placeholder' => 'Postnummer'])
                    ->label(false) ?>

                <?= $form->field($model, 'name')
                    ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'Navn'])
                    ->label(false) ?>

                <?= $form->field($model, 'email')
                    ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'E-post'])
                    ->label(false) ?>

                <!--<?= $form->field($model, 'message')
                        ->textarea(['rows' => 6, 'class' => 'styler', 'placeholder' => 'Melding'])
                    ->label(false) ?>-->

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

                <?= Html::submitButton('Send', ['class' => 'order mt-4']) ?>

                <?php ActiveForm::end() ?>

                <p class="center">Lang og bred erfaring, sammen med best mulig eksponering av din bolig i riktige kanaler, sørger for at du som kunde oppnår best mulig pris. Megleren fra Partners ivaretar deg gjennom hele salgsprosessen, og sikrer deg en trygg og god handel.</p>
                
            </div>
        </div>
    </div>
</header>
<?php $this->endBlock() ?>
