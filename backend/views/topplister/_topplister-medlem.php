<?php

/* @var $this yii\web\View */

/* @var $topplister array */

use yii\helpers\ArrayHelper;

ArrayHelper::multisort($topplister, ["count", "partner.name"], [SORT_DESC, SORT_ASC]);
?>
<?php if (Yii::$app->request->post('tl-partner') === "all"): ?>
    <?php foreach ($topplister as $key => $val): ?>
        <?php if ($key === 1 || $key % 2 === 1): ?>
            <div class="clear"></div>
        <?php endif; ?>

        <div id="toplister-<?= $val['partner']['id'] ?>"
             class="top<?= $key + 1 ?> top-<?= $key < 1 ? 'xl' : ($key < 3 ? 'sm' : 'xs') ?>">

            <div>
                <h2><?= $val['partner']['name'] ?></h2>
                <i><?php // $val['partner']['besoksadresse'] ?></i>
                <span><?= number_format($val['count'], 0, ' ', ' ') ?></span>
            </div>
            <?php /*<img src="<?= $val['partner']['urlstandardbilde'] ?>" alt="<?= $val['partner']['navn'] ?>"> */ ?>
            <em><?= $key + 1 ?></em>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <?php foreach ($topplister as $key => $val): ?>
        <?php if ($key === 1 || $key % 2 === 1): ?>
            <div class="clear"></div>
        <?php endif; ?>

        <div id="toplister-<?= $val['department']['url'] ?>"
             class="top<?= $key + 1 ?> top-<?= $key < 1 ? 'xl' : ($key < 3 ? 'sm' : 'xs') ?>">

            <div>
                <h2><?= $val['department']['short_name'] ?></h2>
                <i><?= $val['department']['besoksadresse'] ?></i>
                <span><?= number_format($val['count'], 0, ' ', ' ') ?></span>
            </div>
            <?php /*<img src="<?= $val['department']['urlstandardbilde'] ?>" alt="<?= $val['department']['navn'] ?>"> */ ?>
            <em><?= $key + 1 ?></em>
        </div>
    <?php endforeach; ?>
<?php endif; ?>


