<?php
/** @var $this yii\web\View */
/** @var $maxMin integer */
/** @var $maxMinArea array */
/** @var $price integer */
/** @var $areas array */
/** @var $typesOfOwnership array */
/** @var $roomCounts array */
/** @var $count integer */
/** @var $archives boolean */
/** @var $propertiesData array */

$this->title = 'Eiendomene til salgs, kjøpe eiendom';
?>

<div class="main">
    <div class="ic_body">
        <h1><?= Yii::$app->view->params['header'] ?></h1>
    </div>
    <form class="filter_form" action="/eiendommer" method="get">
        <input type="hidden" id="is_archives" value="<?= $archives ?>">
        <div class="range_and_count has-filters">
            <div class="filtered_data_count">
                Antall :  <strong><span data-filtered-count="count"><?= $propertiesData['count']; ?></span></strong><strong><span><?= " / {$count}"; ?></span></strong>
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
                                           value="<?= $val['omrade']; ?>" <?= isset($val['checked']) ? 'checked' : '' ?>>
                                    <span><?= "{$val['omrade']} ({$val['count']})"; ?></span>
                                </label>
                                <ul <?= isset($val['checked']) ? 'style="display: block"' : '' ?>>
                                    <?php foreach ($val['area'] as $k => $v): ?>
                                        <li>
                                            <label class="omrade-child" data-parent-name="<?= trim($val['omrade']); ?>">
                                                <input type="checkbox" <?= isset($v['checked']) ? 'checked' : '' ?>
                                                       class="styler omrade-c"  name="area[]"
                                                       data-cleaner-title="<?= trim($val['omrade']); ?>"
                                                       value="<?= trim($k); ?>">
                                                <span><?= trim($k) ?> (<?= isset($v['count']) ? $v['count'] : $v ?>)</span>
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
                                           class="styler" name="homeType[]" data-cleaner-title="TYPE HJEM" value="<?= $typeKey ?>"/>
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
                                           value="<?= $key ?>" <?= isset($val['checked']) ? 'checked' : '' ?>>
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
                        <?php foreach ($roomCounts as $key => $value): ?>
                            <li>
                                <label><input type="checkbox" class="styler"
                                              name="roomsCounts[]"
                                              value="<?= $key ?>"
                                              data-cleaner-title="SOVEROM" <?= isset($value['checked']) ? 'checked' : '' ?>
                                    /><span><?= $key ?></span></label>
                            </li>
                        <?php endforeach ?>
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

<div class="hidden">
    <input type="hidden" value="" data-hidden-filter="filter">
</div>
