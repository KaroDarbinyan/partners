<?php
/**
 * Created by PhpStorm.
 * User: FSW10
 * Date: 14.03.2019
 * Time: 15:16
 */
/** @var $this yii\web\View */
/** @var $properties common\models\Property */
/** @var $maxMin integer */
/** @var $maxMinArea array */
/** @var $price integer */
/** @var $propertiesData common\models\Property */
/** @var $filter_notification common\models\FilterNotification */
/** @var $types common\models\Property */
/** @var $areas array */
/** @var $typesOfOwnership array */
/** @var $count integer */

/** @var $archives boolean */

use common\widgets\SimplePagination;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJsFile('/js/eiendommer/compare.js?v=' . time(), [
    'depends' => AppAsset::className()
]);
$this->registerCssFile('/css/eiendommer/compare.css?v=' . time(), [
    'depends' => AppAsset::className()
]);

$this->title = 'Eiendomene til salgs, kjøpe eiendom';
/*$this->registerJs('
    $(document).ready(function(){
        $(".js-range-slider").ionRangeSlider({
            type: "double",
            grid: false,
            min: '. $maxMin['minColumn'] .',
            max: '. $maxMin['maxColumn'] .',
            from: '. $propertiesData['price']['start'] .',
            to: '. $propertiesData['price']['end'] .',
            input_values_separator: "-",
            step: 50,
            onFinish: function (data) {
                let startPrice = data.from;
                let endPrice = data.to;
                let urlString = \'startPrice=\'+ startPrice+ \'&endPrice=\' + endPrice;
                let url = window.location.search === \'\' ? \'?\' + urlString : window.location.search + \'&\' + urlString;
                window.location.href = window.location.pathname + url;
            }
        });
    });
', View::POS_END);*/

?>


<div class="main">
    <div class="ic_body">
        <h1><?= Yii::$app->view->params['header'] ?></h1>
    </div>
    <form class="filter_form" action="/eiendommer" method="get">
        <input type="hidden" id="is_archives" value="<?= $archives ?>">
        <div class="range_and_count has-filters">
            <div class="filtered_data_count">
                Antall : <strong><span
                            data-filtered-count="count"><?= $propertiesData['count']; ?></span></strong><strong><span><?= " / {$count}"; ?></span></strong>
            </div>
            <div class="filter_range_price">
                <input type="hidden" class="js-range-slider" name="range_price" value=""
                       data-type="double"
                       data-grid="false"
                       data-min="<?= $maxMin['minColumn'] ?>"
                       data-max="<?= $maxMin['maxColumn'] ?>"
                       data-from="<?= $propertiesData['price']['start'] ?>"
                       data-to="<?= $propertiesData['price']['end'] ?>"
                       data-input-values-separator="-"
                       data-max-postfix="+"
                       data-from-name="startPrice"
                       data-to-name="endPrice"
                       data-cleaner-from="PRIS FRA"
                       data-cleaner-to="PRIS TIL"
                       data-step="100000"/>
                <div class="range_label">
                    <span>PRIS FRA</span>
                    <span>PRIS TIL</span>
                </div>
            </div>
            <div class="filter_range_price">
                <input type="hidden" class="js-range-slider" name="range_area" value=""
                       data-type="double"
                       data-grid="false"
                       data-min="<?= $maxMinArea['minArea'] ?>"
                       data-max="<?= $maxMinArea['maxArea'] ?>"
                       data-from="<?= $propertiesData['area']['start'] ?>"
                       data-to="<?= $propertiesData['area']['end'] ?>"
                       data-input-values-separator="-"
                       data-max-postfix="+"
                       data-from-name="startArea"
                       data-to-name="endArea"
                       data-cleaner-from="KVM FRA"
                       data-cleaner-to="KVM TIL"
                       data-step="10"/>
                <div class="range_label">
                    <span>KVM FRA</span>
                    <span>KVM TIL</span>
                </div>
            </div>
        </div>
        <div class="f_checks">
            <div class="fc_column has-filters">
                <div class="fc_val">
                    <div class="header-div">OMRÅDE</div>
                    <ul class="fc_values">
                        <?php foreach ($areas as $key => $val): ?>
                            <li>
                                <label class="omrade-parent" data-omrade-name="<?= $val['omrade']; ?>">
                                    <input type="checkbox" class="styler omrade-p" name="parent_area[]"
                                           data-cleaner-title="OMRÅDE"
                                           value="<?= $val['omrade']; ?>"
                                           <?= isset($type['checked']) ? 'checked' : '' ?>>
                                    <span><?= "{$val['omrade']} ({$val['count']})"; ?></span>
                                </label>
                                <ul>
                                    <?php foreach ($val['area'] as $k => $v): ?>
                                        <li>
                                            <label class="omrade-child" data-parent-name="<?= trim($val['omrade']); ?>">
                                                <input type="checkbox" class="styler omrade-c" name="area[]"
                                                       data-cleaner-title="<?= trim($val['omrade']); ?>"
                                                       value="<?= trim($k); ?>">
                                                <span><?= trim($k) . " ({$v})"; ?></span>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="fc_column has-filters">
                <div class="fc_val">
                    <div class="header-div">TYPE HJEM</div>
                    <ul class="fc_values">
                        <?php foreach ($types as $typeKey => $type): ?>
                            <li>
                                <label>
                                    <input type="checkbox" <?= isset($type['checked']) ? 'checked' : '' ?>
                                           class="styler" name="homeType[]" data-cleaner-title="TYPE HJEM"
                                           value="<?= $typeKey ?>"/>
                                    <span>
                                    <?= $typeKey ?>
                                </span>
                                </label>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="fc_column has-filters">
                <div class="fc_val">
                    <div class="header-div">Eierform</div>
                    <ul class="fc_values">
                        <?php foreach ($typesOfOwnership as $key => $val): ?>
                            <li>
                                <label>
                                    <input type="checkbox" class="styler" name="eierform[]"
                                           data-cleaner-title="Eierform"
                                           value="<?= $key ?>" <?= isset($type['checked']) ? 'checked' : '' ?>>
                                    <span><?= $key ?></span>
                                </label>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="fc_column has-filters">
                <div class="fc_val">
                    <div class="header-div">SOVEROM</div>
                    <ul class="fc_values">
                        <?php $roomsCnt = 6;
                        for ($i = 1; $i < $roomsCnt + 1; $i++):?>
                            <li><label><input type="checkbox" class="styler"
                                              name="roomsCounts[]"
                                              value="<?= $i ?>"
                                              data-cleaner-title="SOVEROM"
                                    /><span><?= $i . ($i == $roomsCnt ? '+' : '') ?></span></label>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </div>
            </div>

            <?php if (false): ?>
                <div class="fc_column">
                    <div class="header-div">FASILITETER</div>
                    <div class="fc_val">
                        <div class="header-div">FASILITETER</div>
                        <ul class="fc_values">
                            <li><label><input type="checkbox" class="styler" name="fasiliteter[]" value="FASILITETER"/>
                                    <span>FASILITETER</span></label></li>
                            <li><label><input type="checkbox" class="styler" name="fasiliteter[]" value="FASILITETER"/>
                                    <span>FASILITETER</span></label></li>
                            <li><label><input type="checkbox" class="styler" name="fasiliteter[]" value="FASILITETER"/>
                                    <span>FASILITETER</span></label></li>
                            <li><label><input type="checkbox" class="styler" name="fasiliteter[]" value="FASILITETER"/>
                                    <span>FASILITETER</span></label></li>
                            <li><label><input type="checkbox" class="styler" name="fasiliteter[]" value="FASILITETER"/>
                                    <span>FASILITETER</span></label></li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="filter-cleaners btn-group-sm"></div>
    </form>
