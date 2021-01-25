<?php

namespace backend\controllers;

use common\models\Department;
use common\models\Partner;
use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * Role controller
 */
class RoleController extends Controller
{
    /**
     * Check user role and access to current page and add request param related to user.
     *
     * @return void
     */
    public function init()
    {
        if ($user = Yii::$app->user->identity) {
            $method = Inflector::variablize($user->role) . 'HasAccess';

            if (!method_exists($this, $method)) {
                $method = 'guestHasAccess';
            }

            $canView = $this->{$method}();

            if (!$canView) {
                $this->redirect(['/404']);
            }
        }

        parent::init();
    }

    /**
     * check if brokker has acess to this page ( for user )
     * @return bool
     */
    private function brokerHasAccess(){
        $req = Yii::$app->request;
        if ($req->get('office')){// Broker has no access to office filter
            return false;
        }
        /** @var User $user */
        $user = Yii::$app->user->identity;
        if($requestedUser = $req->get('user')){// Broker has access to his filter only
            return $requestedUser === $user->url;
        }else{// broker will be add broker url to get request
            $get = $req->get();
            $get['user'] = $user->url;
            $req->setQueryParams($get);
            return true;
        }

    }

    /**
     * check if director has acess to this page ( for user or office )
     * @return bool
     */
    private function actingDirectorHasAccess(){
        /** @var User $user */
        $user =  Yii::$app->user->identity;
        $req = Yii::$app->request;
        if ($avalibaleTargets = $req->get('user')){//if choosen user is one of the director office brokers
            return boolval(User::findOne([
                'web_id'=>$user->web_id,
                'url'=>$avalibaleTargets,
            ]));
        }elseif ($avalibaleTargets = $req->get('office')){// if logged user is acting director of choosen office
            return boolval(Department::findOne([
                'acting' => $user->web_id,
                'url' => $avalibaleTargets
            ]));
        }else{
            $get = $req->get();
            $get['user'] = $user->url;
            $req->setQueryParams($get);
            return true;
        }
    }

    /**
     * check if director has acess to this page ( for user or office )
     * @return bool
     */
    private function directorHasAccess(){
        /** @var User $user */
        $user =  Yii::$app->user->identity;
        $req = Yii::$app->request;
        $result = true;
        if ($avalibaleTargets = $req->get('user')){//if choosen user is one of the director office brokers
            return boolval(User::findOne([
                'id_avdelinger'=>$user->id_avdelinger,
                'url'=>$avalibaleTargets,
            ]));
        } elseif ($office = $req->get('office')){// if choosen office is directors office
            return boolval(Department::findOne([
                'web_id' => $user->id_avdelinger,
                'url' => $office
            ]));
        }else{
            $get = $req->get();
            $get['user'] = $user->url;
            $req->setQueryParams($get);
            return true;
        }
    }

    /**
     * check if director has acess to this page ( for user or office )
     * @return bool
     */
    private function partnerHasAccess(){
        /** @var User $user */
        $user =  Yii::$app->user->identity;
        $req = Yii::$app->request;
        $result = true;
        
        if ($requestedTargets = $req->get('user')){//if choosen user is one of the director office brokers
            return boolval(User::find()
                ->joinWith(['partner'])
                ->where([
                    'partner.id'=>$user->partner->id,
                    'user.url'=>$requestedTargets,
                ])->one()
            );
        }elseif ($requestedTargets = $req->get('office')){// if choosen office is directors office
            return boolval(Department::findOne([
                'partner_id' => $user->partner->id,
                'url' => $requestedTargets
            ]));
        }elseif ($requestedTargets = $req->get('partner')){// if choosen office is directors office
            return Partner::find()->where(['and',
                ['or',
                    ['leader_id' => $user->web_id],
                    ['id' => $user->partner->id]
                ],
                ['url' => $requestedTargets]
            ])->exists();
        }else{
            $get = $req->get();
            $get['user'] = $user->url;
            $req->setQueryParams($get);
            return true;
        }
    }
    /**
     * check if super admin has access to this page
     * @return bool
     */
    private function superadminHasAccess(){
        return true;
    }

    /**
     * check if guest has access to this page
     * @return bool
     */
    private function guestHasAccess(){
        return false;
    }
}
