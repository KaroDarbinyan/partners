<?php

/** @var $this yii\web\View */
/** @var $form Forms */

/** @var $properties array */

use common\models\Forms;

?>

    <h2>Hei, <?= $form->name ?></h2>
    Her har du <strong><?= count($properties['for_sale']) ?></strong> aktuelle eiendommer tilpasset dine søk.
    <br><br>

    <ul class="properties" style="list-style: none; padding: 0; margin: 0;">
        <?php foreach ($properties['for_sale'] as $property): ?>
            <li class="property" style="margin-bottom: 25px; clear: both;">
                <a href="https://partners.no/annonse/<?= $property->id ?>"
                   style="text-decoration: none; color: black; font-size: 16px;">
                    <img
                            src="<?= $property->propertyImage->urlstorthumbnail ?>"
                            alt="<?= $property->kommunenavn ?>, <?= $property->adresse ?>"
                            class="thumb"
                            style="width: 240px; height: 160px; float: left; margin-right: 15px;"
                    >
                    <ul class="info" style="list-style: none; padding: 25px;">
                        <li><?= $property->kommunenavn ?>, <?= $property->adresse ?></li>
                        <li><?= number_format($property->totalkostnadsomtall, 0, ' ', ' '); ?>,-</li>
                        <li><?= $property->prom ?> m<sup>2</sup></li>
                        <li><?= $property->finn_eiendomstype ?></li>
                    </ul>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
    <br><br>

    <?php if (isset($properties['sales']) && count($properties['sales']) > 0): ?>
        <p>Også vare solgt <?= count($properties['sales']) ?> eiendommer</p>
        <p>Noe av dem:</p>
        <ul class="properties" style="list-style: none; padding: 0; margin: 0;">
            <?php foreach (array_slice($properties['sales'], 0, 10) as $key => $property): ?>
                <li class="property" style="margin-bottom: 25px; clear: both;">
                    <a href="https://partners.no/annonse/<?= $property->id ?>"
                       style="text-decoration: none; color: black; font-size: 16px;">
                        <img
                                src="<?= $property->propertyImage->urlstorthumbnail ?>"
                                alt="<?= $property->kommunenavn ?>, <?= $property->adresse ?>"
                                class="thumb"
                                style="width: 240px; height: 160px; float: left; margin-right: 15px;"
                        >
                        <ul class="info" style="list-style: none; padding: 25px;">
                            <li><?= $property->kommunenavn ?>, <?= $property->adresse ?></li>
                            <li><?= number_format($property->totalkostnadsomtall, 0, ' ', ' '); ?>,-</li>
                            <li><?= $property->prom ?> m<sup>2</sup></li>
                            <li><?= $property->finn_eiendomstype ?></li>
                        </ul>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
        <br><br>
    <?php endif ?>

    <p>Pris <?= $form->cost_from ?>-<?= $form->cost_to ?>,- - og kvm <?= $form->area_from ?>-<?= $form->area_to ?>.</p>

    <div style="text-align: center; margin-top: 25px;">
        <a href="https://partners.no/unsubscribe/<?= $form->id ?>/<?= md5($form->id . $form->email) ?>"
           style="color: black; font-size: 16px;"
        >
            Avslutte abonnementet
        </a>
    </div>

<?= $this->render('../_footer') ?>