<?php

use common\models\PropertyDetails;
use common\models\Vindulosning;
use frontend\widgets\BootstrapLinkPager;
use yii\bootstrap\Html;
use yii\data\Pagination;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $maxMin integer */
/* @var $maxMinArea array */
/* @var $price integer */
/* @var $areas array */
/* @var $typesOfOwnership array */
/* @var $roomCounts array */
/* @var $count integer */
/* @var $archives boolean */
/* @var $propertiesData array */
/* @var $this yii\web\View */
/* @var $properties PropertyDetails[] */
/* @var $pages Pagination */
/* @var $newBuildings bool */
/* @var $vindulosning Vindulosning */

$this->title = 'Eiendomene til salgs, kjøpe eiendom';

?>


<?php $this->beginBlock('advertising'); ?>
<section class="section_block">
    <div class="container ">
        <div class="row">
            <div id="properties-list" class="col-12 col-lg-12">
                <div class="row">
                    <?php foreach ($propertiesData["properties"] as $property): ?>
                        <div class="col-12 col-md-<?= $vindulosning->column; ?>">
                            <div class="property-item portfolio_item mb_30"
                                 title="<?= $property->overskrift . ', ' . $property->adresse ?>">
                                <a href="<?= $property->path() ?>">
                                    <div class="box_img w-100 h-auto <?= $property->isSold() ? 'is-sold' : '' ?>">
                                        <?php if ($property->isSold()): ?>
                                            <img src="/img/sold.png" alt="Solgt" class="is-sold">
                                        <?php endif ?>
                                        <?= Html::img($property->posterPath('720x')); ?>
                                    </div>

                                    <div class="box_text" style="height: unset !important;">
                                        <div class="text-left d-flex align-items-start flex-column">
                                            <?php if ($property->isOwnedSchalaPartners()): ?>
                                                <h4 class="mb-auto"><?= StringHelper::truncate(ltrim($property->title . ', ' . $property->overskrift . ', ' . $property->adresse, ', '), 300) ?></h4>
                                            <?php else: ?>
                                                <h4 class="mb-auto"><?= StringHelper::truncate($property->overskrift . ', ' . $property->adresse, 350) ?></h4>
                                            <?php endif ?>
                                            <div class="box-text-bottoms">
                                                <span class="property-price"><?= $property->getCost() ?></span>
                                                <span class="property-desc">
                                    <?php if ($property->getProm()): ?><?= $property->getProm() ?> m
                                        <sup>2</sup>, <?php endif ?><?= $property->type_eiendomstyper ?><?php if ($property->soverom): ?>, <?= $property->soverom ?> soverom<?php endif ?>
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endforeach ?>

                    <div class="col-12">
                        <?= $vindulosning->id ? "" : BootstrapLinkPager::widget(['pagination' => $propertiesData["pages"]]) ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<?php $this->endBlock() ?>
