<?php

/** @var $model common\models\LeadLog*/

use yii\helpers\Url;

setlocale(LC_ALL, "norwegian"); // TODO: set locale with Yii2 config

$log = [
    'bulletColor'   => $model->type,
    'name'          => $model->type,
    'message'       => $model->message,
    'date'          => strftime("%d. %h %Y %H:%M ", $model->updated_at),
    'created_at'    => $model->created_at,
];

?>
<tr id="log-<?= $model->id ?>">
    <td>
        <span class="schala-status">
            <span class="
                m-badge m-badge--dot
                schala-status-<?= $log['bulletColor'] ?>
            "></span>
            <em class="text-lowercase"><?= $log['name'] ?></em>
        </span>
    </td>
    <td class="target-blank pair-spans">
        <div class="log-message">
            <?php if(!empty($model->message)): ?>
                <?= preg_replace("/[\r\n]{2,}/", "</br>", $model->message); ?>
            <?php else: ?>
                <?php if ($model->user): ?>
                    <?= $model->user->navn ?><br><?= $model->user->department->short_name ?>
                <?php endif ?>
            <?php endif ?>
        </div>
        <?php if ($model->getAttribute('type') === '1014'): ?>
        <div class="log-actions d-flex flex-row mt-2">
            <div class="log-notify-date mr-2">
                <time class="timefix"><?= strftime('%d. %h %Y kl. %H:%M', $model->notify_at) ?></time>
                <time class="log-notify_at timeago" data-moment="<?= $model->notify_at ?>"></time>
            </div>
            <a href="#" class="text-muted mr-2 js-lead-log-edit" data-id="<?= $model->id ?>">
                <i class="fa fa-edit"></i>
            </a>
            <a href="#" class="text-muted js-lead-log-destroy" data-id="<?= $model->id ?>">
                <i class="fa fa-trash"></i>
            </a>
        </div>
        <?php endif ?>
    </td>
    <td>
        <span class="timefix">
            <?= $log['date'] ?>
        </span>
        <span class="timeago" data-moment="<?= $log['created_at'] ?>"></span>
    </td>
</tr>