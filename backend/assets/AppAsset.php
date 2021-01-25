<?php

namespace backend\assets;

use yii\web\AssetBundle;
use Yii;
use yii\web\JqueryAsset;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/vendors/base/vendors.bundle.css',
        'css/demo/default/base/style.bundle.css?v=1.1',
        'css/vendors/easy-autocomplete/easy-autocomplete.min.css',
        '//cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css',
        'css/site.css?v=33',
        'css/print.css?v=26',
        'theme.css',
        'css/responsive-admin.css?v=2',
        'css/vendors/custom/fullcalendar/fullcalendar.bundle.css',
        '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
        'css/plugins/lightslider/dist/css/lightslider.css',
        'css/fontello/css/fontello.css?v=52',
    ];
    public $js = [
        'css/vendors/base/vendors.bundle.js',
        'css/demo/default/base/scripts.bundle.js',
        'css/vendors/custom/fullcalendar/fullcalendar.bundle.js',
        'css/vendors/custom/fullcalendar/nb.js',
        'css/vendors/custom/datatables/datatables.bundle.js',
        '//cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js',
        'css/plugins/lightslider/dist/js/lightslider.js?v=test',
        // TODO: load external scripts to files
        'https://www.amcharts.com/lib/4/core.js',
        'https://www.amcharts.com/lib/4/charts.js',
        'https://www.amcharts.com/lib/4/themes/dark.js',
        'https://www.amcharts.com/lib/4/themes/animated.js',
        'js/perfect-scrollbar.min.js',
        'js/moment/locale/nb.js',
        'js/lead-lead.js?v=2.5',
        'css/vendors/easy-autocomplete/jquery.easy-autocomplete.min.js',
        'js/jquery.mask.min.js',
        'js/schala.js?v=4.9',
    ];

    public function init()
    {
        $filename = 'dark-blue.css';

        if (user() && strpos(user()->partner->name ?? '', 'Schala') !== false) {
            $filename = 'dark-green.css';
        }

        $index = array_search('theme.css', $this->css);

        $this->css[$index] = "css/themes/{$filename}?v=" . time();

        parent::init();
    }


    public $depends = [
        'yii\web\JqueryAsset',
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
