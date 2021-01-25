<?php

use common\models\User;
use yii\web\View;

/** @var View $this */
/** @var User $user */

?>

<?php if ($user): ?>
  <div class="deputy-block d-flex">
    <img src="<?= $user->urlstandardbilde ?>"
         class="m--img-rounded m--marginless table-schala-img"
         alt="<?= $user->navn ?>"/>
    <div class="d-flex">
      <div>
        <span class="table-schala-time"><?= $user->navn ?></span>
        <span class="table-schala-time-ago"><?= $user->department->short_name ?></span>
      </div>
      <button class="js-reset-deputy btn btn-danger" data-user-id="<?= $user->web_id ?>">
          <?= Yii::t('app', 'Return') ?>
      </button>
    </div>
  </div>
<?php else: ?>
  <?= Yii::t('app', 'Deputy not appointed.') ?>
<?php endif ?>
