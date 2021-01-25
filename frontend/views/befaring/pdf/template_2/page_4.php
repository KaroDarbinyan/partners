<?php

/* @var $this yii\web\View */

/* @var $property PropertyDetails */

use common\components\StaticMethods;
use common\models\PropertyDetails;

$fields = [
    [
        'title' => 'POSTADRESSE',
        'class' => 'small-property-field',
        'data' => $property->postnummer
    ], [
        'title' => 'VEINAVN',
        'class' => 'small-property-field',
        'data' => $property->adresse
    ], [
        'title' => 'PRIMARROM',
        'class' => 'small-property-field',
        'data' => $property->prom ? "{$property->prom} m<sup>2</sup>" : null
    ], [
        'title' => 'BYGGEÅR',
        'class' => 'small-property-field',
        'data' => $property->byggeaar
    ], [
        'title' => 'EIERTYPE',
        'class' => 'small-property-field',
        'data' => $property->type_eierformbygninger
    ], [
        'title' => 'BORETTSALG',
        'class' => 'small-property-field',
        'data' => $property->borettslag
    ], [
        'title' => 'OPPDRAGSNUMMER',
        'class' => 'small-property-field',
        'data' => $property->oppdragsnummer
    ], [
        'title' => 'FORVENTET SALGSPRIS',
        'class' => 'large-property-field',
        'data' => StaticMethods::number_format($property->forventet_salgspris)
    ]
];

$n_exist = (bool)$property->propertyNeighbourhoods;

$icons = [
    'Steder i nærheten' => 'map-marked-alt.svg',
    'Transport' => 'shuttle-van.svg',
    'Sport' => 'running.svg',
    'Skoler' => 'school.svg',
    'Barnehager' => 'child.svg',
    'Varer/tjenester' => 'cart-plus.svg',
    'Green environment' => 'tree.svg',
    'Higher education' => 'graduation.svg',
    'Avstand til byer' => 'city.svg',
    'Fritid' => 'umbrella-beach.svg',
    'Harbour' => 'ship.svg'
];
$icon = '';

?>
<style>

    td, th {
        color: white;
    }

    img {
        width: 15px;
        margin-left: 3px;
    }

    .left {
        width: 70%;
        position: absolute;
        top: 55px;
        left: 55px;
    }

    .small-property-field {
        width: 180px;
        height: 55px;
        float: left;
    }

    .large-property-field {
        width: 360px;
        height: 55px;
        float: left;
    }

    .left_to_center {
        width: 70%;
        position: absolute;
        top: 350px;
        left: 55px;
    }

    .small-property-field_center {
        width: 180px;
        height: 55px;
        float: left;
    }

    .large-property-field_center {
        width: 360px;
        height: 55px;
        float: left;
    }

    .small-property-field p, .small-property-field_center p, .large-property-field p, .large-property-field_center p {
        margin-top: 0;
        font-weight: inherit;
        font-size: 16px;
        color: white;

    }

    .small-property-field span, .small-property-field_center span, .large-property-field span, .large-property-field_center span {
        font-weight: 100;
        font-size: 13px;
        color: white;
    }

    .right {
        width: 20%;
        position: absolute;
        top: 55px;
        right: 55px;
    }

    .right_to_center {
        width: 20%;
        position: absolute;
        top: 350px;
        right: 55px;
    }

    .right_block {
        width: 170px;
        height: 170px;
        background-color: white;
        border-radius: 100%;
    }

    .bottom {
        width: 90%;
        position: absolute;
        top: 240px;
        left: 0;
        right: 0;
        margin: auto;
        padding: 1.5%;
        background-color: rgba(0, 0, 0, .7);
        border-radius: 10px;
    }

    .bottom_table {
        border-collapse: collapse;
        width: 100%;
    }

    .col-icons {
        width: 3%;
    }

    .col-1 {
        width: 20%;
        text-align: left;
    }

    .col-2 {
        width: 47%;
        text-align: left;
    }

    .col-3 {
        width: 15%;
        text-align: right;
    }

    th.col-1, th.col-2, th.col-3 {
        padding: 5px 0;
        font-size: 20px;
        font-weight: 500;
        font-family: arial, sans-serif;
    }

    td.col-icons, td.col-1, td.col-2, td.col-3 {
        border-top: 1px solid grey;
        font-size: 16px !important;
        padding: 10px 0;
        font-family: arial, sans-serif;
        font-weight: 100;
    }


</style>

<div class="left<?= $n_exist ? '' : '_to_center'; ?>">
    <?php $i = 1 ?>
    <?php foreach ($fields as $field): ?>
        <?php if ($field['data'] && $field['data'] !== ''): ?>
            <div class="<?= $field['class'] . ($n_exist ? '' : '_center'); ?>">
                <p><?= $field['title']; ?></p>
                <span><?= $field['data']; ?></span>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<div class="right<?= $n_exist ? '' : '_to_center'; ?>">
    <div class="right_block">
        <p style="color: black; text-align: center; font-size: 35px; text-decoration: underline;"><?= $this->params['mulige_kjpere']; ?></p>
        <p style="color: black; text-align: center">MULIGE KJØPERE</p>
    </div>
</div>

<?php if ($n_exist): ?>
    <div class="bottom">
        <table class="bottom_table">
            <thead>
            <tr>
                <th class="col-icons"></th>
                <th class="col-1">Type</th>
                <th class="col-2">Navn</th>
                <th class="col-3">Avstand, km</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (array_slice($property->propertyNeighbourhoods, 0, 20) as $neighbour): ?>
                <tr>
                    <td class="col-icons">
                        <?php if (($neighbour->type !== $icon) && isset($icons[$neighbour->type])): ?>
                            <?php $icon = $neighbour->type; ?>
                            <?= "<img src='/img/befaring/icons/{$icons[$neighbour->type]}'>"; ?>
                        <?php endif; ?>
                    </td>
                    <td class="col-1"><?= $neighbour->type; ?></td>
                    <td class="col-2"><?= $neighbour->name; ?></td>
                    <td class="col-3"><?= $neighbour->distance; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
