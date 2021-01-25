<?php

/** @var $this View */

/** @var $property PropertyDetails */

/** @var $neighbours PropertyNabolagsprofil */

use common\components\StaticMethods;
use common\models\PropertyDetails;
use common\models\PropertyNabolagsprofil;
use yii\web\View;

$icons = [
    'Steder i nærheten' => '<i class="fas fa-map-marked-alt"></i>',
    'Transport' => '<i class="fas fa-shuttle-van"></i>',
    'Sport' => '<i class="fas fa-running"></i>',
    'Skoler' => '<i class="fas fa-school"></i>',
    'Barnehager' => '<i class="fas fa-child"></i>',
    'Varer/tjenester' => '<i class="fas fa-cart-plus"></i>',
    'Green environment' => '<i class="fas fa-tree"></i>',
    'Higher education' => '<i class="fas fa-graduation-cap"></i>',
    'Avstand til byer' => '<i class="fas fa-city"></i>',
    'Fritid' => '<i class="fas fa-umbrella-beach"></i>',
    'Harbour' => '<i class="fas fa-ship"></i>'
];
$icon = '';

$this->registerCssFile('https://pro.fontawesome.com/releases/v5.10.0/css/all.css');

?>

<div class="row">
    <div class="col-md-12 pd-tabs">
        <div id="detaljer" class="detaljer tab-content">
            <div class="pd-fields">
                <p>Veinavn</p>
                <p><?= $property->adresse; ?></p>
            </div>
            <div class="pd-fields">
                <p>Postadresse</p>
                <p><?= $property->postnummer; ?></p>
            </div>
            <div class="pd-fields">
                <p>Primærrom</p>
                <p><?= $property->prom; ?> m<sup style="font-size: 10px">2</sup></p>
            </div>
            <div class="pd-fields">
                <p>Byggeår</p>
                <p><?= $property->byggeaar; ?></p>
            </div>
            <div class="pd-fields">
                <p>Eiertype</p>
                <p><?= $property->type_eierformbygninger; ?></p>
            </div>
            <div class="pd-fields">
                <p>Borettslag</p>
                <p><?= $property->borettslag; ?></p>
            </div>
            <div class="pd-fields">
                <p>Oppdragsnummer</p>
                <p><a href="/eiendom/<?= $property->id; ?>"
                      target="_blank"><?= $property->oppdragsnummer; ?></a></p>
            </div>
            <?php if ($property->forventet_salgspris): ?>
                <div class="pd-fields">
                    <p>Forventet salgspris</p>
                    <p><?= StaticMethods::number_format($property->forventet_salgspris); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <div id="statistikk" class="tab-content" style="display: none">
            <?php if ($property->salgssum): ?>
                <div class="pd-fields">
                    <p>Salgssum</p>
                    <p><?= number_format($property->salgssum, 0, '', ' '); ?>,-</p>
                </div>
            <?php endif; ?>
            <?php if ($property->prisantydning): ?>
                <div class="pd-fields">
                    <p>Prisantydning</p>
                    <p><?= number_format($property->prisantydning, 0, '', ' '); ?>,-</p>
                </div>
            <?php endif; ?>
            <?php if ($property->salgssum && $property->prisantydning): ?>
                <div class="pd-fields">
                    <p>Over prisantydning</p>
                    <p><?= number_format($property->salgssum - $property->prisantydning, 0, '', ' '); ?>,-
                        ( <?= round(($property->salgssum - $property->prisantydning) * 100 / $property->salgssum, 1) ?>
                        %
                        )</p>
                </div>
            <?php endif; ?>
            <?php if ($property->prom && $property->salgssum): ?>
                <div class="pd-fields">
                    <p>Kvadratmeterpris</p>
                    <p><?= number_format($property->salgssum / $property->prom, 0, '', ' '); ?>,-</p>
                </div>
            <?php endif; ?>
            <?php if ($property->markedsforingsdato !== 0 && $property->akseptdato !== null): ?>
                <div class="pd-fields">
                    <p>Salgstid</p>
                    <p><?= round((strtotime(date($property->akseptdato)) - $property->markedsforingsdato) / (86400)) . ' dager'; ?></p>
                </div>
            <?php endif; ?>
            <?php if ($property->befaringsdato !== ''): ?>
                <div class="pd-fields">
                    <p>Befaringsdato</p>
                    <p><?= date('j. F Y', strtotime(date($property->befaringsdato))); ?></p>
                </div>
            <?php endif; ?>
            <?php if ($property->oppdragsdato): ?>
                <div class="pd-fields">
                    <p>Oppdragsdato</p>
                    <p><?= date('j. F Y', date($property->oppdragsdato)); ?></p>
                </div>
            <?php endif; ?>
            <?php if ($property->markedsforingsdato && $property->markedsforingsdato !== 0): ?>
                <div class="pd-fields">
                    <p>Markedsføringsdato</p>
                    <p><?= date('j. F Y', date($property->markedsforingsdato)); ?></p>
                </div>
            <?php endif; ?>
            <?php if ($property->akseptdato !== null): ?>
                <div class="pd-fields">
                    <p>Akseptdato</p>
                    <p><?= date('j. F Y', strtotime(date($property->akseptdato))); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <div id="nabolagsprofil" class="tab-content" style="display: none; padding-bottom: 10px">
            <table class="table m-table m-table--head-no-border table-cell-center">
                <thead>
                <tr>
                    <th class="col_icons"></th>
                    <th class="col_1">TYPE</th>
                    <th class="col_2">NAVN</th>
                    <th class="col_3">AVSTAND(KM)</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($neighbours as $neighbour): ?>
                    <tr>
                        <td class="col_icons">
                            <?php if (($neighbour->type !== $icon) && isset($icons[$neighbour->type])): ?>
                                <?php $icon = $neighbour->type; ?>
                                <?= $icons[$neighbour->type]; ?>
                            <?php endif; ?>
                        </td>
                        <td class="col_1"><?= $neighbour->type; ?></td>
                        <td class="col_2"><?= $neighbour->name; ?></td>
                        <td class="col_3"><?= $neighbour->distance; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="bilder" class="tab-content" style="display: none; padding-bottom: 10px">
            <div class="pd-image">
                <img id="pd-image" data-id="<?= $property->id; ?>"
                     src="<?= $property['propertyImage']['urlstorthumbnail']; ?>">
            </div>
        </div>
    </div>
</div>