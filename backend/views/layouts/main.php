<?php

/* @var $this View */
/** @var $user User */

/* @var $content string */

use backend\assets\AppAsset;
use common\models\Department;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;


//TODO: cleanup layout
AppAsset::register($this);
// TODO : move to some core controller
$user = Yii::$app->user->identity;
$departments = ArrayHelper::index(
        Department::find()
            ->joinWith(['partner' => function(\yii\db\ActiveQuery $query) {
                $query->where(['not', ['partner.id' => [15]]]);
            }])
            ->where(['inaktiv' => 0, 'original_id' => null])
            ->orderBy(['department.navn' => SORT_ASC])
            ->all(), 'web_id');
$depUrlNameMap = ArrayHelper::map($departments, 'url', 'short_name');
$depUrlNameMap[$user->url] = $user->navn;
$choosenUser = Yii::$app->request->get('user');
$choosenUser = $choosenUser ? User::findOne(['url' => $choosenUser]) : false;
$currentDep = Yii::$app->request->get('office');
$currentPartner = Yii::$app->request->get('partner');
$currentRoute = Yii::$app->controller->route;

$header = Yii::$app->controller->renderPartial('@app/views/layouts/_header.php', compact(
    'user',
    'choosenUser',
    'currentDep',
    'currentRoute',
    'depUrlNameMap',
    'departments'
));

$aside = Yii::$app->controller->renderPartial('@app/views/layouts/_aside.php', array(
    'user' => $user,
    'currentDep' => $currentDep,
    'choosenUser' => $choosenUser,
    'currentRoute' => $currentRoute,
    'depUrlNameMap' => $depUrlNameMap,
));

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="socket-host" content="<?=ArrayHelper::getValue( Yii::$app->params, 'socket-host') ?>">
    <meta name="socket-time" content="<?=ArrayHelper::getValue( Yii::$app->params, 'socket-time') ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon-180x180.png" sizes="180x180" />
    <link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon-152x152.png" sizes="152x152" />
    <link rel="icon" type="image/png" href="/img/favicon/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="/img/favicon/favicon-128x128.png" sizes="128x128" />
    <link rel="icon" type="image/png" href="/img/favicon/favicon-64x64.png" sizes="64x64" />
    <link rel="icon" type="image/png" href="/img/favicon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/img/favicon/favicon-16x16.png" sizes="16x16" />
    <meta name="application-name" content="&nbsp;"/>
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="theme-color" content="#1a4447">
    <?php $this->registerCsrfMetaTags() ?>
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families": ["Montserrat:300,400,500,600"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <script>
      window.Schala = <?= json_encode([
          'baseUrl' => Yii::$app->getUrlManager()->getBaseUrl()
      ]) ?>;
    </script>

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
</head>
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--static m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-aside--offcanvas-default">
<!-- begin::Body -->
<?php $this->beginBody() ?>
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">

    <!-- Main Header -->
    <?= $header ?>

    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

        <!-- BEGIN: Left Aside -->
        <?= $aside; ?>
        <!-- END: Left Aside -->

        <div class="main-content-pages" data-dynamic-content="main-content" style="color: white; flex: 1; max-width: 100%;">
           <div class="alter-message" style="display: none;">
               <div class="kt-alert kt-alert--outline alert alert-success alert-dismissible" role="alert">
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                   <h3 class="context"></h3>
               </div>
           </div>
            <!-- BEGIN: Content -->
            <?= $content ?>
            <!-- END: Content -->
        </div>

    </div>
</div>
<!-- end:: Page -->

<!-- end:: Body -->

<?php $this->endBody() ?>
    <script>
        window.Schala = <?= json_encode([ 'baseUrl' => Yii::$app->getUrlManager()->getBaseUrl(), ]) ?>;

        function setCookie(key, value, options) {
            // write
            if (value !== undefined) {
                //options = $.extend({}, config.defaults, options);
                if (typeof options.expires === 'number') {
                    var days = options.expires, t = options.expires = new Date();
                    t.setDate(t.getDate() + days);
                }

                value = String(value);

                return (document.cookie = [
                    encodeURIComponent(key),
                    '=',
                    encodeURIComponent(value),
                    options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                    options.path ? '; path=' + options.path : '/',
                    options.domain ? '; domain=' + options.domain : '',
                    options.secure ? '; secure' : ''
                ].join(''));
            }

            // read
            var cookies = document.cookie.split('; ');
            var result = key ? undefined : {};
            for (var i = 0, l = cookies.length; i < l; i++) {
                var parts = cookies[i].split('=');
                var name = decoded(parts.shift());
                var cookie = decoded(parts.join('='));

                if (key && key === name) {
                    result = converted(cookie);
                    break;
                }

                if (!key) {
                    result[name] = converted(cookie);
                }
            }

            return result;
        }

        function decoded(s) {
            var pluses = /\+/g;
            return decodeURIComponent(s.replace(pluses, ' '));
        }

        function converted(s) {
            if (s.indexOf('"') === 0) {
                // This is a quoted cookie as according to RFC2068, unescape
                s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
            }
            try {
                return s;
            } catch (er) {
            }
        }
    </script>

    <?php $is_light_style = isset($_COOKIE['is_light_style']) && 1 == intval($_COOKIE['is_light_style']) ? 1 : 0; ?>
    
    <!-- Modal -->
    
    <div class="modal fade" id="myModalVideo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">


                <div class="modal-body">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <!-- 16:9 aspect ratio -->
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="" id="video" allowscriptaccess="always"
                            allow="autoplay"></iframe>
                    </div>


                </div>

            </div>
        </div>
    </div>
<script>
$(document).ready(function () {
    // Gets the video src from the data-src on each button
    var $videoSrc;
    $('.video-btn').click(function () {
        $videoSrc = $(this).data("src");
    });
    console.log($videoSrc);

    // when the modal is opened autoplay it  
    $('#myModalVideo').on('shown.bs.modal', function (e) {
        // set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
        $("#video").attr('src', $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
    })

    // stop playing the youtube video when I close the modal
    $('#myModalVideo').on('hide.bs.modal', function (e) {
        $("#video").attr('src', $videoSrc);
    })
});
</script>
</body>
</html>
<?php $this->endPage() ?>
