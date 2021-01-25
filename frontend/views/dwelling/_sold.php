<?php

/* @var $this yii\web\View */
/* @var $model common\models\Forms */
/* @var $property common\models\PropertyDetails */
/* @var $broker common\models\User */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Solgt '.$property->type_eiendomstyper.' på '. $property->adresse. ' for '. number_format($property->prissamletsum, 0, ' ', ' '). ' NOK : Schala Partners eiendomsmegler';
$this->registerMetaTag(['name' => 'description', 'content' =>  $property->overskrift]);
?>

<?php if ($property->images && count($property->images) > 0): ?>
<img class="is-background"
     src="<?= $property->images[0]->urlstorthumbnail ?>"
     alt="<?= $property->kommuneomraade; ?>, <?= $property->adresse ?>"
     draggable="false">
<?php endif; ?>

<div class="main">
    <div class="sold-block visninliste-blocka">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-uppercase font-bold">Solgt</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="icm_l">
                    <div class="ic_body">
                        <P>&nbsp;</p>
                        <h2><?= $property->title ?>, <?= $property->adresse ?></h2>
                        <h2>Prisantydning: <?= number_format($property->prisantydning, 0, ' ', ' '); ?>, -</h2>
                        <h2>Størrelse: <?= $property->prom ?> m<sup>2</sup></h2>
                        <p>&nbsp;</p>
                        <p>Ønsker du å vite hva denne eiendommen ble solgt for?</p>
                        <p>&nbsp;</p>
                    </div>
                    <?php $form = ActiveForm::begin([
                        'id' => 'visningliste-form',
                        'fieldConfig' => [
                            'options' => [
                                'tag' => false
                            ],
                        ],
                        'options' => [
                            'class' => 'forms'
                        ]
                    ]); ?>
                    <div class="pop_lagre_ditt_sok_labels half-width icf_l">
                        <div class="frow">
                            <?= $form->field($model, 'phone')->textInput(['class' => 'styler', 'placeholder' => 'TELEFON'])->label(false); ?>
                        </div>
                        <div class="frow">
                            <?= $form->field($model, 'post_number')->textInput(['class' => 'styler', 'placeholder' => 'POSTNUMMER'])->label(false); ?>
                        </div>
                        <div class="frow">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'NAVN'])->label(false); ?>
                        </div>
                        <div class="frow">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'E-POST'])->label(false); ?>
                        </div>
                    </div>
                    <div class="icfb_l">
                        <div class="frow">
                            <label>
                                <?= $form->field($model, 'subscribe_email')
                                    ->checkbox(['class' => 'styler', 'label' => '<span>Jeg ønsker å motta eiendomsrelatert informasjon (nyhetsbrev o.l.) på e-post</span>'])
                                    ->label(false); ?>
                            </label>
                            <label>
                                <?= $form->field($model, 'i_agree')->checkbox([
                                    'class' => 'styler',
                                    'label' => '<span>Jeg har lest og godkjent <a href="/personvern">vilkårene</a></span>'
                                ])->label(false); ?>
                            </label>
                        </div>
                        <div class="frow">
                            <div class="icfb_btn">
                                <a href="#lagre_ditt_sok_result" style="display: none" class="popup" id="popup"></a>
                                <?= Html::submitButton('SEND', ['class' => 'btn btn_s btn_more']); ?>
                            </div>
                        </div>
                    </div>
                    <!-- Hidden inputs -->
                    <?= $form->field($model, 'type', ['errorOptions' => ['tag' => null]])
                        ->hiddenInput(['value' => 'salgssum_landing', 'class' => false])->label(false); ?>
                    <?= $form->field($model, 'target_id', ['errorOptions' => ['tag' => null]])->hiddenInput()->label(false); ?>
                    <?= $form->field($model, 'broker_id', ['errorOptions' => ['tag' => null]])->hiddenInput()->label(false); ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="col-md-3">
                <P>&nbsp;</p>
                <P>&nbsp;</p>
                <div class="vu_img"><?php if (!empty($property->user)):?>
                        <img src="<?= $property->user->urlstandardbilde; ?>" alt="<?= $property->user->navn ?>">
                    <?php endif;?>
                </div>
                <div class="vu_body">
                    <div class="vu_name"><?= strtoupper($broker->navn); ?></div>
                    <div class="vu_pos"><?= $broker->tittel; ?></div>
                    <div class="vu_phone">
                        <a href="tel:<?= $broker->mobiltelefon; ?>">+47 <?= $broker->mobiltelefon; ?></a><br/>
                        <a href="mailto:<?= $broker->email; ?>"><?= $broker->email; ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
