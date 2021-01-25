<?php

use common\models\Partner;
use common\models\User;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
/* @var User $user */

$user = Yii::$app->user->identity;

$partners = Partner::find()->all();
$model->prt_names = ArrayHelper::map($model->isNewRecord ? $partners : $model->partners, "name", "name");

$roleSelect = [];
$select = explode("-", $model->isNewRecord ? "partner-director-broker" : $model->user_role);
foreach ($select as $item) {
    $roleSelect[$item] = ['selected' => true];
}
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
        'id' => 'news-form'
    ]
]);
?>

<?= $form->field($model, 'name')->textInput([
    'placeholder' => 'Tittel',
    'style' => 'background: #1b1b1a; border: none; border-radius: 10px',
    'maxlength' => true
])->label(false); ?>

<?= $form->field($model, 'type')
    ->dropDownList([
        'nyheter' => 'Nyheter',
        'profilering' => 'Profilering',
        'idedatabase' => 'Idedatabase'
    ])->label('Typen'); ?>

<?= $form->field($model, 'user_role')
    ->dropDownList([
        'broker' => 'broker',
        'director' => 'director',
        'partner' => 'partner',
    ], [
            'multiple' => 'multiple',
            'class' => 'form-control selectpicker',
            'data' => [
                'actions-box' => false,
                'col-index' => 1,
            ],
            'options' => $roleSelect
        ]
    )->label('Hvem ser artikkel')
?>

<?= $form->field($model, "prt_names")->widget(Select2::class, [
    'model' => $model,
    'attribute' => 'prt_names',
    'value' => $model->prt_names,
    'data' => ArrayHelper::map($partners, "name", "name"),
    'maintainOrder' => true,
    'options' => [
        'multiple' => true,
    ],
    'pluginOptions' => [
        'tags' => true,
    ]
])->label("Partnere"); ?>

<?= $this->render("fields/_text_field", compact("model", "form")); ?>


<?= $form->field($model, 'show_img')->checkbox([
    'label' => '<span>Vise bilde inne artikkel</span>'
]); ?>

<?= $this->render("fields/_texts_field", compact("model")); ?>

<div class="form-group">
    <?= Html::submitButton('Lagre', ['class' => 'btn btn-success', 'style' => 'margin-top: 20px;border-radius: 7px']) ?>
</div>

<?php ActiveForm::end(); ?>


