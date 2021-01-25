<?php

/* @var $this yii\web\View */

/* @var $property PropertyDetails */

use common\models\PropertyDetails;


?>
    <style>
        .property_info {
            position: absolute;
            bottom: 350px;
            left: 0;
            right: 0;
            margin: auto;
        }

        .address {
            font-size: 25px;
            color: white;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .city {
            font-size: 20px;
            color: white;
            margin: 0;
            padding: 0;
            text-align: center;
        }

    </style>

<?php if ($property->adresse && $property->postnummer && $property->poststed): ?>
    <div class="property_info">
        <h3 class="address"><?= $property->adresse ?></h3>
        <p class="city"><?= "{$property->postnummer} {$property->poststed}"; ?></p>
    </div>
<?php endif; ?>