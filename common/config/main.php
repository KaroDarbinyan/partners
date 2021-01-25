<?php

use yii\helpers\Url;
use yii\web\Cookie;

return [
    'on beforeRequest' => function () {
        if (is_console()) {
            return;
        }

        $request = Yii::$app->request;

        // Referrer contains the outside url.
        if (strpos($request->referrer, $request->hostInfo) === false) {
            $cookies = Yii::$app->response->cookies;

            $cookies->add(new Cookie([
                'name' => 'referrer',
                'value' => $request->referrer
            ]));
        }

        $pathInfo = $request->pathInfo;

        if (!empty($pathInfo) && (strpos($pathInfo, '//') !== false || preg_match('/\/$/', $pathInfo))) {
            $url = preg_replace('/\/+/', '/', rtrim($pathInfo, '/'));
            $correctUrl = Url::to(!empty($url) ? $url : Url::home(), true);

            header('HTTP/1.1 301 Moved Permanently');
            header("Location: {$correctUrl}");

            exit();
        }
    },
    'language' => 'nb-NO',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [

        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'nb'
                ],
            ],
        ],

        'firebase' => [
            'class' => 'api\components\FirebaseHelper',
            'databaseUri' => "https://intra-78df4.firebaseio.com",
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
           // 'cache' => 'cache'
        ],
        'mobileDetect' => [
            'class' => 'Mobile_Detect'
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;port=3310;dbname=schala_db',
            'username' => 'schala',
            'password' => 'F3m3E8y0',
            'charset' => 'utf8',
        ],
        'WebmeglerApiHelper' => [
            'class' => 'common\components\WebmeglerApiHelper',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],


    ],
];
