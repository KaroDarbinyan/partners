<?php
/* @var $this \yii\web\View */
/** @var $model common\models\PropertyDetails */
/* @var $content string */
use backend\assets\AppAsset;
use backend\components\UrlExtended;
use common\models\Department;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
AppAsset::register($this);
$model = $this->params['model'];
$page = $this->params['v'];
if (isset($this->params['v2'])) {
    $content = Yii::$app->controller->renderPartial('//wrappers/befaringsmappe_layout', array(
        'content' => $content,
        'model' => $this->params['model'],
        'page' => $this->params['v'],
        'subPage' => $this->params['v2'],
    ));
}
$statusClass = strtolower(
    str_replace(' ', '-', $model->tinde_oppdragstype)
);
// TODO : move to some core controller
/** @var TYPE_NAME $user */
$user = Yii::$app->user->identity;
$departments = ArrayHelper::index(
        Department::find()
            ->where(['inaktiv' => 0, 'original_id' => null])
            ->orderBy(['short_name' => SORT_ASC])
            ->all(), 'web_id');
$depUrlNameMap = ArrayHelper::map($departments, 'url', 'short_name');
$depUrlNameMap[$user->url] = $user->navn;
$choosenUser = Yii::$app->request->get('user');
$choosenUser = User::findOne(['url' => $choosenUser]);
$currentDep = Yii::$app->request->get('office');
$currentRoute = Yii::$app->controller->route;

$header = Yii::$app->controller->renderPartial('@app/views/layouts/_header.php', array(
    'user' => $user,
    'currentDep' => $currentDep,
    'choosenUser' => $choosenUser,
    'currentRoute' => $currentRoute,
    'depUrlNameMap' => $depUrlNameMap,
    'departments' => $departments,
));
$aside = Yii::$app->controller->renderPartial('@app/views/layouts/_aside.php', array(
    'user' => $user,
    'currentDep' => $currentDep,
    'currentRoute' => $currentRoute,
    'depUrlNameMap' => $depUrlNameMap,
));
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Latest updates and statistic charts">
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
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--static m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<?php $this->beginBody() ?>

<!-- begin::Body -->

<!-- begin:: Page -->

