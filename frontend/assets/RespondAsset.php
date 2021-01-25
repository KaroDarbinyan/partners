<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class RespondAsset extends AssetBundle
{
    /**
     * The Web-accessible directory that contains the asset files in this bundle.
     *
     * @var string
     */
    public $basePath = '@webroot';

    /**
     * The base URL for the relative asset files listed in js and css.
     *
     * @var string
     */
    public $baseUrl = '@web';

    /**
     * The options that will be passed to View::registerJsFile() when registering the JS files in this bundle.
     *
     * @var array
     */
    public $jsOptions = [
        'condition' => 'lt IE 9'
    ];

    /**
     * List of JavaScript files that this bundle contains.
     *
     * @var array
     */
    public $js = [
        'vendor/html5shiv/es5-shim.min.js',
        'vendor/html5shiv/html5shiv.min.js',
        'vendor/html5shiv/html5shiv-printshiv.min.js',
        'vendor/respond/respond.min.js'
    ];
}