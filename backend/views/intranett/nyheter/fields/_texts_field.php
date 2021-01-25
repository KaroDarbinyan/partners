<?php

use common\models\News;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model News */

?>
<?php if ($model->isNewRecord): ?>
    <div class="form-group">
        <?= Html::checkbox('send_sms', false, [
            'label' => '<span>Send tekstmelding</span>',
            'labelOptions' => [
                "data" => ["toggle" => "collapse", "target" => "#collapseSms"],
                "aria" => ["expanded" => "false", "controls" => "collapseSms"]
            ]
        ]); ?>
        <div class="collapse pt-2 pb-4 form-group" id="collapseSms">
            <?= Html::textarea("sms_text", "Det er en ny nyhet på INTRA \n{{link}}", ["class" => "form-control", "rows" => 5]); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::checkbox('send_email', false, [
            'label' => '<span>Send e-post</span>',
            'labelOptions' => [
                "data" => ["toggle" => "collapse", "target" => "#collapseEmail"],
                "aria" => ["expanded" => "false", "controls" => "collapseEmail"]
            ]
        ]); ?>
        <div class="collapse pt-2 pb-4 form-group" id="collapseEmail">
            <?= Html::textarea("email_text", "Det er en ny nyhet på INTRA \n{{link}}", ["class" => "form-control", "rows" => 10]); ?>
        </div>
    </div>
<?php endif; ?>

