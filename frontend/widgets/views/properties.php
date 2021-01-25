<?php

/** @var $this yii\web\View */

use yii\helpers\StringHelper;

/** @var $properties common\models\PropertyDetails[] */
/** @var string $textHeader */

?>

<div id="office-properties" class="col-12 tac mt_50 mb_50">
    <h2><?= count($properties) ?><br><?= $textHeader ?></h2>
</div>

<div class="row">
    <?php foreach ($properties as $property): ?>
        <div class="col-12 col-md-6 col-xl-4">
            <div class="property-item portfolio_item mb_30" title="<?= $property->overskrift . ', ' . $property->adresse ?>">
                <a href="<?= $property->path() ?>">
                  <div class="box_img <?= $property->isSold() ? 'is-sold' : '' ?>">
                    <img src="https://via.placeholder.com/600x400/000000/848484/?text=Vennligst vent" data-src="<?= $property->posterPath() ?>" class="lazy" alt="<?= $property->title ?>">
                      <?php if ($property->isSold()): ?>
                        <img class="is-sold" src="/img/sold.png" alt="Solgt">
                      <?php endif ?>
                  </div>

                    <div class="box_text">
                        <div class="text-left d-flex align-items-start flex-column">
                            <?php if ($property->isOwnedSchalaPartners()): ?>
                                <h4 class="mb-auto"><?= StringHelper::truncate(ltrim($property->title . ', ' . $property->overskrift . ', ' . $property->adresse, ', '), 300) ?></h4>
                            <?php else: ?>
                                <h4 class="mb-auto"><?= StringHelper::truncate($property->overskrift . ', ' . $property->adresse, 350) ?></h4>
                            <?php endif ?>
                            <div class="box-text-bottoms">
                                <span class="property-price"><?= $property->getCost() ?></span>
                                <span class="property-desc">
                                    <?php if ($property->getProm()): ?><?= $property->getProm() ?> m<sup>2</sup>, <?php endif ?><?= $property->type_eiendomstyper ?><?php if ($property->soverom): ?>, <?= $property->soverom ?> soverom<?php endif ?>
                                </span>
                             </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
<?php endforeach ?>
</div>