<div class="m-grid m-grid--hor m-grid--root m-page">

    <!-- Main Header -->
    <?= $header ?>

    <script type="text/javascript">
        function change_page_style() { //is_light
            var ob = $('#chk_dark_theme');
            var is_light = -1;
            if (!ob.length) {
                return;
            }
            is_light = ob.prop('checked') ? 1 : 0;
            var dark_style_tag = '<link href="/INVOLVE/css/dark.css" rel="stylesheet" type="text/css" />';
            var ob_link = $('head link[href="/admin/css/dark.css"]');
            if (is_light == 1) {
                $('head link[href="/admin/css/dark.css"]').remove();
                setCookie('is_light_style', 1, {expires: 86400 * 30}); // 1 month
            } else if (is_light == 0) {
                if (!ob_link.length) {
                    $('head').append(dark_style_tag);
                }
                setCookie('is_light_style', 0, {expires: 86400 * 30}); // 1 month
            }
        }
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
        };
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

    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">


        <!-- BEGIN: Left Aside -->
        <?= $aside; ?>
        <!-- END: Left Aside -->

        <div class="m-grid__item m-grid__item--fluid m-wrapper">

            <div class="m-content">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="oppdrag-header">
                            <h1><?= $model->adresse ?></h1>
                            <span class="schala-status">
                                <span class="
                                    m-badge m-badge--dot
                                    schala-type-<?= $statusClass ?>"
                                ></span>
                                <em><?= $model->tinde_oppdragstype ?></em>
                                <span id="pd-boost">
                                    <?php if ($model->sp_boost && ($json = json_decode($model->sp_boost, true))): ?>
                                        <?php foreach ($json as $key => $item): ?>
                                            <span class="badge badge-warning mr-1"> <?= "$key $item"; ?></span>
                                        <?php endforeach; ?>
                                    <?php endif ?>
                                </span>
                            </span>
                            <span class="prices"><?= number_format($model->salgssum ?  : $model->prisantydning, 0, '.', ' '); ?>,-</span>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs  m-tabs-line m-tabs-line--2x m-tabs-line--danger" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a
                                        href="<?= UrlExtended::toRoute(['oppdrag/interessenter/', 'id' => $model->id]) ?>"
                                        class="
                                        nav-link m-tabs__link
                                        <?= $page === 'interessenter' ? 'active' : '' ?>
                                    "
                                >Interessenter
                                    <sup class="colorstd"><!-- add count  --></sup></a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a
                                        href="<?= UrlExtended::toRoute(['oppdrag/detaljer/', 'id' => $model->id]) ?>"
                                        class="
                                        nav-link m-tabs__link
                                        <?= $page === 'detaljer' ? 'active' : '' ?>
                                    "
                                >Detaljer</a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a href="<?= UrlExtended::toRoute(['oppdrag/statistikk/', 'id' => $model->id]) ?>"
                                        class="nav-link m-tabs__link <?= $page === 'statistikk' ? 'active' : '' ?>">Statistikk</a>
                            </li>
                            <?php /*
                            <li class="nav-item m-tabs__item">
                                <a
                                        href="<?= UrlExtended::toRoute(['oppdrag/fremdrift/', 'id' => $model->web_id]) ?>"
                                        class="
                                        nav-link m-tabs__link
                                        <?= $page === 'fremdrift' ? 'active' : '' ?>
                                    "
                                >Fremdrift</a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a
                                        href="<?= UrlExtended::toRoute(['oppdrag/statistikk/', 'id' => $model->web_id]) ?>"
                                        class="
                                        nav-link m-tabs__link
                                        <?= $page === 'statistikk' ? 'active' : '' ?>
                                    "
                                >Statistikk</a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a
                                        href="<?= UrlExtended::toRoute([
                                            'oppdrag/befaringsmappe/',
                                            'page' => 'dokumenter',
                                            'id' => $model->web_id,
                                        ]) ?>"
                                        class="
                                        nav-link m-tabs__link
                                        <?= $page === 'befaringsmappe' ? 'active' : '' ?>
                                    "
                                >Befaringsmappe</a>
                            </li>
                            */ ?>
                        </ul>
                    </div>
                </div>

                <div class="collapse" id="collapseFilter">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="m-portlet m-portlet--mobile m-portlet--body-progress- margin-bottom-0">
                                <div class="m-portlet__body">

                                    <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                                        <div class="form-group m-form__group row">
                                            <label class="col-lg-2 col-form-label ionrange-label-fix">Adresse:</label>
                                            <div class="col-lg-3">
                                                <div class="m-ion-range-slider">
                                                    <input type="hidden" id="m_slider_adresse"/>
                                                </div>
                                            </div>
                                            <label class="col-lg-2 col-form-label ionrange-label-fix">Prisantydning:</label>
                                            <div class="col-lg-3">
                                                <div class="m-ion-range-slider">
                                                    <input type="hidden" id="m_slider_prisantydning"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-lg-2 col-form-label ionrange-label-fix">Primærrom:</label>
                                            <div class="col-lg-3">
                                                <div class="m-ion-range-slider">
                                                    <input type="hidden" id="m_slider_primaerrom"/>
                                                </div>
                                            </div>
                                            <label class="col-lg-2 col-form-label ionrange-label-fix">Salgssum:</label>
                                            <div class="col-lg-3">
                                                <div class="m-ion-range-slider">
                                                    <input type="hidden" id="m_slider_salgssum"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label class="col-lg-2 col-form-label ionrange-label-fix2">Postnummer:</label>
                                            <div class="col-lg-3">

                                                <select class="form-control m-select2 schala-multiselect"
                                                        id="m_solgte_postnummer" name="param" multiple="multiple">
                                                    <optgroup label="Sagene">
                                                        <option value="AK" selected>0553</option>
                                                        <option value="HI">0566</option>
                                                    </optgroup>
                                                    <optgroup label="Torshov">
                                                        <option value="CA">0557</option>
                                                        <option value="NV" selected>0556</option>
                                                        <option value="OR">0571</option>
                                                        <option value="WA">0564</option>
                                                    </optgroup>
                                                    <optgroup label="Carl Barner">
                                                        <option value="AZ">0567</option>
                                                        <option value="CO">0568</option>
                                                        <option value="ID">0569</option>
                                                        <option value="MT" selected>0670</option>
                                                        <option value="NE">0671</option>
                                                        <option value="NM">0672</option>
                                                        <option value="ND">0673</option>
                                                        <option value="UT">0674</option>
                                                        <option value="WY">0675</option>
                                                    </optgroup>
                                                    <optgroup label="Kalbakken">
                                                        <option value="AL">0880</option>
                                                        <option value="AR">0881</option>
                                                        <option value="IL">0882</option>
                                                        <option value="IA">0883</option>
                                                        <option value="KS">0884</option>
                                                        <option value="KY">0885</option>
                                                        <option value="LA">0886</option>
                                                        <option value="MN">0887</option>
                                                        <option value="MS">0888</option>
                                                        <option value="MO">0830</option>
                                                        <option value="OK">0833</option>
                                                        <option value="SD">0834</option>
                                                        <option value="TX">0835</option>
                                                        <option value="TN">0836</option>
                                                        <option value="WI">0837</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <label class="col-lg-2 col-form-label ionrange-label-fix2">Medlem:</label>
                                            <div class="col-lg-3">

                                                <select class="form-control m-select2 schala-multiselect"
                                                        id="m_solgte_medlem" name="param" multiple="multiple">
                                                    <option>Schala & Partners</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group m-form__group row">
                                            <label class="col-lg-2 col-form-label ionrange-label-fix2">Eindomstype:</label>
                                            <div class="col-lg-3">

                                                <select class="form-control m-select2 schala-multiselect"
                                                        id="m_solgte_eindomstype" name="param" multiple="multiple">
                                                    <option value="HI">Aksjeleilighet</option>
                                                    <option value="HI">Andelsleilighet</option>
                                                    <option value="HI">Annet</option>
                                                    <option value="HI">Boligtomt</option>
                                                    <option value="HI" selected>Enebolig</option>
                                                    <option value="HI">Garasje selveier</option>
                                                    <option value="HI" selected>Leilighet</option>
                                                    <option value="HI">Leilighet selveier</option>
                                                    <option value="HI">Næringsbygg</option>
                                                    <option value="HI">Parkeringsplass</option>
                                                    <option value="HI">Tomannsbolig</option>
                                                </select>
                                            </div>
                                            <label class="col-lg-2 col-form-label ionrange-label-fix2">Kontor:</label>
                                            <div class="col-lg-3">

                                                <select class="form-control m-select2 schala-multiselect"
                                                        id="m_solgte_kontorer" name="param" multiple="multiple">
                                                    <option>Bjørvika / Gamle Oslo</option>
                                                    <option>Carl Berner</option>
                                                    <option>Grünerløkka</option>
                                                    <option>Kalbakken</option>
                                                    <option>Oslo Vest</option>
                                                    <option>Sagene</option>
                                                    <option>Torshov</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group m-form__group row">
                                            <label class="col-lg-2 col-form-label ionrange-label-fix2">Byggeår:</label>
                                            <div class="col-lg-3">

                                                <select class="form-control m-select2 schala-multiselect"
                                                        id="m_solgte_byggear" name="param" multiple="multiple">
                                                    <option value="HI">1990</option>
                                                    <option value="HI">1991</option>
                                                    <option value="HI">1992</option>
                                                    <option value="HI">1993</option>
                                                    <option value="HI">1993</option>
                                                    <option value="HI">1994</option>
                                                    <option value="HI">1995</option>
                                                    <option value="HI">1996</option>
                                                    <option value="HI">1997</option>
                                                    <option value="HI">1998</option>
                                                    <option value="HI">1999</option>
                                                </select>
                                            </div>
                                            <label class="col-lg-2 col-form-label ionrange-label-fix2">Megler:</label>
                                            <div class="col-lg-3">

                                                <select class="form-control m-select2 schala-multiselect"
                                                        id="m_solgte_megler" name="param" multiple="multiple">
                                                    <optgroup label="Sagene">
                                                        <option>Ada Kjenner</option>
                                                        <option>Adrian Jensen</option>
                                                        <option>Anders Sveen</option>
                                                        <option>Andreas Ulfsrud</option>
                                                        <option>Anette Borvik</option>
                                                        <option>Anne Christensen</option>
                                                        <option>Anne Grethe Følstad</option>
                                                        <option>Beate Kylstad Larsen</option>
                                                        <option>Berit Holmeide Vaagland</option>
                                                        <option>Bjørnar Mikkelsen</option>
                                                        <option>Brigt Stelander Skeie</option>
                                                        <option>Bård Tisthamar</option>
                                                        <option>Camilla Næss Kopperstad</option>
                                                    </optgroup>
                                                    <optgroup label="Carl Barner">
                                                        <option>Carl Uthus</option>
                                                        <option>Cathrine Haavelsrud</option>
                                                        <option>Duy Vidar Tang</option>
                                                        <option>Elisabeth Skjold</option>
                                                        <option>Emil Månsson</option>
                                                        <option>Erik Bryn Johannessen</option>
                                                        <option>Erik Danielsen</option>
                                                        <option>Eskil Næss hagen</option>
                                                        <option>Espen Anker larsen</option>
                                                        <option>Espen Skaar</option>
                                                        <option>Eva Otnes</option>
                                                        <option>Frederick Horntvedt</option>
                                                        <option>Fredrik Bjerch-andresen</option>
                                                        <option>Helene Molle</option>
                                                        <option>Inge Mysen</option>
                                                        <option>Joachim Schala</option>
                                                        <option>Joakim Torp</option>
                                                        <option>Kjerstin Falkum</option>
                                                        <option>Kristen Brekke</option>
                                                    </optgroup>
                                                    <optgroup label="Toshov">
                                                        <option>Lene Brekken</option>
                                                        <option>Mads Nordahl</option>
                                                        <option>Malin Brorsson</option>
                                                        <option>Marius M. Myren</option>
                                                        <option>Marius Wang</option>
                                                        <option>Mona Irene Tunsli</option>
                                                        <option>Morgan Løveid</option>
                                                        <option>Morten Kvelland</option>
                                                        <option>Oscar André Halsen</option>
                                                        <option>Preben Emil Rasmussen</option>
                                                        <option>Ramin Oddin</option>
                                                        <option>Robin Rodahl</option>
                                                        <option>Sigurd Følstad Skarsem</option>
                                                    </optgroup>
                                                    <optgroup label="Kalbakken">
                                                        <option>Silje Rindahl Krogstad</option>
                                                        <option>Sofie Lund</option>
                                                        <option>Steffen Usterud</option>
                                                        <option>Steinar Hånes</option>
                                                        <option>Stine Charlotte granmo</option>
                                                        <option>Tanju Uysal</option>
                                                        <option>Terje Rindal</option>
                                                        <option>Thomas Karlsen</option>
                                                        <option>Thor Wæraas</option>
                                                        <option>Torbjørn Skjelde</option>
                                                        <option>Torfinn Sørvang</option>
                                                        <option>Vegard Robertsen</option>
                                                        <option>Vidar Tangstad</option>
                                                        <option>Zehra Catak</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <?= $content ?>
            </div>
        </div>
    </div>

</div>

<!-- end:: Page -->

<!-- end:: Body -->
<?php array_pop($departments) ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>