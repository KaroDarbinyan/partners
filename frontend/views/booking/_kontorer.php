<?php

/* @var $this View */

/* @var $data array */

use yii\helpers\Json;
use yii\web\View;

$count = 0;
foreach ($data as $datum) $count += count($datum);
?>
<h2><b>Velg kontor (<?= $count; ?>)</b></h2>
<div class="row">
    <div class="col-12">
        <ul class="list_office">
            <?php foreach ($data as $postal => $departments): ?>
                <li>
                    <?php if (count($departments) > 1): ?>
                        <a href="#"
                           data-toggle="modal"
                           data-target="#booking-offices-modal"
                           data-title="<?= $postal ?>"
                           data-offices='<?= Json::encode($departments) ?>'>
                            <h3><?= $postal ?></h3>
                            <p><?= count($departments) ?> kontorer</p>
                            <p><?= $departments[0]["partner_name"]; ?></p>
                        </a>
                    <?php else: ?>
                        <a href="<?= $departments[0]["url"]; ?>">
                            <h3><?= $departments[0]["short_name"]; ?></h3>
                            <p>1 kontor</p>
                            <p><?= $departments[0]["partner_name"]; ?></p>
                        </a>
                    <?php endif ?>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>
<br>
<div class="mt-5 navigate-container">
    <button class="order" data-url="/booking/main">Gå tilbake</button>
</div>

<div class="modal fade" id="booking-offices-modal" tabindex="-1" role="dialog"
     aria-labelledby="bookingOfficesModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase" id="bookingOfficesModalLabel">KONTORER</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>