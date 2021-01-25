<?php

/* @var $this View */

/* @var $groupedDepartments array */

use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;

foreach ($groupedDepartments as $postal => $departments): ?>
    <li>
        <?php if (count($departments) > 1): ?>
            <a href="#"
               data-toggle="modal"
               data-target="#offices-modal"
               data-title="<?= $postal ?>"
               data-offices='<?= Json::encode($departments) ?>'>
                <h3><?= $postal ?></h3>
                <p><?= count($departments) ?> kontorer</p>
                <p><?= $departments[0]["partner_name"]; ?></p>
            </a>
        <?php else: ?>
            <a href="<?= Url::toRoute(['company/office', 'name' => $departments[0]['url']]) ?>">
                <h3><?= $departments[0]['short_name'] ?></h3>
                <p>1 kontor</p>
                <p><?= $departments[0]["partner_name"]; ?></p>
            </a>
        <?php endif ?>
    </li>
<?php endforeach ?>
