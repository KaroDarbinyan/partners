<?php

/** @var $model common\models\Department*/
/** @var $leadId integer*/
/** @var $delegated integer*/

use yii\helpers\Url;

?>
<!--begin::Item-->
<div class="m-accordion__item">
    <div
        id="m_accordion_4_item_1_head"
        href="#m_accordion_<?= $model['id'] ?>_item_1_body"
        class="m-accordion__item-head collapsed"
        data-toggle="collapse"
        aria-expanded="false"
        role="tab"
    >
        <span class="m-accordion__item-title">
            <?= $model['navn']; ?>
        </span>
        <span class="m-accordion__item-mode"></span>
    </div>
    <div class="m-accordion__item-body collapse" id="m_accordion_<?= $model['id']?>_item_1_body" role="tabpanel" aria-labelledby="m_accordion_4_item_1_head" data-parent="#m_accordion_4">
        <div class="m-accordion__item-content">
            <?php
            foreach ($model['users'] as $user):
                $delegatedValue = '';
                $departmentName = '';
                if($delegated == $user['web_id']) {
                    $delegatedValue = 'data-delegated="true"';
                    $departmentName = 'data-department="'.\yii\helpers\ArrayHelper::getValue($user, 'department.short_name').'""';
                }
                ?>
                <li>
                    <a href="#" class="js-delegate" <?= $delegatedValue ?> <?= $departmentName ?>   data-id="<?= $leadId ?>" data-user-id="<?= $user['web_id'] ?>">
                        <?= $user['navn'] ?>
                    </a>
                </li>
            <?php endforeach ?>
        </div>
    </div>
</div>

<!--end::Item-->