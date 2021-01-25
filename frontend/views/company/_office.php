<?php


use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $employer \common\models\User */
/* @var $department \common\models\Department */
/* @var $formModel \common\models\Forms */

$postnummer = $department->postnummer;
\common\components\Befaring::numFormat($postnummer);
$address = $department->besoksadresse.'A '.$postnummer.' '.$department->poststed;
?>
<div class="office">
    <div class="header">
        <h1><?= $department->short_name ?></h1>
        <h4><?= $address ?></h4>
        <h4><a href="tel:<?=$department->telefon ?>"><?= $department->telefon ?></a></h4>
        <h4><a href="mailto:<?=$department->email ?>"><?= $department->email ?></a></h4>
        <span>
            Schala & Partners <?= $department->short_name ?> er din lokale
            eiendomsmegler på <?= $department->part_of_city ?? $department->poststed ?>, og har bred
            erfaring med eiendomsmegling i området.
            Vi hjelper deg med å selge bolig og kjøpe bolig
            i Oslo. Klikk på eiendommer for å se hvilke
            boliger vi har til salgs i Oslo.
        </span>
        <br/><br/>
    </div>
    <div class="buttons">
        <button href="#verdivurdering" class="popup btn ">VERDIVURDERING</button>
    </div>
    <P>&nbsp;</p>
    <div class="office-info">
        <div>
        <strong>Avdelingsleder</strong><br />
            <?php if ($avdelingsleder = $department->director): ?>
                <h4><?= $avdelingsleder->navn ?></h4>
                    <a href="tel:<?= $avdelingsleder->mobiltelefon ?>"><?= $avdelingsleder->mobiltelefon ?></a><br>
                    <a href="mailto:<?= $avdelingsleder->email ?>"><?= $avdelingsleder->email ?></a>
                <br>
            <?php endif; ?>
        </div>
        <div>
        <strong>Fagansvarlig</strong><br />
            <?php if ($fagansvarlig = $department->authorized): ?>
                <h4><?= $fagansvarlig->navn ?></h4>
                    <a href="tel:<?= $fagansvarlig->mobiltelefon ?>"><?= $fagansvarlig->mobiltelefon ?></a><br>
                    <a href="mailto:<?= $fagansvarlig->email ?>"><?= $fagansvarlig->email ?></a>
                <br>
            <?php endif; ?>
        </div>
        <div>
            <h4>Oppgjør</h4>
            <a href="mailto:post@trygtoppgjor.no">post@trygtoppgjor.no</a>
        </div>

    </div>
    <?= \frontend\widgets\BrokersWidget::widget(['id' => $department->web_id, 'textHeader' => 'ANSATTE'])?>
    <?= \frontend\widgets\PropertyWidget::widget(['id' => $department->web_id, 'textHeader' => 'EIENDOMMER',  'office' => true])?>
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
            <div class = "hide">
                <?php
                // TODO: move all functions to controller
                $lradioLst = [];
                $employees = $department->getAnsatteUsers($department->web_id);

                foreach ($employees as $employer) {
                    $lradioLst[$employer->web_id] = $employer->web_id;
                }
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
            <?= $form->field($formModel, 'department_id', ['errorOptions' => ['tag' => null]])
                ->hiddenInput(['class' => false])->label(false) ?>
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