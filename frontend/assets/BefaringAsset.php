<?php


namespace frontend\assets;


use Yii;
use yii\web\AssetBundle;

class BefaringAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $css = [

        '//cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css',
        '//cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css',

        'css/befaring/style.css?v=',
        'css/befaring/dit-team.css?v=',
        'css/befaring/dit-hjem.css?v=',
        'css/befaring/reset.css?v=',
        'css/befaring/responsive.css?v=',
        'css/befaring/home.css?v=',
        'js/jQueryFormStyler-master/jquery.formstyler.css',
        'js/fancybox/jquery.fancybox.css?v=30',
        'vendor/easy-autocomplete/easy-autocomplete.min.css',
        'css/style.css?v=58',
        'fonts/fontello/css/fontello.css?v=51'
    ];
    public $baseUrl = '@web';

    public $js = [
        '//stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js',
        '//cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js',
        '//cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-nb_NO.min.js',
        'js/ion.rangeSlider-master/js/ion.rangeSlider.js',
        'js/moment.min.js',
        'vendor/easy-autocomplete/jquery.easy-autocomplete.min.js',
        'js/befaring/script.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}