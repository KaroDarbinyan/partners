<?php

namespace api\modules\mobile\modules\v1\controllers;

use api\components\ApiResponseHelper;
use api\modules\mobile\modules\v1\exception\UserNotFoundException;
use api\modules\mobile\modules\v1\models\LoginForm;
use api\modules\mobile\modules\v1\models\PropertyDetails;
use api\modules\mobile\modules\v1\models\User;
use common\models\Forms;
use Kreait\Firebase\Database;
use Throwable;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;

/**
 * Auth controller for the `mobile/v1` module
 */
class AuthController extends Controller
{

    /** @var Database $database */
    private $database;

    public function beforeAction($action)
    {
        //$this->database = Yii::$app->firebase->database;
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => CompositeAuth:: class, // Implementing access token authentication
                'except' => ['login'], /// There is no need to validate the access token method. Note the distinction between $noAclLogin
                'authMethods' => [
                    HttpBasicAuth::class,
                    HttpBearerAuth::class,
                    QueryParamAuth::class,
                ],
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formatParam' => 'format',
                'formats' => [
                    'json' => Response::FORMAT_JSON,
                ],
            ]
        ];
    }

    /**
     * @return array|LoginForm
     * @throws BadRequestHttpException
     * @throws UserNotFoundException
     * @throws Throwable
     * @throws Exception
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->bodyParams, '')) {
            if ($auth_params = $model->auth()) {
                //$this->firebaseUpdate($model->user);
                return ApiResponseHelper::responseTemplate(200, [
                    "data" => $auth_params + ["user" => $model->user]
                ]);
            }
            throw new UserNotFoundException(implode(" ", $model->getFirstErrors()), 401);
        }
        $model->validate();
        throw new BadRequestHttpException(implode(" ", $model->getFirstErrors()), 400);
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function actionLogout()
    {
        /** @var User $identity */
        $identity = Yii::$app->user->identity;
        return $identity->logout();
    }

    private function firebaseUpdate(User $user)
    {
        $this->firebasePdUpdate($user);
//        $this->firebaseFormsUpdate($user);
    }

    private function firebasePdUpdate(User $user)
    {
        $reference = $this->database->getReference("eiendom");

        $fb_user = $reference->getChild($user->firebase_id);

        $properties = PropertyDetails::find()
            ->with(['broker1', 'broker2', 'freeText', 'image', 'property'
            ])->andWhere([
                'property_details.arkivert' => 0,
                'property_details.vispaafinn' => -1,
                "property_details.tinde_oppdragstype" => "Til salgs",
                'property_details.ansatte1_id' => $user->web_id
            ])
            ->andWhere(['or',
                ['property_details.solgt' => 0],
                'DATE_ADD(STR_TO_DATE(`property_details`.`akseptdato`, "%d.%m.%Y"), INTERVAL 30 DAY) >= CURRENT_DATE()'
            ])
            ->andWhere(['or',
                ['=', 'property_details.utlopsdato', 0],
                ['>', 'property_details.utlopsdato', time()]
            ])->asArray()->all();

        if (!$properties) return;

        $fb_update = [];
        foreach ($properties as $property) {
            $property["brokers"] = $property["broker1"] + $property["broker2"];
            unset($property["broker1"], $property["broker2"]);

            if (!$property["firebase_id"]) {
                $fb_property = $fb_user->push($property);
                $property["firebase_id"] = $fb_property->getKey();
            }

            $fb_user->getChild($property["firebase_id"])->set($property);
            array_push($fb_update, ["id" => $property["id"], "firebase_id" => $property["firebase_id"]]);
        }

        $db = Yii::$app->db;
        $sql = $db->queryBuilder->batchInsert("property_details", ["id", "firebase_id"], $fb_update);
        $db->createCommand("{$sql} ON DUPLICATE KEY UPDATE id = VALUES(id), firebase_id = VALUES(firebase_id)")->execute();

    }

    private function firebaseFormsUpdate(User $user)
    {

        $reference = $this->database->getReference("forms");

        $fb_user = $reference->getChild($user->firebase_id);


        $forms = Forms::find()
            ->select(["id", "type", "broker_id", "email", "name", "phone", "contact_me", "send_sms",
                "subscribe_email", "target_id", "firebase_id", "created_at", "updated_at"])
            ->where(["broker_id" => $user->web_id])
            ->asArray()->all();

        if (!$forms) return;

        $fb_update = [];
        foreach ($forms as $form) {
            if (!$form["firebase_id"]) {
                $fb_form = $fb_user->push($form);
                $form["firebase_id"] = $fb_form->getKey();

            }
            $fb_user->getChild($form["firebase_id"])->set($form);
            array_push($fb_update, $form);
        }

        $db = Yii::$app->db;
        $form_keys = array_keys($forms[0]);
        $duplicate_keys = [];
        $sql = $db->queryBuilder->batchInsert("forms", $form_keys, $fb_update);
        foreach ($form_keys as $form_key) {
            $duplicate_keys[] = "`{$form_key}` = VALUES(`{$form_key}`)";
        }
        $keys = implode(", ", $duplicate_keys);
        $db->createCommand("{$sql} ON DUPLICATE KEY UPDATE {$keys}")->execute();
    }

}
