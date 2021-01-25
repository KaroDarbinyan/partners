<?php

use backend\components\UrlExtended;
use common\models\ShopCategory;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model ShopCategory */
/* @var $form ActiveForm */
/* @var $initial array */

?>

<div class="shop-category-form">

    <?php $form = ActiveForm::begin([
            "action" => UrlExtended::current()
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'picture')->widget(FileInput::class, [
        'pluginOptions' => [
            'previewFileType' => 'image',
            'showUpload' => false,
            'initialPreview' => $initial['preview'],
            'initialPreviewConfig' => $initial['previewConfig'],
        ],
    ]); ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $var = Yii::$app->assetManager->bundles["yii\bootstrap\BootstrapAsset"]->css = []; ?>
