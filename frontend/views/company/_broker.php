<?php


use frontend\widgets\BrokersWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $employer \common\models\User */
/* @var $department \common\models\Department */
/* @var $properties \common\models\Property[] */
$department  = $employer->department;
$postnummer = $department->postnummer;
\common\components\Befaring::numFormat($postnummer);
$address = $department->besoksadresse.'A '.$postnummer.' '.$department->poststed;
?>

<div class="broker">
    <div class="broker-header">
        <div class="align-right">
            <img src="<?= $employer->urlstandardbilde; ?>"
                  alt="<?= $employer->navn; ?>">
        </div>
        <div class="header-left">
            <h1 style="text-transform: uppercase;"><?= $employer->navn?></h1>
            <h4><?= $employer->tittel ?></h4>
            <h4 > <a href="mailto:<?=$employer->email ?>"><?= $employer->email ?></a></h4>
            <h4 > <a href="tel:<?=$employer->mobiltelefon ?>"><?= $employer->mobiltelefon ?></a></h4>
            <p>&nbsp;</p>
            <h2>Kontor: <span  style="text-transform: uppercase;"><?= $department->short_name ?></span></h2>
            <h4> <?= $address?></h4>
            <h4> <?= $department->telefon? $department->telefon: ''?></h4>
            <p>&nbsp;</p>

            <label
                data-check-target = "<?= "__broker_{$employer->web_id}" ?>"
                for="<?= "__broker_{$employer->web_id}" ?>"
                href="#kontakt-meg"
                class="popup btn "
            >KONTAKT MEG</label>
            <a style="cursor: pointer"
               href="#verdivurdering"
               class="popup btn "
            >Verdivurdering</a>
        </div>

    </div>
    <div class="broker-body">
        <?= \frontend\widgets\PropertyWidget::widget(['id' => $employer->web_id, 'textHeader' => 'LEILIGHETER'])?>
        <br>
        <?= BrokersWidget::widget([
            'id' => $department->web_id,
            'textHeader' => 'KOLLEGAER',
            'except' => [$employer->web_id]
        ]) ?>
    </div>
<div class="hidden">
    <input type="hidden" value="" data-hidden-filter="filter">
