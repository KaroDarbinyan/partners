<?php

use frontend\widgets\BootstrapLinkPager;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $properties \common\models\PropertyDetails[] */
/* @var $pages \yii\data\Pagination */
/* @var $newBuildings bool */

?>

<div class="row">
    <?php foreach ($properties as $property): ?>
      <div class="col-12 col-md-6">
        <div class="property-item portfolio_item mb_30"
             title="<?= $property->overskrift . ', ' . $property->adresse ?>">
          <a href="<?= $property->path() ?>">
            <div class="box_img <?= $property->isSold() ? 'is-sold' : '' ?>">
              <img src="https://via.placeholder.com/600x400/000000/848484/?text=Vennligst vent"
                   data-src="<?= $property->posterPath() ?>" class="lazy" alt="<?= $property->title ?>">
                <?php if ($property->isSold()): ?>
                  <img class="is-sold" src="/img/sold.png" alt="Solgt">
                <?php endif ?>
                <?php if ($property->has360View()): ?>
                  <a href="<?= $property->path() ?>#360-view">
                    <img src="/img/360view.svg" alt="360 View" class="is-360-view">
                  </a>
                <?php endif ?>
            </div>

            <div class="box_text">
              <div class="text-left d-flex align-items-start flex-column">
                <h4 class="mb-auto"><?= StringHelper::truncate(ltrim($property->getTitle() . ', ' . $property->overskrift . ', ' . $property->adresse, ', '), 300) ?></h4>
                <div class="box-text-bottoms">
                  <span class="property-price"><?= $property->getCost() ?></span>
                  <span class="property-desc">
                                    <?php if ($property->area_real): ?><?= number_format($property->area_real, 0, ' ', ' ') ?> m
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
      <?= BootstrapLinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 6]) ?>
  </div>
</div>
