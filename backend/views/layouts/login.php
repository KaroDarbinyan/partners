<?php

/* @var $content string */

?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon-180x180.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="/img/favicon/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="/img/favicon/favicon-128x128.png" sizes="128x128" />
    <link rel="icon" type="image/png" href="/img/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="/img/favicon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/img/favicon/favicon-16x16.png" sizes="16x16" />
    <meta name="application-name" content="&nbsp;"/>
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="theme-color" content="#1a4447">
    <title>PARTNERS</title>

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Montserrat:300,400,500,600"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->

    <link href="<?= Yii::getAlias('@web') ?>/css/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= Yii::getAlias('@web') ?>/css/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= Yii::getAlias('@web') ?>/css/site.css" rel="stylesheet" type="text/css" />

</head>

<?=$content; ?>
</html>

