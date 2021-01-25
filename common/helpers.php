<?php

if (!function_exists('money')) {
    function money($value)
    {
        return number_format($value, 0, ' ', ' ') . ',-';
    }
}

if (!function_exists('ligatures')) {
    function ligatures($text, $decode = false)
    {
        $from = ['Ø', 'ø', 'Å', 'å', 'ü', 'Ü', 'æ', 'Æ', '&'];
        $to = ['&#216;', '&#248;', '&#197;', '&#229;', '&#252;', '&#220;', '&#230;', '&#198;', '&amp;'];

        if ($decode) {
            return str_replace($to, $from, $text);
        }

        return str_replace($from, $to, $text);
    }
}

if (!function_exists('clean')) {
    function clean($html)
    {
        $html = html_entity_decode($html);

        return \yii\helpers\HtmlPurifier::process($html, [
            'AutoFormat.RemoveEmpty' => true,
            'HTML.Allowed' => 'div[class|id],p[class],b[class]'
        ]);
    }
}

if (!function_exists('is_console')) {
    function is_console()
    {
        return Yii::$app instanceof \yii\console\Application;
    }
}

if (!function_exists('user')) {
    function user()
    {
        return Yii::$app->user->identity;
    }
}

if (!function_exists('request')) {
    function request()
    {
        return Yii::$app->request;
    }
}

if (!function_exists('response')) {
    function response()
    {
        return Yii::$app->response;
    }
}
