<?php
/** @var \common\models\PropertyDetails $prop */
/** @var string|boolean $success */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<?php yii\widgets\Pjax::begin([
    'id' => 'more_adds',
    'submitEvent' => 'submit',
    'enablePushState'=>false, 'enableReplaceState'=>false,
])
?>
    <?php
    $form = ActiveForm::begin([
        'method' => 'post',
        'options' => ['data-pjax' => true],
        'action'=>Url::toRoute(['oppdrag/moreadds', 'id'=>$prop->id]),
    ]);?>
        <?= isset($success) ? "<p>{$success}</p>" : ''; ?>
        <?= isset($link) ? "<p>{$link}</p>" : ''; ?>
        <?= Html::submitButton('Ja',[
            'class' => 'btn btn-primary',
        ])?>
        <?= Html::submitButton('Nei',[
            'class' => 'swal2-cancel btn btn-danger',
            'data-dismiss' => "modal",
            'aria-label' => "Close",
        ])?>
    <?php ActiveForm::end(); ?>
<?php yii\widgets\Pjax::end() ?>
