<?php

/** @var $images \common\models\Image */

/** @var $this \yii\web\View */
/** @var $images \common\models\Image[] */

?>
<div id="gallery" style="display: none">
    <?php $imagesCount = count($images);
    foreach ($images as $key => $image): ?>
        <img data-image-number="<?= $image->nr; ?>"
             src="<?= $image->urlstorthumbnail; ?>"
             alt="<?= $image->overskrift ?>"
             data-image="<?= $image->urlstorthumbnail; ?>"
             data-description="<strong><?= $key + 1 ?> av <?= $imagesCount ?></strong> <?= $image->overskrift ?>">
    <?php endforeach ?>
</div>


