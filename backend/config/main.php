<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$config = [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin',
            'enableCsrfValidation' => false,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
            'class' => 'yii\web\DbSession',
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
                //'home' => 'site/home',
                'search-locations' => 'site/search-locations',
                'send-sms' => 'site/send-sms',
                'theme/<color:\w+>' => 'site/theme',
                'befaring' => 'site/befaring',
                'reset-password/<token:[\wd-]+>' => 'site/reset-password',
                'embed/<id:\d+>' => 'statistikk/embed',
                'mailing' => 'site/mailing',
                'calendar-event' => 'innstillinger/calendar-event-index',
                'calendar-event/view/<id:\d+>' => 'innstillinger/calendar-event-view',
                'calendar-event/update/<id:\d+>' => 'innstillinger/calendar-event-update',
                'calendar-event/delete/<id:\d+>' => 'innstillinger/calendar-event-delete',
                'clients/toggle-type/<id:\d+>' => 'clients/toggle-type',
                'clients/soft-delete/<id:\d+>' => 'clients/soft-delete',
                'clients/boligvarsling/<id:\d+>/edit' => 'clients/boligvarsling-edit',
                // TODO: ask why are there  routes to another controller

                [
                    'patternPrefixes' => ['office', 'user', 'partner'],// prefix/<prefix:\w+>/
                    'pattern' => [
                        '<controller:[\wd-]+>/<action:[\wd-]+>/<page:[\wd-]+>/<id:\d+>',
                        '<controller:[\wd-]+>/<action:[\wd-]+>/<id:\d+>',
                        '<controller:[\wd-]+>/<action:[\wd-]+>/',// office/'<office:\w+>/oppdrag/index' => 'oppdrag/index',
                    ],
                    'route' => '<controller>/<action>',
                ],
            ],
        ],
        /*'urlManagerFrontend' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
            ],
        ],*/

        'partnerService' => [
            'class' => 'backend\components\PartnerService',
            'cacheDuration' => 7200
        ],

        'departmentService' => [
            'class' => 'backend\components\DepartmentService',
            'cacheDuration' => 7200
        ],

    ],
    'params' => $params,
];


// Init prefices combinations
// TODO: extend for other paterns postfix and etc.
$rules = $config['components']['urlManager']['rules'];
foreach ($config['components']['urlManager']['rules'] as $p => $rule) {
    if(!is_array($rule) || !isset($rule['patternPrefixes'])){continue;}
    foreach ($rule['pattern'] as $pat) {
        // Add prefixed patterns
        foreach ($rule['patternPrefixes'] as $patternPrefix) {
            $pattern = "{$patternPrefix}/<{$patternPrefix}:\w+>/{$pat}";
            $rules[$pattern] = $rule['route'];
        }
        $rules[$pat] = $rule['route'];
    }
    unset($rules[$p]);
}
$config['components']['urlManager']['rules'] = $rules;
return $config;