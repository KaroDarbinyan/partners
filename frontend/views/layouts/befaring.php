<?php

/* @var $this \yii\web\View */

/* @var $content string */

use common\models\PropertyDetails;
use frontend\assets\BefaringAsset;
use frontend\assets\BefaringCalendarAsset;
use yii\helpers\Html;

$action = Yii::$app->controller->action->id;

$id = Yii::$app->request->get('id', '');

$imgPath = '/img/befaring';

if ($action == 'calendar') {
    BefaringCalendarAsset::register($this);
}

BefaringAsset::register($this);

if ($action != 'index') {
    $this->registerJs(" 
           $('.$action').addClass('active');
       ");
}

$this->registerJs("
    property = $id;
");

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
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
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/img/favicon/apple-touch-icon-57x57.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/img/favicon/apple-touch-icon-114x114.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/img/favicon/apple-touch-icon-72x72.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/img/favicon/apple-touch-icon-144x144.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="/img/favicon/apple-touch-icon-60x60.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="/img/favicon/apple-touch-icon-120x120.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="/img/favicon/apple-touch-icon-76x76.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="/img/favicon/apple-touch-icon-152x152.png"/>
    <link rel="icon" type="image/png" href="/img/favicon/favicon-196x196.png" sizes="196x196"/>
    <link rel="icon" type="image/png" href="/img/favicon/favicon-96x96.png" sizes="96x96"/>
    <link rel="icon" type="image/png" href="/img/favicon/favicon-32x32.png" sizes="32x32"/>
    <link rel="icon" type="image/png" href="/img/favicon/favicon-16x16.png" sizes="16x16"/>
    <link rel="icon" type="image/png" href="/img/favicon/favicon-128.png" sizes="128x128"/>
    <meta name="application-name" content="&nbsp;"/>
    <meta name="msapplication-TileColor" content="#ffffff"/>
    <meta name="theme-color" content="#1B1B1A">
    <meta name="msapplication-TileImage" content="/img/favicon/mstile-144x144.png"/>
    <meta name="msapplication-square70x70logo" content="/img/favicon/mstile-70x70.png"/>
    <meta name="msapplication-square150x150logo" content="/img/favicon/mstile-150x150.png"/>
    <meta name="msapplication-wide310x150logo" content="/img/favicon/mstile-310x150.png"/>
    <meta name="msapplication-square310x310logo" content="/img/favicon/mstile-310x310.png"/>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script>
        window.Schala = <?= json_encode([
            'baseUrl' => Yii::$app->getUrlManager()->getBaseUrl()
        ]) ?>;
        window.property = <?= $id ?>;
    </script>
</head>
<body class="main-wrapper">
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WM44C9V"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
<?php $this->beginBody() ?>

<div class="container-wrapper">
    <button type="button" class="navbar-toggle">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <div class="nav-bar">
        <div class="nav-bar-logo">
            <img src="/admin/images/logo-partners.svg" alt="logo" onclick="window.open('/', '_blank')">
        </div>
        <div class="nav-bar-content">
            <ul>
                <li class="nav-bar_item dit-team" onclick="window.open('/befaring/dit-team/<?= $id ?>', '_self')">
                    <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="49.531"
                            height="35.161"
                            viewBox="0 0 49.531 35.161"
                    >
                        <g
                                id="Group_1673"
                                data-name="Group 1673"
                                transform="translate(1.031 1)"
                        >
                            <ellipse
                                    id="Ellipse_15"
                                    data-name="Ellipse 15"
                                    cx="4.925"
                                    cy="4.925"
                                    rx="4.925"
                                    ry="4.925"
                                    transform="translate(3.571 4.325)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                            />
                            <ellipse
                                    id="Ellipse_16"
                                    data-name="Ellipse 16"
                                    cx="4.925"
                                    cy="4.925"
                                    rx="4.925"
                                    ry="4.925"
                                    transform="translate(34.393 4.325)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                            />
                            <ellipse
                                    id="Ellipse_17"
                                    data-name="Ellipse 17"
                                    cx="7.174"
                                    cy="7.174"
                                    rx="7.174"
                                    ry="7.174"
                                    transform="translate(16.893)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                            />
                            <g
                                    id="Group_1671"
                                    data-name="Group 1671"
                                    transform="translate(0 16.34)"
                            >
                                <path
                                        id="Path_4861"
                                        data-name="Path 4861"
                                        d="M106.839,308.051s-1.43-11.28,8.1-11.28a8.668,8.668,0,0,1,7.253,3.365"
                                        transform="translate(-106.763 -296.771)"
                                        fill="none"
                                        stroke="#666"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                />
                            </g>
                            <line
                                    id="Line_100"
                                    data-name="Line 100"
                                    y2="4.131"
                                    transform="translate(3.613 23.807)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                            />
                            <g
                                    id="Group_1672"
                                    data-name="Group 1672"
                                    transform="translate(32.019 16.34)"
                            >
                                <path
                                        id="Path_4862"
                                        data-name="Path 4862"
                                        d="M183.965,308.051s1.43-11.28-8.1-11.28a8.7,8.7,0,0,0-7.271,3.365"
                                        transform="translate(-168.592 -296.771)"
                                        fill="none"
                                        stroke="#666"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                />
                            </g>
                            <line
                                    id="Line_101"
                                    data-name="Line 101"
                                    y2="4.131"
                                    transform="translate(43.855 23.807)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                            />
                            <path
                                    id="Path_4863"
                                    data-name="Path 4863"
                                    d="M130.365,313.6s-2.542-16.523,11.439-16.523,11.28,16.205,11.28,16.205"
                                    transform="translate(-118.055 -280.579)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                            />
                            <line
                                    id="Line_102"
                                    data-name="Line 102"
                                    y2="5.402"
                                    transform="translate(16.599 27.62)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                            />
                            <line
                                    id="Line_103"
                                    data-name="Line 103"
                                    y2="5.402"
                                    transform="translate(31.057 27.62)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                            />
                        </g>
                    </svg>

                    <p>Ditt team</p>
                </li>
                <li class="nav-bar_item oppdrag "
                    onclick="window.open('/befaring/oppdrag/detaljer/<?= $id ?>', '_self')">
                    <!-- <img src="../assets/img/nav-bar/Ditt-hjem.svg" alt="Ditt-hjem" /> -->
                    <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="44.333"
                            height="44.333"
                            viewBox="0 0 44.333 44.333"
                    >
                        <g
                                id="Group_1777"
                                data-name="Group 1777"
                                transform="translate(-41.554 -303.1)"
                        >
                            <rect
                                    id="Rectangle_419"
                                    data-name="Rectangle 419"
                                    width="7.197"
                                    height="21.263"
                                    rx="2.203"
                                    transform="translate(60.123 320.302)"
                                    stroke-width="2"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    fill="none"
                            />
                            <circle
                                    id="Ellipse_18"
                                    data-name="Ellipse 18"
                                    cx="21.167"
                                    cy="21.167"
                                    r="21.167"
                                    transform="translate(42.554 304.1)"
                                    stroke-width="2"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    fill="none"
                            />
                            <circle
                                    id="Ellipse_19"
                                    data-name="Ellipse 19"
                                    cx="4.028"
                                    cy="4.028"
                                    r="4.028"
                                    transform="translate(59.481 308.116)"
                                    stroke-width="2"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    fill="none"
                            />
                        </g>
                    </svg>

                    <p>Ditt hjem</p>
                </li>
                <li class="nav-bar_item potential-clients"
                    onclick="window.open('/befaring/potential-clients/<?= $id ?>', '_self')">
                    <!-- <img
                      src="../assets/img/nav-bar/Potensielleinteressenter.svg"
                      alt="Potensielleinteressenter"
                    /> -->
                    <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="46.839"
                            height="44.613"
                            viewBox="0 0 46.839 44.613"
                    >
                        <g
                                id="Group_1730"
                                data-name="Group 1730"
                                transform="translate(1 1.042)"
                        >
                            <path
                                    id="Path_4907"
                                    data-name="Path 4907"
                                    d="M227.071,396.355s7.587-1.9,11.38-7.3c1.353-1.925,4.815-11.526,4.815-11.526a4.368,4.368,0,0,1,4.377-1.167c2.772.729,1.021,8.754,1.021,8.754l-2.481,8.462s11.235-3.21,13.423-1.6,0,5.69.292,6.274,1.459,2.48.584,3.94-1.9,2.188-1.6,3.5.119,4.343-.9,5.51-3.261,1.852-3.115,3.02-.292,3.355-1.313,3.939-16.263,1.684-26.476-2.4Z"
                                    transform="translate(-215.948 -376.2)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                            />
                            <rect
                                    id="Rectangle_439"
                                    data-name="Rectangle 439"
                                    width="8.228"
                                    height="19.842"
                                    rx="2.361"
                                    transform="translate(0 20.155)"
                                    stroke-width="2"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    fill="none"
                            />
                        </g>
                    </svg>
                    <p>Mulige kjøpere</p>
                </li>
                <li class="nav-bar_item calendar <?= $action == 'calendar' ? 'active' : ''; ?>"
                    onclick="window.open('/befaring/calendar/<?= $id ?>', '_self')">
                    <!--  <img
                      src="../assets/img/nav-bar/Din-kalender.svg"
                      alt="Din-kalender"
                    /> -->
                    <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="50.834"
                            height="41.849"
                            viewBox="0 0 50.834 41.849"
                    >
                        <g
                                id="Group_1776"
                                data-name="Group 1776"
                                transform="translate(-39.797 -402.964)"
                        >
                            <path
                                    id="Path_4866"
                                    data-name="Path 4866"
                                    d="M519.08,270.313h6.089a1.974,1.974,0,0,1,1.974,1.974V303.25a1.974,1.974,0,0,1-1.974,1.974H479.984a1.975,1.975,0,0,1-1.975-1.974V272.287a1.975,1.975,0,0,1,1.975-1.974h5.327"
                                    transform="translate(-437.362 138.739)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                            />
                            <line
                                    id="Line_105"
                                    data-name="Line 105"
                                    x2="26.734"
                                    transform="translate(51.42 409.052)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                            />
                            <line
                                    id="Line_106"
                                    data-name="Line 106"
                                    x2="48.272"
                                    transform="translate(41.078 415.948)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                            />
                            <rect
                                    id="Rectangle_420"
                                    data-name="Rectangle 420"
                                    width="3.448"
                                    height="7.112"
                                    transform="translate(51.423 410.925) rotate(180)"
                                    stroke-width="1.7"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    fill="none"
                            />
                            <rect
                                    id="Rectangle_421"
                                    data-name="Rectangle 421"
                                    width="3.448"
                                    height="7.112"
                                    transform="translate(81.533 410.925) rotate(180)"
                                    stroke-width="1.7"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    fill="none"
                            />
                            <path
                                    id="Path_4867"
                                    data-name="Path 4867"
                                    d="M525.652,309.735H485.317V288.817h40.335Z"
                                    transform="translate(-440.557 130.649)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                            />
                            <line
                                    id="Line_107"
                                    data-name="Line 107"
                                    y1="20.918"
                                    transform="translate(49.826 419.466)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                            />
                            <line
                                    id="Line_108"
                                    data-name="Line 108"
                                    y1="20.918"
                                    transform="translate(54.985 419.466)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                            />
                            <line
                                    id="Line_109"
                                    data-name="Line 109"
                                    y1="20.918"
                                    transform="translate(60.05 419.466)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                            />
                            <line
                                    id="Line_110"
                                    data-name="Line 110"
                                    y1="20.918"
                                    transform="translate(65.209 419.466)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                            />
                            <line
                                    id="Line_111"
                                    data-name="Line 111"
                                    y1="20.918"
                                    transform="translate(69.993 419.466)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                            />
                            <line
                                    id="Line_112"
                                    data-name="Line 112"
                                    y1="20.918"
                                    transform="translate(75.058 419.466)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                            />
                            <line
                                    id="Line_113"
                                    data-name="Line 113"
                                    y1="20.918"
                                    transform="translate(80.217 419.466)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                            />
                            <line
                                    id="Line_114"
                                    data-name="Line 114"
                                    x2="40.335"
                                    transform="translate(44.76 425)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                            />
                            <line
                                    id="Line_115"
                                    data-name="Line 115"
                                    x2="40.335"
                                    transform="translate(44.76 430.159)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                            />
                            <line
                                    id="Line_116"
                                    data-name="Line 116"
                                    x2="40.335"
                                    transform="translate(44.76 435.225)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                            />
                        </g>
                    </svg>

                    <p>Din kalender</p>
                </li>
                <li>
                    <div class="nav-bar_footer">
                        <p class="property-name">
                            <?= Yii::$app->session->get('propertyAddress') ?>
                            <br/><?= Yii::$app->session->get('propertyName') ?>
                        </p>
                        <p class="pdf" onclick="window.open('/befaring/pdf/<?= $id ?>', '_blank')">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" x="0px"
                                 y="0px" fill="#666"
                                 width="46.839"
                                 height="44.613"
                                 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                        <g>
                            <g>
                                <g>
                                    <path d="M468.825,201.896c-1.223-3.379-4.433-5.63-8.027-5.629h-34.133V25.6c-0.015-14.132-11.468-25.585-25.6-25.6h-85.333
                                        c-14.132,0.015-25.585,11.468-25.6,25.6v42.667H68.265c-14.132,0.015-25.585,11.468-25.6,25.6V486.4
                                        c0.015,14.132,11.468,25.585,25.6,25.6h187.733c2.264-0.01,4.433-0.91,6.039-2.506l119.454-119.454l0.029-0.036
                                        c0.68-0.705,1.231-1.523,1.63-2.418c0.11-0.264,0.205-0.533,0.287-0.807c0.254-0.727,0.407-1.485,0.455-2.253
                                        c0.012-0.184,0.106-0.34,0.106-0.527V279.91l82.263-68.552C469.023,209.059,470.048,205.275,468.825,201.896z M264.532,482.867
                                        v-81.8c0.005-4.711,3.822-8.529,8.533-8.533h81.8L264.532,482.867z M366.932,375.467h-93.867
                                        c-14.132,0.015-25.585,11.468-25.6,25.6v93.867h-179.2c-4.711-0.005-8.529-3.822-8.533-8.533V93.867
                                        c0.005-4.711,3.822-8.529,8.533-8.533h221.867v110.933h-34.133c-3.594-0.001-6.804,2.25-8.027,5.629
                                        c-1.223,3.38-0.198,7.163,2.564,9.463l102.4,85.333c3.166,2.633,7.759,2.633,10.925,0l3.071-2.559V375.467z M358.398,279.025
                                        l-78.829-65.692h19.096c2.263,0.001,4.434-0.898,6.035-2.499c1.6-1.6,2.499-3.771,2.499-6.035V25.6
                                        c0.005-4.711,3.822-8.529,8.533-8.533h85.333c4.711,0.005,8.529,3.822,8.533,8.533v179.2c-0.001,2.263,0.898,4.434,2.499,6.035
                                        c1.6,1.6,3.771,2.499,6.035,2.499h19.096L358.398,279.025z"/>
                                    <path d="M102.398,256h153.6c4.713,0,8.533-3.82,8.533-8.533s-3.82-8.533-8.533-8.533h-153.6c-4.713,0-8.533,3.82-8.533,8.533
                                        S97.685,256,102.398,256z"/>
                                    <path d="M102.398,298.667h204.8c4.713,0,8.533-3.82,8.533-8.533s-3.82-8.533-8.533-8.533h-204.8c-4.713,0-8.533,3.82-8.533,8.533
                                        S97.685,298.667,102.398,298.667z"/>
                                    <path d="M324.265,324.267H102.398c-4.713,0-8.533,3.821-8.533,8.533c0,4.713,3.82,8.533,8.533,8.533h221.867
                                        c4.713,0,8.533-3.821,8.533-8.533C332.798,328.087,328.978,324.267,324.265,324.267z"/>
                                    <path d="M213.332,366.933H102.398c-4.713,0-8.533,3.82-8.533,8.533s3.82,8.533,8.533,8.533h110.933
                                        c4.713,0,8.533-3.82,8.533-8.533S218.044,366.933,213.332,366.933z"/>
                                    <path d="M213.332,409.6H102.398c-4.713,0-8.533,3.82-8.533,8.533s3.82,8.533,8.533,8.533h110.933c4.713,0,8.533-3.82,8.533-8.533
                                        S218.044,409.6,213.332,409.6z"/>
                                </g>
                            </g>
                        </g>
                        </svg>
                            <span>Pdf</span>
                        </p>
                    </div>
                </li>
                <?php /*
                <li class="nav-bar_item node" onclick="window.open('/befaring/node/<?= $id ?>', '_self')">
                    <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="58.584"
                            height="53.781"
                            viewBox="0 0 58.584 53.781"
                    >
                        <g
                                id="Group_1792"
                                data-name="Group 1792"
                                transform="translate(-688.753 -157.218)"
                        >
                            <path
                                    id="Path_5073"
                                    data-name="Path 5073"
                                    d="M723.286,199.558v1.888a2.414,2.414,0,0,1-2.415,2.415h-28.7a2.414,2.414,0,0,1-2.414-2.415V160.739a2.414,2.414,0,0,1,2.414-2.414h18.955"
                                    transform="translate(0 -0.027)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                            />
                            <path
                                    id="Path_5074"
                                    data-name="Path 5074"
                                    d="M718.442,158.218v11.335h12.164Z"
                                    transform="translate(-7.32)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                            />
                            <g
                                    id="Group_1791"
                                    data-name="Group 1791"
                                    transform="translate(711.991 188.489)"
                            >
                                <path
                                        id="Path_5075"
                                        data-name="Path 5075"
                                        d="M749.255,212.146l-21.412-12.12-8.234-1.167,5,6.323,21.653,12.256Z"
                                        transform="translate(-719.608 -198.859)"
                                        fill="none"
                                        stroke="#666"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                />
                                <rect
                                        id="Rectangle_473"
                                        data-name="Rectangle 473"
                                        width="6.279"
                                        height="4.976"
                                        transform="translate(33.984 15.682) rotate(119.511)"
                                        stroke-width="2"
                                        stroke="#666"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        fill="none"
                                />
                                <path
                                        id="Path_5076"
                                        data-name="Path 5076"
                                        d="M751.532,221.228l-2.1,3.81L738.2,218.676"
                                        transform="translate(-724.352 -203.915)"
                                        fill="none"
                                        stroke="#666"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                />
                            </g>
                            <line
                                    id="Line_184"
                                    data-name="Line 184"
                                    y1="21.495"
                                    transform="translate(723.083 169.36)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                            />
                            <line
                                    id="Line_185"
                                    data-name="Line 185"
                                    x2="21.977"
                                    transform="translate(695.1 174.082)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                            />
                            <line
                                    id="Line_186"
                                    data-name="Line 186"
                                    x2="16.579"
                                    transform="translate(695.486 179.095)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                            />
                            <line
                                    id="Line_187"
                                    data-name="Line 187"
                                    x2="21.977"
                                    transform="translate(695.1 183.914)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                            />
                            <line
                                    id="Line_188"
                                    data-name="Line 188"
                                    x2="16.579"
                                    transform="translate(695.486 188.927)"
                                    fill="none"
                                    stroke="#666"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                            />
                        </g>
                    </svg>

                    <p>Notater</p>
                </li>
 */ ?>
            </ul>
        </div>
    </div>
    <div class="content-wrapper">
        <?= $content ?>
    </div>
</div>
<footer>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
