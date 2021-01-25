<?php

namespace frontend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css',
        'https://fonts.googleapis.com/css?family=Montserrat:400,600,700|Oswald:300,600,700',
        'js/jQueryFormStyler-master/jquery.formstyler.css',
        'js/fancybox/jquery.fancybox.css?v=31',
        '/css/easy-autocomplete.min.css',
        'css/style.css?v=460',
        'css/responsive.css?v=6.1',
        'fonts/fontello/css/fontello.css?v=52',
    ];
    public $js = [
        'js/jquery.blockUI.js?v=2',
        'js\ion.rangeSlider-master\js\ion.rangeSlider.js',
        'js/jQueryFormStyler-master/jquery.formstyler.js',
        'js/fancybox/jquery.fancybox.js?v=31',
        'js/common.js?v=37',
        'js/unitegallery-master/package/unitegallery/js/unitegallery.min.js',
        'js/unitegallery-master/package/unitegallery/themes/compact/ug-theme-compact.js',
        '/js/jquery.easy-autocomplete.min.js',
        'js/schala.js?v=550',
        'js/active-form-search.js?v=2',
        'js/custom-helpers.js?v=2',
//        'js/dwelling-detail.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
