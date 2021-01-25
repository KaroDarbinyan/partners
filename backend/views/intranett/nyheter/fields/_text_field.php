<?php

use common\models\News;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model News */
/* @var $form ActiveForm */

$dir_name = Yii::$app->view->params["dir_name"];
$this->registerAssetBundle('kartik\file\PiExifAsset', View::POS_END);
$this->registerAssetBundle('kartik\file\FileInputThemeAsset', View::POS_END);
$this->registerAssetBundle('kartik\file\SortableAsset', View::POS_END);
$this->registerAssetBundle('kartik\file\DomPurifyAsset', View::POS_END);
$this->registerAssetBundle('kartik\file\FileInputAsset', View::POS_END);

Yii::$app->assetManager->bundles["yii\bootstrap\BootstrapAsset"]->css = [];
?>


<?= Html::hiddenInput("dir_name", $dir_name); ?>

<?= $form->field($model, 'text')->widget(TinyMce::class,
    [
        'options' => [
            'style' => 'background: #1b1b1a; border: none; border-radius: 10px',
            'rows' => 35
        ],
        'language' => 'nb_NO',
        'clientOptions' => [
            'plugins' => [
                'print preview paste importcss searchreplace autolink autosave save directionality 
                code visualblocks visualchars fullscreen image link media template codesample 
                table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists 
                wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
            ],
            'force_br_newlines' => false,
            'force_p_newlines' => true,
            'forced_root_block' => '',
            'default_link_target' => "_blank",
            'toolbar' => implode(" | ", [
                "undo redo",
                "bold italic underline strikethrough",
                "fontselect fontsizeselect formatselect",
                "alignleft aligncenter alignright alignjustify",
                "outdent indent", "numlist bullist",
                "forecolor backcolor removeformat", "pagebreak",
                "charmap emoticons",
                "fullscreen  preview save print",
                "insertfile image media template link anchor codesample",
                "ltr rtl"
            ]),
            'toolbar_sticky' => true,
            'relative_urls' => false,
            'images_upload_url' => '/admin/intranett/upload-file?dir_name=' . $dir_name,
            'automatic_uploads' => true,
            'file_picker_types' => 'file image media',
//            'image_dimensions' => false,
//            'image_advtab' => true,
            'file_picker_callback' => new JsExpression('function (M, e, t) {
                                    let n = document.createElement("input");
                                    n.setAttribute("type", "file"), n.onchange = function () {
                                        let e = this.files[0], t = new FileReader;
                                        t.onload = function () {
                                            let n = "blobid" + (new Date).getTime(), i = tinymce.activeEditor.editorUpload.blobCache,
                                                N = t.result.split(",")[1], r = i.create(n, e, N);
                                            i.add(r), M(r.blobUri(), {title: e.name})
                                        }, t.readAsDataURL(e)
                                    }, n.click()
                                }'),


            'template_cdate_format' => '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
            'template_mdate_format' => '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
            'height' => 600,
            'image_caption' => true,
            'quickbars_selection_toolbar' => 'bold italic | quicklink h1 h2 h3 h4 h5 h6 blockquote quickimage quicktable',
            'noneditable_noneditable_class' => "mceNonEditable",
            'toolbar_mode' => 'sliding',
            'contextmenu' => "link image imagetools table",
            'importcss_append' => true,
            'templates' => [
                [
                    'title' => 'New Table',
                    'description' => 'creates a new table',
                    'content' => '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>'
                ],
                [
                    'title' => 'Starting my story', 'description' => 'A cure for writers block', 'content' => 'Once upon a time...'],
                [
                    'title' => 'New list with dates',
                    'description' => 'New List with dates',
                    'content' => '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>'
                ]
            ],

        ]
    ]
)->label(false); ?>

<?php  /* $form->field($model, 'files[]')->widget(FileInput::class, [
    'options' => ['multiple' => true],
    'pluginOptions' => [
        'language' => 'no',
        'uploadUrl' => "/file-upload-batch/1",
        'showUpload' => false,
        'uploadAsync' => false,
        'overwriteInitial' => false,
        'initialPreview' => Yii::$app->view->params["initial"]['preview'],
        'initialPreviewConfig' => Yii::$app->view->params["initial"]['previewConfig'],
        'purifyHtml' => true,
        'initialPreviewAsData' => true,
        'layoutTemplates' => [
            'footer' =>
                '<div class="file-thumbnail-footer">
                    <div class="file-footer-caption" title="{caption}">
                        <div class="file-caption-info">{caption}</div>
                        <div class="file-size-info">{size}</div>
                    </div>
                    {progress}
                {indicator}
                {actions}
                </div>'
        ]
    ],
    'pluginEvents' => [
        "fileloaded" => 'function(event, file, previewId, index, reader) {
                        console.log("event");
                        console.log(event);
                        console.log("file");
                        console.log(file);
                        console.log("previewId");
                        console.log(previewId);
                        console.log("index");
                        console.log(index);
                        console.log("reader");
                        console.log(reader);
                    }',
    ]
])->label("Bilde"); */ ?>
<?=
$form->field($model, 'files[]')->fileInput([
    "data" => [
        'initialPreview' => json_encode(Yii::$app->view->params["initial"]['preview']),
        'initialPreviewConfig' => json_encode(Yii::$app->view->params["initial"]['previewConfig']),
    ],
    'multiple' => true
])->label("Bilde");

?>