</div>

<div id="compare-modal"></div>
<div class="container fade" id="compare-collapse">
    <div class="fc_column has-filters">
        <div class="fc_val">
            <div class="header-div collapse-toggle">
                <span class="pull-left">produkter</span>
                <button type="button" disabled class="pull-right fade" id="sammenlign">sammenlign<span id="compare-count">0</span></button>
            </div>
            <div id="collapse-body" class="panel-collapse"></div>
        </div>
    </div>
</div>
<ul class="listing" id="listing" data-building-cards="building">
    <?= $this->render('building-card', [
        'properties' => $propertiesData['properties'],
        'pages' => $propertiesData['pages']
    ]) ?>
</ul>

<?php // Uncomment whet load more will work correctly ?>
<!--
<div class="listing_more">
    <button class="btn btn_s" data-building-load-more="more-building">
        Vis mer
    </button>
</div>-->

<!--<div class="listing_more">
    <a href="#lagre_ditt_sok" class="btn btn_s popup">LAGRE DITT SØK</a>
</div>-->
<div class="hidden">
    <input type="hidden" value="" data-hidden-filter="filter">
</div>
<div class="hide">
    <div class="pop lagre_ditt_sok" id="lagre_ditt_sok">
        <?php
        $form = ActiveForm::begin([
            'action' => false,
            'id' => 'filter-notification',
            'enableAjaxValidation' => true,
            'fieldConfig' => [
                'options' => [
                    'tag' => false,
                ],
            ],
        ]); ?>
        <div class="pop_lagre_ditt_sok_labels">
            <div class="frow">
                <?= $form->field($filter_notification, 'phone')->textInput([
                    'class' => 'styler inp_s',
                    'placeholder' => 'TELEFON'
                ])->label(false); ?>
                <?= $form->field($filter_notification, 'url')
                    ->hiddenInput(['value' => 'url', 'class' => false])->label(false); ?>
            </div>
            <div class="frow">
                <?= $form->field($filter_notification, 'surname')->textInput([
                    'class' => 'styler inp_s',
                    'maxlength' => true,
                    'placeholder' => 'ETTERNAVN'
                ])->label(false); ?>
            </div>
            <div class="frow">
                <?= $form->field($filter_notification, 'email')->textInput([
                    'class' => 'styler inp_s',
                    'maxlength' => true,
                    'placeholder' => 'E-POST'
                ])->label(false); ?>
            </div>
            <div class="frow">
                <?= $form->field($filter_notification, 'name')
                    ->textInput([
                        'class' => 'styler inp_s',
                        'maxlength' => true,
                        'placeholder' => 'NAVN'
                    ])->label(false); ?>
            </div>
            <div class="frow">
                <?= $form->field($filter_notification, 'post_number')->textInput([
                    'class' => 'styler inp_s',
                    'placeholder' => 'POSTNUMMER'
                ])->label(false); ?>
            </div>
            <div class="frow">
                <a href="#lagre_ditt_sok_result" style="display: none" class="popup" id="popup"></a>
                <?= Html::submitButton('LAGRE SØK', ['class' => 'btn btn_more btn_s']) ?>
            </div>
        </div>

        <div class="pop_info">Du blir varslet på e-post, i appen på mobil og her på Schala.</div>
        <div class="frow">
            <?= $form->field($filter_notification, 'i_agree')
                ->checkbox(['class' => 'styler', 'label' => '<span>Ja takk, varsle meg om nye treff!</span>'])->label(false) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="pop" id="lagre_ditt_sok_result">
        <form>
            <div class="iTAKK"></div>
            <div class="it_title">TAKK!</div>
            <div class="it_info">Du blir varslet på e-post, i appen på mobil og her på Schala.</div>
        </form>
    </div>

</div>