</div>
<div class="hide">
    <div class="pop lagre_ditt_sok padd-30" id="kontakt-meg">
        <div class="">
            <div class="tb_title">KONTAKT MEG</div>
            <?php $form = ActiveForm::begin([
                'id' => 'k-form',
                'fieldConfig' => [
                    'options' => [
                        'tag' => false
                    ],
                ],
                'options' => [
                    'class' => 'ic_form forms'
                ]
            ]); ?>
            <div class="icf_l full-width">
                <div class="frow">
                    <?= $form->field($formModel, 'phone')
                        ->textInput(['class' => 'styler', 'placeholder' => 'Telefon'])->label(false) ?>
                </div>
                <div class="frow">
                    <?= $form->field($formModel, 'post_number')
                        ->textInput(['class' => 'styler', 'placeholder' => 'Postnummer'])->label(false) ?>
                </div>
                <div class="frow">
                    <?= $form->field($formModel, 'name')
                        ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'Navn'])->label(false) ?>
                </div>
                <div class="frow">
                    <?= $form->field($formModel, 'email')
                        ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'E-post'])->label(false) ?>
                </div>
                <div class="frow">
                    <?= $form->field($formModel, 'message')
                        ->textarea(['rows' => 6, 'class' => 'styler', 'placeholder' => 'Melding'])->label(false) ?>
                </div>

                <div class="frow">
                    <?= $form->field($formModel, 'subscribe_email')
                        ->checkbox(['class' => 'styler', 'label' => '<span>Jeg ønsker å motta eiendomsrelatert informasjon (nyhetsbrev o.l.) på e-post</span>'])
                        ->label(false) ?>
                </div>
                <div class="frow">
                    <?= $form->field($formModel, 'i_agree')
                        ->checkbox(['class' => 'styler', 'label' => '<span>Jeg har lest og godkjent <a href="/personvern" target="_blank">vilkårene</a></span>'])->label(false) ?>
                </div>
                <div class="frow">
                    <a href="#lagre_ditt_sok_result" style="display: none" class="popup" id="popup"></a>
                    <?= Html::submitButton('SEND', ['class' => 'btn btn_s btn_more']) ?>
                </div>
            </div>

            <!--Hidden Inputs-->
            <div class="hide" >
                <?php
                $lradioLst = BrokersWidget::$ids;
                $lradioLst[$employer->web_id] = $employer->web_id;
                ?>
                <?= $form->field($formModel, 'broker_id')
                    ->radioList($lradioLst,
                        [
                            'item' => function($index, $label, $name, $checked, $value) {
                                return "<input id = '__broker_{$value}' type='radio' name='{$name}' value='{$value}'>";
                            }
                        ]
                    )
                ?>
            </div>
            <?= $form->field($formModel, 'type', ['errorOptions' => ['tag' => null]])
                ->hiddenInput(['value' => 'kontakt_broker', 'class' => false])->label(false) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="pop lagre_ditt_sok padd-30" id="verdivurdering">
        <div class="">
            <div class="tb_title">VERDIVURDERING</div>
            <?php $form = ActiveForm::begin([
                'id' => 'v-form',
                'fieldConfig' => [
                    'options' => [
                        'tag' => false
                    ],
                ],
                'options' => [
                    'class' => 'ic_form forms'
                ]
            ]); ?>
            <div class="icf_l full-width">
                <div class="frow">
                    <?= $form->field($formModel, 'phone')
                        ->textInput(['class' => 'styler', 'placeholder' => 'Telefon'])->label(false) ?>
                </div>
                <div class="frow">
                    <?= $form->field($formModel, 'post_number')
                        ->textInput(['class' => 'styler', 'placeholder' => 'Postnummer'])->label(false) ?>
                </div>
                <div class="frow">
                    <?= $form->field($formModel, 'name')
                        ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'Navn'])->label(false) ?>
                </div>
                <div class="frow">
                    <?= $form->field($formModel, 'email')
                        ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'E-post'])->label(false) ?>
                </div>
                <!-- <div class="frow">
                    <? /*= $form->field($formModel, 'message')
                        ->textarea(['rows' => 6, 'class' => 'styler', 'placeholder' => 'Melding'])->label(false) */ ?>
                </div>-->
                <div class="frow">
                    <?= $form->field($formModel, 'subscribe_email')
                        ->checkbox(['class' => 'styler', 'label' => '<span>Jeg ønsker å motta eiendomsrelatert informasjon (nyhetsbrev o.l.) på e-post</span>'])
                        ->label(false) ?>
                </div>
                <div class="frow">
                    <?= $form->field($formModel, 'i_agree')
                        ->checkbox(['class' => 'styler', 'label' => '<span>Jeg har lest og godkjent <a href="/personvern" target="_blank">vilkårene</a></span>'])->label(false) ?>
                </div>
                <div class="frow">
                    <a href="#lagre_ditt_sok_result" style="display: none" class="popup" id="popup"></a>
                    <?= Html::submitButton('SEND', ['class' => 'btn btn_s btn_more']) ?>
                </div>
            </div>

            <!--Hidden inputs -->
            <?= $form->field($formModel, 'type', ['errorOptions' => ['tag' => null]])
                ->hiddenInput(['value' => 'verdivurdering', 'class' => false])->label(false) ?>
            <?= $form->field($formModel, 'broker_id', ['errorOptions' => ['tag' => null]])
                ->hiddenInput(['value' => $employer->web_id, 'class' => false])->label(false) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="pop" id="lagre_ditt_sok_result">
        <form>
            <div class="iTAKK"></div>
            <div class="it_title">TAKK!</div>
            <div class="it_info">Du blir varslet på e-post, i appen på mobil og her på Schala.</div>
        </form>
    </div>

</div>