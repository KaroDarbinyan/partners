<?php

use yii\helpers\Url;

/* @var \common\models\PropertyDetails $model */
?>

<a href="<?= Url::toRoute(['oppdrag/update-property', 'id' => $model->id]) ?>"
   class="dropdown-item js-update-property">Oppdater fra WM</a>
