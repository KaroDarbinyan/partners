<?php

/* @var $this yii\web\View */
/** @var array $topplister */

?>
<?php
foreach ($topplister as $key => $val): ?>
    <div id="toplister-kjede" class="top1 top-xl">
        <div>
            <h2>Partners</h2>
            <i></i>
            <span><?= number_format($val['count'], 0, ' ', ' ') ?></span>
        </div>
    </div>
<?php endforeach; ?>
