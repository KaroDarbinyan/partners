<?php
/* @var $this yii\web\View */
/** @var array[] $list */
use yii\helpers\Html;

?>

<ul class = "search-results">
    <?php if (!count($list)){ ?>
        <li> Ingen funnet </li>
    <?php }?>
    <?php foreach ($list as $li) { ?>
        <li type = "<?= $li['type'] ?>">
            <i class = "icon-<?= $li['type'] ?>"></i>
            <a href="<?= $li['href'] ?>"><?= $li['label'] ?></a>
            <?= $li['count'] == -1 ? '' : "(<em>{$li['count']}</em>)"; ?>
        </li>
    <?php } ?>
</ul>

