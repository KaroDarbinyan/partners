<?php

use yii\helpers\Url;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
//settings
return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'language' => 'nb-NO',
    'modules' => [
        'api' => [
            'class' => 'frontend\modules\api\Module',
            'modules' => [
                'v1' => [
                    'class' => 'frontend\modules\api\modules\v1\Module',
                ]
            ],
        ],
    ],
    'components' => [
        'assetManager' => [
            'appendTimestamp' => true
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'api/v1/lead'
                    ],
                    'pluralize' => false
                ],
                'verify/<token:\w+>' => 'forms/verify',
                'search' => 'site/search',
                // 'ansatte' => 'company/employees',
                // 'ansatte/<id:\d+>' => 'company/employees',
                'ansatte/<navn:>' => 'company/broker',
                'annonse/<id:\d+>' => 'dwelling/detail',
                'solgt/<id:\d+>' => 'dwelling/sold',
                'webmegler-serach' => 'webmegler-serach/index',
                'salgsprosessen' => 'sell/sales-process',
                'verdivurdering' => 'sell/valuation',
                'etakst' => 'sell/etakst',
                'pristilbud' => 'sell/price-offer',
                'meglerbooking' => 'booking/megler',
                'meglerbooking-v1' => 'booking/megler-v1',
                [
                    'pattern' => 'eiendom/<id:\d+>',
                    'route' => 'dwelling/detail',
                    'defaults' => ['forceView' => true,],
                ],
                'eiendommer/filter' => 'buy/dwelling-filter',
                'eiendommer/reklame' => 'buy/reklame',
                'eiendommer' => 'buy/dwelling',
                'eiendommer/<id:\d+>' => 'redirect/to',
                'eiendommer/<id:\d+>-<slug:\S+>' => 'properties/show',
                'kontor/<slug:\S+>/hvilepulsgaranti' => 'department/warranty',
                'kontor/<slug:\S+>/selge' => 'department/sell',

                /**
                 * Redirects
                 */
                '<id:\d+$>' => 'redirect/to',
                '<id:\d{2}-\d{2}-\d{4}>' => 'redirect/to',
                'nybygg' => 'redirect/new-properties',
                'sok/til-salgs' => 'redirect/properties',
                'sok/kontorer' => 'redirect/offices',
                'medlem/<slug:\S+>' => 'redirect/partner',
                'salgsoppgave/<id:\d+>' => 'redirect/salgsoppgave',
                [
                    'pattern' => 'kampanje/aursnes-boligselger-ung',
                    'route' => 'redirect/kontor',
                    'defaults' => ['slug' => 'alesund']
                ],
                [
                    'pattern' => 'drammen',
                    'route' => 'redirect/kontor',
                    'defaults' => ['slug' => 'drammen']
                ],
                'office/<slug:\S+>' => 'redirect/kontor',
                'kontor/<slug:\S+>/<id:\d+>' => 'redirect/property',
                'kontor/<slug:\S+>/<partner:\S+>' => 'redirect/office',
                'nyheter/?' => 'redirect/news',
                'kontakt-oss' => 'redirect/kontakt',
                [
                    'pattern' => 'eiendommer/nybygg',
                    'route' => 'buy/dwelling',
                    'defaults' => ['newBuildings' => true]
                ],
                [
                    'pattern' => 'eiendommer/alle',
                    'route' => 'buy/dwelling',
                    'defaults' => ['archives' => true]
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'route' => 'test/<action>',
                    'pattern' => '<action:index|main|ok>',
                ],

                'befaring/<id:\d+>' => 'befaring/index',
                'befaring/like/<id:\d+>' => 'befaring/like',
                'befaring/calendar/<id:\d+>' => 'befaring/calendar',
                'befaring/oppdrag/<view:\w+>/<id:\d+>' => 'befaring/oppdrag',
                'befaring/node/<id:\d+>' => 'befaring/node',
                'befaring/dit-team/<id:\d+>' => 'befaring/dit-team',
                'befaring/potential-clients/<id:\d+>' => 'befaring/potential-clients',

                'visning/<id:\d+>' => 'dwelling/visning',

                'boligvarsling' => 'dwelling/form',
                'kontorer' => 'company/offices',

                'kontor/<name:\S+>' => 'company/office',
                'partner/<slug:\S+>' => 'company/partner',

                'om-oss' => 'company/about-us',
                'jobb' => 'company/working-here',
                'kontakt' => 'company/contact-us',
                'personvern' => 'company/privacy',
                'personvern2' => 'company/privacy2',
                'kontor-ansatte' => 'company/office-employees',
                'budvarsel' => 'dwelling/contact',
                'interested' => 'dwelling/add-phone-contact',
                '' => 'site/index',
                'filter-notification' => 'buy/filter-notification',
                'check-url/<t:\w+>' => 'forms/check-url',
                'unsubscribe/<id:\d+>/<code:\w+>' => 'forms/unsubscribe',
                'salgsoppgave/<id:\d+>.pdf' => 'dwelling/pdf',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
                '\S+/<id:\d+>/\S+/\S+' => 'redirect/to'
            ],
        ],

    ],
    'params' => $params,
];
