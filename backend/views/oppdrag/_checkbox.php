<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var \common\models\PropertyDetails $model */
?>

<?php yii\widgets\Pjax::begin([
    'id' => 'oppdrag_set_show_hide',
    'submitEvent' => 'change',
    'enablePushState' => false, 'enableReplaceState' => false,
])
?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'options' => ['data-pjax' => true],
    'action' => Url::toRoute(['oppdrag/set-show-hide', 'id' => $model->id,]),
]) ?>

<?= $form->field($model, 'is_visible')->checkbox(array(
    'label' => 'Vis oppdraget på nettside <span></span>',
    'labelOptions' => ['class' => 'm-checkbox m-checkbox--solid m-checkbox--danger'],
)) ?>

<?php ActiveForm::end() ?>

<?php yii\widgets\Pjax::end() ?>
