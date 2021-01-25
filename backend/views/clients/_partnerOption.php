<?php

/** @var $model common\models\Department*/
/** @var $leadId integer*/
/** @var $delegated integer*/

use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$isLeadOwner = function ($user) use ($delegated) {
    return $delegated === $user['web_id'];
};

$department = null;

if (count($model['departments']) < 2) {
    $department = array_shift($model['departments']);
}

?>
<!--begin::Item-->
<div class="m-accordion__item">
    <div
        id="m_accordion_<?= $model['id'] ?>_item_1_head"
        href="#m_accordion_<?= $model['id'] ?>_item_1_body"
        class="m-accordion__item-head collapsed"
        data-toggle="collapse"
        aria-expanded="false"
        role="tab"
    >
        <span class="m-accordion__item-title">
            <?= $model['name'] ?>
        </span>
        <span class="m-accordion__item-mode"></span>
    </div>
    <div class="m-accordion__item-body collapse" id="m_accordion_<?= $model['id']?>_item_1_body" role="tabpanel" aria-labelledby="m_accordion_<?= $model['id'] ?>_item_1_head" data-parent="#m_accordion_4">
        <div class="m-accordion__item-content">
            <?php if (count($model['departments']) > 1): ?>
                <?php foreach ($model['departments'] as $department): ?>
                    <div class="m-accordion__item">
                        <div
                                id="m_accordion_<?= $department['id'] ?>_item_1_head"
                                href="#m_accordion_<?= $department['url'] ?>_item_1_body"
                                class="m-accordion__item-head collapsed"
                                data-toggle="collapse"
                                aria-expanded="false"
                                role="tab"
                        >
                            <span class="m-accordion__item-title"><?= $department['navn']; ?></span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse" id="m_accordion_<?= $department['url']?>_item_1_body" role="tabpanel" aria-labelledby="m_accordion_4_item_1_head" data-parent="#m_accordion_<?= $department['id'] ?>_item_1_head">
                            <div class="m-accordion__item-content">
                                <ul class="list-unstyled broker-list mb-0">
                                    <?php
                                    foreach ($department['users'] as $user):
                                        $delegatedValue = '';
                                        $departmentName = '';
                                        if($delegated == $user['web_id']) {
                                            $delegatedValue = 'data-delegated="true"';
                                            $departmentName = 'data-department="'. ArrayHelper::getValue($user, 'department.short_name').'"';
                                        }
                                        ?>
                                        <li>
                                            <a href="#" class="js-delegate" <?= $delegatedValue ?> <?= $departmentName ?>  data-id="<?= $leadId ?>" data-user-id="<?= $user['web_id'] ?>">
                                                <?= $user['navn'] ?>
                                            </a>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                <h6 class="broker-list-head"><?= $department['navn'] ?></h6>
                <ul class="list-unstyled broker-list mb-0">
                    <?php foreach ($department['users'] as $user): ?>
                        <li>
                            <a href="#" class="js-delegate"
                               data-delegated="<?= json_encode($isLeadOwner($user)) ?>"
                               data-department="<?= $isLeadOwner($user) ? ArrayHelper::getValue($user, 'department.short_name') : '' ?>"
                               data-id="<?= $leadId ?>"
                               data-user-id="<?= $user['web_id'] ?>">
                                <?= $user['navn'] ?>
                            </a>
                        </li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
        </div>
    </div>
</div>

<!--end::Item-->