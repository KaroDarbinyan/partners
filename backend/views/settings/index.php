<?php
/** @var \common\models\User $brokers */
/** @var \common\models\Department $dep */
$this->title = 'Dashboard';

use backend\components\UrlExtended;
use yii\helpers\Html;
use yii\widgets\ActiveForm; ?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <div class="m-content">
        <?php
        $form = ActiveForm::begin([
            'id' => 'add_log-form',
            'fieldConfig' => [
                'options' => [
                    'tag' => false,
                ],
            ],
            'options' => ['method' => 'post']
        ]); ?>
        <div class="form-group jq-selectbox styler">
            <?= $form->field($dep, 'acting')->dropDownList(
                $brokers,
                [
                    'class' => 'form-control styler',
                    'label' => false
                ]
            );?>
        </div>

        <?= Html::submitButton('Lagre', ['class' => 'btn btn-dark']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>

    
