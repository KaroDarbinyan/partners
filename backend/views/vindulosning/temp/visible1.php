<?php


use common\models\PropertyDetails;
use yii\helpers\Html;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $properties PropertyDetails[] */

?>

<?php foreach ($properties as $property): ?>
    <div class="col-12 col-md-4 mb-5 <?= ($property->is_visible == 1) ? "" : "checked"; ?>">
        <input type="checkbox" <?= ($property->is_visible == 1) ? "checked" : ""; ?>
               data-property-id="<?= $property->id; ?>"
               class="position-relative float-right"
               style="top: 20px; right: 5px;">
        <?= Html::img($property->posterPath(), ["class" => "w-100 property"]); ?>
        <?php if ($property->isSold()): ?>
            <img class="solgt" src="https://partners.no/img/sold.png" alt="Solgt">
        <?php endif ?>
        <div class="text-left d-flex align-items-start flex-column bg-dark p-3">
            <?php if ($property->isOwnedSchalaPartners()): ?>
                <h4 class="mb-auto"><?= StringHelper::truncate(ltrim("{$property->title}, {$property->overskrift}, {$property->adresse}", ', '), 300) ?></h4>
            <?php else: ?>
                <h4 class="mb-auto"><?= StringHelper::truncate("{$property->overskrift}, {$property->adresse}", 350) ?></h4>
            <?php endif ?>
            <div class="box-text-bottoms mt-3">
                <span class="property-price"><?= $property->getCost() ?></span>
                <span class="property-desc">
                    <?= $property->getProm() ? "{$property->getProm()} m<sup>2</sup>," : ""; ?>
                    <?= $property->type_eiendomstyper ?>
                    <?= $property->soverom ? "{$property->soverom} soverom" : ""; ?>
                </span>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="col-md-12">
    <button class="btn btn-success disabled" disabled="disabled" id="property-visible-btn">Save</button>
</div>
