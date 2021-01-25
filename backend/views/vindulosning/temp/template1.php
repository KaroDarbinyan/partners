<?php


use common\models\PartnerSettings;
use common\models\PropertyDetails;

/* @var $this yii\web\View */
/* @var $properties PropertyDetails[] */
/* @var $partnerSettings PartnerSettings */


$viewOptions = [
    "list" => "List",
    "carousel" => "Carousel"
];


$cardCountOptions = [
    4 => 3,
    3 => 4,
    6 => 2
];

$viewSelected =  "list";
$cardCountSelected = 4;

if ($partnerSettings) {
    $property_view = json_decode($partnerSettings["property_view"], true);
    $viewSelected = $property_view["view"];
    $cardCountSelected = intval($property_view["col_num"]);
}



?>

<div class="col-md-12">
    <div class="row">
        <div class="col-md-3">
            <h4>View</h4>
            <select class="selectpicker" data-style="tl-select" id="view">
                <?php foreach ($viewOptions as $k => $v): ?>
                    <option <?= $k === $viewSelected ? "selected" : ""; ?> value="<?= $k; ?>"><?= $v; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <h4>Card count</h4>
            <select class="selectpicker" data-style="tl-select" id="col_num">
                <?php foreach ($cardCountOptions as $k => $v): ?>
                    <option <?= $k === $cardCountSelected ? "selected" : ""; ?> value="<?= $k; ?>"><?= $v; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>


<div class="col-md-12 mt-5">
    <button class="btn btn-success disabled" disabled="disabled" id="property-template-btn">Save</button>
</div>
