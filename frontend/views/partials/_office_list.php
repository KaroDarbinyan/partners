<?php

/* @var $this View */

/* @var $groupedDepartments array */

use yii\helpers\Url;
use yii\web\View;


foreach ($groupedDepartments as $postal => $departments): ?>
    <?php foreach ($departments as $department): ?>
        <li>
            <a href="<?= Url::toRoute(['company/office', 'name' => $department['url']]) ?>">
                <h3><?= $department['short_name'] ?></h3>
                <p>1 kontor</p>
                <p><?= $department["partner_name"]; ?></p>
            </a>
        </li>
    <?php endforeach; ?>
<?php endforeach; ?>
