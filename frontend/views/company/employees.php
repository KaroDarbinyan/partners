<?php


use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\components\CdnComponent;

/* @var $this \yii\web\View */
/* @var $employer \common\models\User */
/* @var $departments \common\models\Department */
/* @var $department \common\models\Department */
/* @var $formModel \common\models\Forms */

$this->registerJs("
    $('html, body').animate({
        scrollTop: ($('.ansatte-choosen').offset().top-80)
    },500);");


?>

<div class="main">

    <?php foreach ($departments as $key => $department):
        $employees = $department->getAnsatteUsers($department->web_id);
        $urlOffice = \common\components\Befaring::strReplace($department->short_name, '/', '$');
        $urlOffice = 'office/'.$urlOffice;
        ?>
            <div class="row <?= Yii::$app->request->get('id') == $department->id ? 'ansatte-choosen' : ''; ?>"
                 id="<?= $department->web_id ?>" style="margin-bottom: 30px">
                <div class="col-md-4">
                    <a href="<?= $urlOffice ?>">
                        <h1 class="office-title"><?= $department->short_name; ?></h1>
                    </a>
                    <div class="apk_c">
                        <a href="mailto:ed@partners.no"><?= $department->email ?></a><br>
                        <?php if (!is_null($department->telefon)) : ?>
                            <a href="tel:<?= $department->telefon ?>">+47 <?= $department->telefon ?></a> (telefon)<br>
                            <?php if ($department->telefax): ?>
                                +47 <?= $department->telefax ?> (faks)<br>
                            <?php endif; ?>
                        <?php endif ?>
                        <?= $department->besoksadresse ?>
                    </div>

                    <br>
                    <h4>Oppgjør</h4>
                    <a href="mailto:post@trygtoppgjor.no">post@trygtoppgjor.no</a>
                    <br>
                    <br>

                    <?php if ($director = $department->director): ?>
                        <h4><?= $director->navn ?></h4>
                        Avdelingsleder<br/>
                        <a href="tel:<?= $director->mobiltelefon ?>"><?= $director->mobiltelefon ?></a><br>
                        <a href="mailto:<?= $director->email ?>"><?= $director->email ?></a>
                        <br>
                    <?php endif; ?>

                    <div class="apk_more">
                        <?php $str_replace = str_replace([' / ', ' ', '/'], '_', $department->short_name); ?>
                        <label
                                data-check-target = "<?= "__department_{$department->web_id}" ?>"
                                for="<?= "__department_{$department->web_id}" ?>"
                                href="#verdivurdering"
                                class="popup btn btn_ss btn_more"
                        >
                            Verdivurdering
                        </label>
                    </div>
                    <div class="apk_desc">
                        <div class="ansatte-choosen-kontor">
                            <?= Yii::$app->request->get('id') == $department->id ? 'Ditt nærmeste kontor' : ''; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 tab_blocks_center">
                    <ul class="tb_val">
                        <li class="active">
                            <div class="row list_j_users">
                                <?php foreach ($employees as $employer):
                                    $urlEm = '/ansatte/'.\common\components\Befaring::strReplace($employer->navn);
                                    ?>
                                    <div class="col-md-3">
                                        <div class="vu_img">
                                            <a href="<?= $urlEm?>">
                                                <img src="<?= CdnComponent::optimizedUrl($employer->urlstandardbilde); ?>"
                                                     alt="<?= $employer->navn; ?>">
                                            </a></div>
                                        <div class="vu_body">
                                            <div class="vu_name"><?= $employer->navn ?></div>
                                            <div class="vu_pos"><?= $employer->tittel ?></div>
                                            <div class="vu_phone">
                                                <?php if ($employer->mobiltelefon): ?>
                                                    <a href="tel:<?= $employer->mobiltelefon ?>">
                                                        <?= $employer->mobiltelefon ?>
                                                    </a>
                                                    <br/>
                                                <?php endif; ?>
                                                <?php if ($employer->email): ?>
                                                    <a href="mailto:<?= $employer->email ?>">
                                                        <?= $employer->email ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="vu_contact">
                                                <label
                                                    data-check-target = "<?= "__broker_{$employer->web_id}" ?>"
                                                    for="<?= "__broker_{$employer->web_id}" ?>"
                                                    href="#kontakt-meg"
                                                    class="popup btn btn_ss btn_more"
                                                >
                                                    KONTAKT MEG
                                                </label>

                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
    <?php endforeach; ?>
    <div class="center padding50">
        <a href="/prisliste-schala-partners.doc" class="btn btn_ss" style="margin-bottom: 20px">LAST NED PRISLISTE</a>
    </div>
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
                $lradioLst = [];
                foreach ($departments as $key => $department) {
                    $employees = $department->getAnsatteUsers($department->web_id);

                    foreach ($employees as $employer) {
                        $lradioLst[$employer->web_id] = $employer->web_id;
                    }
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
                    <?php /*= $form->field($formModel, 'message')
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
            <div class = "hide">
                <?php
                $radioLst = [];
                foreach ($departments as $key => $department) {
                    $radioLst[$department->web_id] = $department->web_id;
                }
                ?>
                <?= $form->field($formModel, 'department_id')
                    ->radioList(
                        $radioLst,
                        [
                            'item' => function ($index, $label, $name, $checked, $value) {
                                return "<input id = '__department_{$value}' type='radio' name='{$name}' value='{$value}'>";
                            }
                        ]
                    )
                ?>
            </div>
            <?= $form->field($formModel, 'type', ['errorOptions' => ['tag' => null]])
                ->hiddenInput(['value' => 'verdivurdering', 'class' => false])->label(false) ?>
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
