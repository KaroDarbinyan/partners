<?php

use common\models\PropertyDetails;

$this->title = 'BEFARING';

/** @var PropertyDetails $property */
?>

<div class="dit-team">
    <div class="row">
        <div class="col-md-12">
            <ul class="about-tabs">
                <li class="about-tabs_item tab-active" href="#sell"><a href="#sell">Vurderer du å selge?</a></li>
                <li class="about-tabs_item" href="#process"><a href="#process">Salgsprossessen</a></li>
                <li class="about-tabs_item" href="#markedspakke"><a href="#markedspakke">Markedspakke</a></li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="sell" class="sell tab-content">
                <?= $this->render('dit-team/sell', compact('property')) ?>
            </div>

            <div id="process" class="tab-content" style="display: none">
                <?= $this->render('dit-team/process') ?>
            </div>

            <div id="markedspakke" class="markedspakke tab-content" style="display: none">
                <?= $this->render('dit-team/markedspakke') ?>
            </div>
        </div>
    </div>
</div>