<?php

/** @var PropertyDetails $oppdrag */

/** @var User $broker */
/** @var string $backend_link */
/** @var string $frontend_link */

use common\models\PropertyDetails;
use common\models\SpBoost;
use common\models\User;

$boosts = "";

if ($json = json_decode($oppdrag->sp_boost, true)) {
    $spBoosts = SpBoost::find()->select(["CONCAT(name, ' (', REPLACE(FORMAT(price, 0), ',', ' '), ' NOK)') as price"])
        ->where(["in", "name", array_keys($json)])->column();
    $boosts = "<p>" . implode(", ", $spBoosts) . "</p>";
}
?>

<p><?= $broker->navn; ?> har bestilt ekstra forfremmelse for oppdrag <?= $oppdrag->oppdragsnummer; ?>.</p>
<?= $boosts; ?>
<p><?= $backend_link; ?></p>
<p><?= $frontend_link; ?></p>
<p>Denne mailen er automatisk generert av Partners.no</p>
