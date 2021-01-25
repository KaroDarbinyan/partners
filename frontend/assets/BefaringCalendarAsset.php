<?php


namespace frontend\assets;


use Yii;
use yii\web\AssetBundle;

class BefaringCalendarAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $css = [

        "/befaring-assets/vendors/custom/fullcalendar/fullcalendar.bundle.css?v=",
        "/befaring-assets/vendors/general/animate.css/animate.css?v=",
        "/befaring-assets/vendors/general/toastr/build/toastr.css?v=",
        "/befaring-assets/vendors/general/morris.js/morris.css?v=",
        "/befaring-assets/vendors/general/sweetalert2/dist/sweetalert2.css?v=",
        "/befaring-assets/vendors/general/socicon/css/socicon.css?v=",
        "/befaring-assets/vendors/custom/vendors/line-awesome/css/line-awesome.css?v=",
        '/befaring-assets/demo/default/base/style.bundle.css    ',
        '/befaring-assets/demo/default/skins/header/base/light.css',
        '/befaring-assets/demo/default/skins/header/menu/light.css',
        '/befaring-assets/demo/default/skins/brand/dark.css',
        '/befaring-assets/demo/default/skins/aside/dark.css',


        '/befaring-assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css',
        '/befaring-assets/vendors/custom/vendors/flaticon/flaticon.css',
        '/css/befaring/calendar.css'
    ];
    public $baseUrl = '@web';

    public $js = [
        "/befaring-assets/vendors/general/jquery/dist/jquery.js?v=",
        "/befaring-assets/vendors/general/popper.js/dist/umd/popper.js?v=",
        "/befaring-assets/vendors/general/bootstrap/dist/js/bootstrap.min.js?v=",
        "/befaring-assets/vendors/general/js-cookie/src/js.cookie.js?v=",
        "/befaring-assets/vendors/general/moment/min/moment.min.js?v=",
        "/befaring-assets/vendors/general/sticky-js/dist/sticky.min.js?v=",
        "/befaring-assets/vendors/general/wnumb/wNumb.js?v=",

        "/befaring-assets/demo/default/base/scripts.bundle.js?v=",

        "/befaring-assets/vendors/custom/fullcalendar/fullcalendar.bundle.js?v=",
        "/befaring-assets/app/custom/general/components/calendar/locale-no.js?v=",

        "/befaring-assets/app/custom/general/components/calendar/background-events.js?v=",
        '/befaring-assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}