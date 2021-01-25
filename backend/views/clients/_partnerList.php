<?php

/** @var $model common\models\Department*/
/** @var $lead \common\models\Forms*/
use yii\helpers\Url;
$href = 'Url::toRoute()';
$delegatedValue = $lead->broker_id ? 'data-delegated="true"' : '';
$departmentName = "";
$brokerName = $lead->broker_id ? "data-delegated-broker='{$lead->user->navn}'" : '';
?>
<a
    href="#"
    class="js-ufordelt"
    <?= $delegatedValue ?>
    data-dep-name='<?= $model['name'] ?>'
    data-id="<?= $lead->id ?>"
    <?= $brokerName ?>
    data-dep-id="<?= $model['id'] ?>"
><?= $model['name']  ?></a>