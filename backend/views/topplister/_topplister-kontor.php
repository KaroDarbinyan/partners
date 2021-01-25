<?php

/* @var $this yii\web\View */

/* @var $topplister array */

use yii\helpers\ArrayHelper;


/*$this->registerJs('
    $(document).ready(function() {
        setTimeout(function() {
            let userBlock = document.getElementById("toplister-' . Yii::$app->request->get('office') . '");
            
            if (userBlock) {
                userBlock.classList.add("current-user");
            
                userBlock.scrollIntoView({ block: "center", behavior: "smooth" });
            }
        }, 1);
    });
');*/


ArrayHelper::multisort($topplister, ["count", "department.short_name"], [SORT_DESC, SORT_ASC]);
?>

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

