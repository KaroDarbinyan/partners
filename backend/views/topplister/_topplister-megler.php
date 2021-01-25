<?php

/* @var $this yii\web\View */

/* @var $topplister array */

use yii\helpers\ArrayHelper;


$this->registerJs('
    $(document).ready(function() {
        setTimeout(function() {
            let userBlock = document.querySelector("[data-web_id]");
            
            if (userBlock) {
                userBlock.classList.add("current-user");
            
                userBlock.scrollIntoView({ block: "center", behavior: "smooth" });
            }
        }, 1);
    });
');
ArrayHelper::multisort($topplister, ["count", "user.short_name"], [SORT_DESC, SORT_ASC]);
?>

<?php foreach ($topplister as $key => $val): ?>
    <?php if ($key === 1 || $key % 2 === 1): ?>
        <div class="clear"></div>
    <?php endif; ?>

    <div <?php if ($val['user']['web_id'] == Yii::$app->user->identity->web_id) echo ' data-web_id="' . $val['user']['web_id'] . '" '; ?>
            id="toplister-<?= $val['user']['web_id'] ?>"
            class="top<?= $key + 1 ?> top-<?= $key < 1 ? 'xl' : ($key < 3 ? 'sm' : 'xs') ?>">

        <div>
            <h2><?= $val['user']['navn'] ?></h2>
            <i><?= $val['user']['tittel'] ?></i>
            <span><?= number_format($val['count'], 0, ' ', ' ') ?></span>
        </div>
        <img src="<?= $val['user']['urlstandardbilde'] ?>" alt="<?= $val['user']['navn'] ?>">
        <em><?= $key + 1 ?></em>
    </div>
<?php endforeach; ?>

