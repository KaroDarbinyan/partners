<?php
/** @var PropertyDetails $property */

/** @var string $sellers */

/** @var PropertyNeighbourhood[] $neighbours */

use common\components\Befaring;
use common\models\PropertyDetails;
use common\models\PropertyNeighbourhood;

$imgPath = '/img/befaring';
$this->title = 'BEFARING';

$postNumber = $property->postnummer;

$property->postnummer = Befaring::numFormat($postNumber);
?>

<div class="loader">
    <h3 class="loader__title"><?= $property->adresse ?></h3>
    <div class="loader__description">
        <?php if (!empty($sellers)): ?>
            <?= $sellers ?>
        <?php else: ?>
            <?= $property->department ? $property->department->short_name : '' ?>
        <?php endif ?>
    </div>
    <div class="loader__icons">
        <img src="<?= $imgPath ?>/icons/Group 1660.svg" alt="place">
        <img src="<?= $imgPath ?>/icons/Group 1661.svg" alt="sun">
        <img src="<?= $imgPath ?>/icons/Group 1655.svg" alt="byc">
        <img src="<?= $imgPath ?>/icons/Group 1706.svg" alt="bus">
        <img src="<?= $imgPath ?>/icons/Group 1656.svg" alt="tree">
        <img src="<?= $imgPath ?>/icons/Group 1707.svg" alt="gym">
        <img src="<?= $imgPath ?>/icons/Group 1677.svg" alt="diagramm">
        <img src="<?= $imgPath ?>/icons/Group 1659.svg" alt="eat">
    </div>
</div>

