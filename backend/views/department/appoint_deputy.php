<?php

use common\models\Department;
use yii\web\View;

/** @var View $this */
/** @var Department $department */

$this->title = Yii::t('app', 'Vikar');

?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">
  <div class="m-content">
    <div class="row">
      <div class="col-lg-12">
        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
          <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
              <div class="mt-2">
                <h4><?= $department->navn ?></h4>
              </div>
            </div>
          </div>
          <div class="m-portlet__body m--block-center">
            <div class="row mb-4">
              <div class="col">
                <h4><?= Yii::t('app', 'Avdelingsleder') ?></h4>
                <div class="d-flex my-4">
                    <?php if ($user = $department->user): ?>
                      <img src="<?= $user->urlstandardbilde ?>"
                           class="m--img-rounded m--marginless table-schala-img"
                           alt="<?= $user->navn ?>"/>
                      <div>
                        <span class="table-schala-time"><?= $user->navn ?></span>
                        <span class="table-schala-time-ago"><?= $user->department->short_name ?></span>
                      </div>
                    <?php endif ?>
                </div>
              </div>
              <div class="col">
                <h4><?= Yii::t('app', 'Vikar') ?></h4>
                <div class="deputy-block-content my-4">
                    <?= $this->render('deputy_block', ['user' => $department->directorDeputy]) ?>
                </div>
              </div>
            </div>
            <h4><?= Yii::t('app', 'Staff') ?></h4>
            <form class="js-director-deputy" method="post">
              <div class="form-group mb-4">
                <select name="user_id" class="form-control selectpicker">
                  <option value=""><?= Yii::t('app', 'Velg en vikar') ?></option>
                    <?php foreach ($department->users as $user): ?>
                        <?php if ($deputy = $department->directorDeputy): ?>
                        <option value="<?= $user->web_id ?>" <?= $deputy->equals($user) ? 'selected' : '' ?>>
                            <?= $user->navn ?>
                        </option>
                        <?php else: ?>
                        <option value="<?= $user->web_id ?>"><?= $user->navn ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
              </div>
              <button class="btn btn-default" type="submit">
                  <?= Yii::t('app', 'Lagre') ?>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>