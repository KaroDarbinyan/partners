<?php

use common\components\StaticMethods;
use frontend\assets\MainAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $content string */

MainAsset::register($this);
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="nb">
    <head>
        <!-- Google Tag Manager -->
        <script>(function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start':
                        new Date().getTime(), event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-WM44C9V');</script>
        <!-- End Google Tag Manager -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon-180x180.png" sizes="180x180"/>
        <link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon-152x152.png" sizes="152x152"/>
        <link rel="icon" type="image/png" href="/img/favicon/favicon-196x196.png" sizes="196x196"/>
        <link rel="icon" type="image/png" href="/img/favicon/favicon-128x128.png" sizes="128x128"/>
        <link rel="icon" type="image/png" href="/img/favicon/favicon-64x64.png" sizes="64x64"/>
        <link rel="icon" type="image/png" href="/img/favicon/favicon-32x32.png" sizes="32x32"/>
        <link rel="icon" type="image/png" href="/img/favicon/favicon-16x16.png" sizes="16x16"/>
        <meta name="application-name" content="&nbsp;"/>
        <meta name="msapplication-TileColor" content="#ffffff"/>
        <meta name="theme-color" content="#1a4447">
        <script id="CookieConsent" src="https://policy.app.cookieinformation.com/uc.js" data-culture="NB"></script>
        <?php if (isset($this->blocks['head'])): ?>
            <?= $this->blocks['head'] ?>
        <?php endif ?>

        <script>
            window.Schala = <?= json_encode([
                'baseUrl' => Yii::$app->getUrlManager()->getBaseUrl()
            ]) ?>;
        </script>
    </head>
    <body class="<?= StaticMethods::bodyClass(); ?>">
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WM44C9V"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?= $this->render('@app/views/layouts/_header.php') ?>

    <?php $this->beginBody() ?>

    <?php if (isset($this->blocks['page_header'])): ?>
        <?= $this->blocks['page_header'] ?>
    <?php endif ?>

    <?= $content ?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>