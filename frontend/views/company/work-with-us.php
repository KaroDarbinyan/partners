<?php
/* @var $this \yii\web\View */

/* @var $directors \common\models\User */
/* @var $dataProvider \common\models\LedigeStillinger[] */
/* @var $formModel \common\models\Forms */

use common\models\Department;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

?>

<div class="content main">
    <h1><?= Yii::$app->view->params['header'] ?></h1>
    <div class="row">
        <div class="col-md-4">
            <div class="ic_body">
                <div class="join_desc">
                    <h3>VI SØKER</h3>
                    <p>- og har ALLTID plass til personer som virkelig ønsker å lykkes i bransjen vår! </p>
                    <p>Enten du har ambisjoner om å bli partner, drive eget kontor, om du er en toppmegler, eller ønsker å
                        bli det – hos oss kan du vokse enda mer og få ut ditt fulle potensiale.</p>
                    <p>For oss er de beste meglerne trivelige, effektive og ambisiøse folk, som opptrer ryddig. Vi har det
                        dyreste folk eier i vår varetekt – og det tar vi på alvor. Hos oss tar meglerne hverandre med på
                        befaringer, visninger, kontraktsmøter eller hva det måtte være – så vi lærer av hverandre. Ingen er
                        så dyktig at de ikke kan bli bedre. </p>
                    <p>Vi lever etter vårt eget slagord: Schala & Partners – Eiendomsmegleren du anbefaler videre.</p>
                    <p><em><strong>Alle henvendelser behandles konfidensielt.</strong></em></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="jt_r">
                <div class="tab_blocks in_join_team">
                    <ul class="tb_nav">
                        <li class="active"><a href="">LEDIGE STILLINGER</a></li>
                        <li><a href="">KONTAKTPERSONER</a></li>
                        <li><a data-check-target="__broker_3000216"
                               href="#kontakt-meg"
                               class="popup not_tab">KONTAKT OSS</a></li>
                    </ul>
                    <ul class="tb_val">
                        <li class="active">
                            <div class="ledige_stillinger">
                                <div class="lh">
                                    <div>TITTEL</div>
                                    <div>KONTOR</div>
                                    <div>FRIST</div>
                                </div>
                                <?php foreach ($dataProvider as $item):?>
                                    <div >
                                        <div><?= $item->title ?></div>
                                        <div><?= $item->department? $item->department->short_name : '' ?></div>
                                        <div><?= $item->showDate() ?></div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </li>
                        <li>

                            <div class="row list_j_users">
                                <?php /** @var \common\models\User $director */
                                foreach ($directors as $director) { ?>
                                    <div class="col-md-4">
                                        <div class="vu_img">
                                            <img src="<?= $director->urlstandardbilde ?>" alt=""></div>
                                        <div class="vu_body">
                                            <div class="vu_name"><?= $director->navn ?></div>
                                            <div class="vu_pos"><?= $director->tittel ?></div>
                                            <div class="vu_phone">
                                                <a href="tel:+<?= $director->mobiltelefon ?>">
                                                    <?= $director->mobiltelefon ?>    
                                                </a>
                                                <br/>
                                                <a href="mailto:<?= $director->email ?>">
                                                    <?= $director->email ?>
                                                </a>
                                            </div>
                                            <div class="vu_contact">
                                                <a
                                                    data-check-target = "<?= "__broker_{$director->web_id}" ?>"
                                                    href="#kontakt-meg"
                                                    class="popup btn btn_ss btn_more"
                                                >KONTAKT MEG</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
                                </div>

<div class="hidden">
    <input type="hidden" value="" data-hidden-filter="filter">
</div>
<div class="hide">


    <div class="pop lagre_ditt_sok padd-30" id="kontakt-meg">
        <div class="">
            <div class="tb_title">KONTAKT OSS</div>
            <?php $form = ActiveForm::begin([
                'enableClientScript' => false,
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
            <div class = "hide">
                <?php
                $lradioLst = [];
                foreach ($directors as $employer) {
                    $lradioLst[$employer->web_id] = $employer->web_id;
                }
                ?>
                <?= $form->field($formModel, 'broker_id')
                    ->radioList(
                        $lradioLst,
                        [
                            'item' => function ($index, $label, $name, $checked, $value) {
                                return "<input id = '__broker_{$value}' type='radio' name='{$name}' value='{$value}'>";
                            }
                        ]
                    )
                ?>
            </div>


            <?= $form->field($formModel, 'type', ['errorOptions' => ['tag' => null]])
                ->hiddenInput(['value' => 'jobb', 'class' => false])->label(false) ?>
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

