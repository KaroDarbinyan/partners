<?php
/**
 * Give information about access to some parts of the code deppending on user role and other conditions
 */

namespace backend\components;
use common\models\User;
use yii\helpers\Url;
use yii;

/**
 * Allow to
 * Chek if current user has access to spcific sector of code
 * also return the variation of access if last one was provided.
 */
class PermitionControll{
    private static $role;
    private static $areaRoleMap = [
        'softDelete' => [
            'superadmin' => [],
            'director' => ['director',],
            'partner' => ['partner'],
            'broker' => ['broker',],
        ],
        'delegateList' => [
            'superadmin' => [],
            'partner' => ['partner'],
            'director' => ['director'],
            'broker' => ['broker',],
        ],
        'delegate' => [
            'superadmin' => [],
            'partner' => ['partner'],
            'director' => ['director'],
            'broker' => ['broker',],
        ],
        'ufordelt' => [
            'superadmin' => true,
            'director' => true,
            'partner' => true,
            'broker' => false,
        ],
        'clietsList' => [
            'superadmin' => [],
            'director' => ['dep',],
            'partner' => ['dep'],
            'broker' => ['broker',],
        ],
        'leadActions' => [
            'superadmin' => [
                'delegate',
                'log',
                'create_hot_lead',
                'delete',
                'ufordelt',
            ],
            'director' => [
                'delegate',
                'log',
                'create_hot_lead',
                'ufordelt',
            ],
            'partner' => [
                'delegate',
                'log',
                'create_hot_lead',
                'ufordelt',
            ],
            'broker' => [
                'delegate',
                'log',
                'create_hot_lead',
            ],
        ],
    ];

    /**
     * Chek if current user has access to spcific sector of code
     * also return the variation of access if last one was provided
     * @param $lvlName
     * @param array|bool $returnArgs
     * @return mixed|bool
     */
    public static function hasAccess($lvlName, $returnArgs = false){
        $action = "{$lvlName}Avaliblae";
        $action  = method_exists(self::class, $action) ? $action : 'default';
        return forward_static_call_array(
            [self::class, $action],
            [$lvlName, $returnArgs]
        );
    }

    /**
     * Default function for all access zones
     * @param $name
     * @param $args
     * @return bool|mixed
     */
    private static function default($name, $args){
        if(
            !isset(self::$areaRoleMap[$name])
            || !isset(self::$areaRoleMap[$name][self::$role])
        ){return false;}
        if(!$args){return self::$areaRoleMap[$name][self::$role];}
        $return = [];
        foreach (self::$areaRoleMap[$name][self::$role] as $v) {
            if(!isset($args[$v])){continue;}
            $return[]= $args[$v];
        }
        return count($return) ? $return : true;
    }

    /**
     * Init class variables like -
     * $role = current user role
     */
    public static function init(){
        /** @var User $user */
        $user = Yii::$app->user->identity;
        // TODO:: check when department is NULL it must always be inited
        self::$role = $user ?
            ($user->department && $user->department->acting === $user->web_id ?
                ($user->role = User::ACTING_DIRECTOR_ROLE)
                : $user->role
            )
            : false;
    }
}
PermitionControll::init();