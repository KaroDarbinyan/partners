<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\components;
use yii\helpers\Url;
use yii;

/**
 * Work same as Url::toRoute() but add user or office if the last ones are passed to current route
 */
class UrlExtended extends Url
{
    private static $currentUser = false;
    private static $currentOffice = false;
    private static $currentPartner = false;

    /**
     * Init class
     */
    public static function init()
    {
        self::$currentOffice = Yii::$app->request->get('office');
        self::$currentUser = Yii::$app->request->get('user');
        self::$currentPartner = Yii::$app->request->get('partner');
    }

    /**
     * Extended version of Url::toRoute(), add params office and user to route
     * if the last ones presist in request params
     * @param array|string $route
     * @param bool $scheme
     * @return string
     */
    public static function toRoute($route, $scheme = false)
    {
        if (!isset($route['user'])
            && !isset($route['office'])
            && $user = Yii::$app->request->get('user')){
            $route['user'] = $user;
        }elseif (!isset($route['office']) && $office = Yii::$app->request->get('office')){
            $route['office'] = $office;
        }elseif (!isset($route['partner']) && $partner = Yii::$app->request->get('partner')){
            $route['partner'] = $partner;
        }
        return parent::toRoute($route, $scheme = false);
    }

    /**
     * Extended version of Url::toRoute(), add params which must be added
     * if the last ones presist in request params
     * @param array|string $route
     * @param bool $scheme
     * @return string
     */
    public static function toRouteAddaptive($route, $scheme = false)
    {
        if (!isset($route['id']) && ($id = Yii::$app->request->get('id')) ){
            $route['id'] = $id;
        }
        return parent::toRoute($route, $scheme = false);
    }


}
UrlExtended::init();