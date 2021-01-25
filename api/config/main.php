<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'mobile' => [
            'class' => 'api\modules\mobile\Module',
            'modules' => [
                'v1' => [
                    'class' => 'api\modules\mobile\modules\v1\Module',
                ]
            ],
        ],
        'v1' => [
            'class' => 'api\modules\v1\Module',
        ]
    ],
    'components' => [
        'request' => [
            'baseUrl' => '/api',
            'enableCsrfValidation' => false,
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'formatters' => [
                'json' => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'api\modules\mobile\modules\v1\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'mobile/v1',
                    'extraPatterns' => [
                        'GET ' => 'test/index',
                        // AuthController
                        'POST login' => 'auth/login',
                        'POST logout' => 'auth/logout',
                        // EiendomController
                        'GET eiendommer' => 'eiendom/index',
                        'GET eiendommer/<page:\w+>' => 'eiendom/index',
                        'GET annonse/<id:\w+>' => 'eiendom/view',
                        'GET eiendom/save' => 'eiendom/save',
                        // LeadController
                        'POST contact' => 'lead/contact',
                        'POST contacts-offline' => 'lead/contacts-offline',
                        'POST lead/autofill' => 'lead/autofill',
                        // UserController
                        'GET user/list' => 'user/list',
                        'GET user/info/<id:\w+>' => 'user/info',
                        // BefaringController
                        'GET befaring/oppdrag/eiendommer' => 'befaring/eiendommer',
                        'GET befaring/oppdrag/eiendommer/<page:\w+>' => 'befaring/eiendommer',

                        'GET befaring/oppdrag/detaljer' => 'befaring/detaljer',
                        'GET befaring/oppdrag/detaljer/<id:\w+>' => 'befaring/detaljer',

                        'GET befaring/oppdrag/single' => 'befaring/single',
                        'GET befaring/oppdrag/single/<id:\w+>' => 'befaring/single',
                    ],
                    'pluralize' => false
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/lead',
                        'v1/recent-sold',
                        'v1/recent-signed',
                        'v1/megler-sales',
                        'v1/avdeling-sales',
                        'v1/konsern-sales',
                    ],
                    'pluralize' => false
                ],
            ],
        ]
    ],
    'params' => $params,
];



