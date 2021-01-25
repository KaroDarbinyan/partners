<?php

use backend\components\UrlExtended;
use common\models\ShopCategory;
use common\models\ShopProduct;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model ShopProduct */
/* @var $form ActiveForm */
/* @var $initial array */

$categories = ['' => 'Velg kategori'] + ArrayHelper::map(ShopCategory::find()->all(), 'id', 'name');
?>

    <div class="shop-product-form">

        <?php $form = ActiveForm::begin([
                 "action" => UrlExtended::current(),
                'options' => ['id' => 'kart']]
        ); ?>

        <?= $form->field($model, 'category_id')->dropDownList($categories) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'price')->textInput() ?>

        <?php /* $form->field($model, 'pictures[]')->widget(FileInput::class, [
            'options' => ['multiple' => true],
            'pluginOptions' => [
                'previewFileType' => 'image',
                'showUpload' => false,
                'initialPreview' => $initial['preview'],
                'initialPreviewConfig' => $initial['previewConfig'],
                'overwriteInitial' => false,
                'uploadUrl' => "/file-upload-batch/1",
                'uploadExtraData' => [
                    'img_key' => "1000",
                    'img_keywords' => "happy, nature",
                ],
                'uploadAsync' => false,
                'minFileCount' => 2,
                'maxFileCount' => 5,
            ],
            'pluginEvents' => [
                "filepredelete" => "function() { alert(1231); }",
                "filereset" => "function() { alert(1231); }",
            ]
        ]); */ ?>


        <?= $form->field($model, 'pictures[]')->widget(FileInput::class, [
            'options' => ['multiple' => true],
            'pluginOptions' => [
                'language' => 'no',
                'uploadUrl' => "/file-upload-batch/1",
                'showUpload' => false,
                'uploadAsync' => false,
//                'minFileCount' => 2,
//                'maxFileCount' => 5,
                'overwriteInitial' => false,
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

<?php Yii::$app->assetManager->bundles["yii\bootstrap\BootstrapAsset"]->css = []; ?>