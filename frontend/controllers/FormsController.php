<?php

namespace frontend\controllers;

use ArrayObject;
use common\components\PropertyService;
use common\components\StaticMethods;
use common\components\WebmeglerApiHelper;
use common\models\Boligvarsling;
use Yii;
use common\models\Forms;
use yii\base\InvalidConfigException;
use yii\console\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * FormController implements the CRUD actions for Forms model.
 */
class FormsController extends Controller
{
    private $scenario;

    /**
     * @return string
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionContact()
    {
        //TODO: optimise function
        if (!Yii::$app->request->isAjax) {// Exit if not ajax
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $form = $this->getFormsModel();

        /** @var Forms $form */
        if (
            $form->getScenario() === Forms::SCENARIO_VISNINGLISTE
            && ($form_exist = Forms::findOne([
                'phone' => [// TODO: optimise condition : use only 1 case depending on phone type
                    str_replace('+47', '', $form->phone),
                    "+47{$form->phone}",
                ],
                'target_id' => $form->target_id,
                'type' => $form->type
            ]))
        ) {

            $form->id = $form_exist->id;
            if (!$form->validate()) {
                return Json::encode($form->getErrors());
            }
            $attributes = [
                'name' => $form->name,
                'phone' => $form->phone,
                'type' => $form->type,
                'email' => $form->email,
                'post_number' => $form->post_number,
                'broker_id' => $form->broker_id,
                'target_id' => $form->target_id,
                'subscribe_email' => $form->subscribe_email,
                'contact_me' => $form->contact_me,
                'send_sms' => $form->send_sms
            ];
            Forms::updateAll($attributes, ['id' => $form->id]);
        } else {
            if (!$form->save()) {// Exit if forme wasn't saved
                return Json::encode($form->getErrors());
            }
        }

        if ($form->subscribe_to_related_properties) {
            (new PropertyService)->subscribeToRelated($form);
        }

        return Json::encode($form->getSuccessResponse());
    }

    /**
     * Find exists client by phone number.
     *
     * @return array
     * @throws InvalidConfigException
     */
    public function actionClientData()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $phone = Yii::$app->request->post('phone');

        if (Yii::$app->request->post('type') === 'visningliste') {
            $client = \common\models\Client::find()
                ->filterWhere(['like', 'phone', $phone])
                ->one();

            if ($client) {
                return [
                    'success' => true,
                    'client' => [
                        'name' => ligatures($client->name, true),
                        'post_number' => $client->post_number,
                    ]
                ];
            }
        }

        $username = 'involve';
        $password = 'anMbyR34RBfA';
        $phone = strpos($phone,'+') === false ? "+47{$phone}" : $phone;// use NO as default region
        $httpClient = new Client(['baseUrl' => 'https://api.nrop.no/nrop/' . $phone]);
        $response = $httpClient->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setMethod('GET')
            ->addHeaders(['Authorization' => 'Basic ' . base64_encode($username . ':' . $password)])
            ->addData(['username' => $username, 'password' => $password])->send();

        $data = Json::decode($response->content);

        if (isset($data['code'])) {
            return [
                'success' => false,
                'message' => $data['message']
            ];
        }

        return [
            'success' => true,
            'data' => $data,
            'client' => [
                'name' => ucfirst(strtolower($data['firstName'])) . ' ' . ucfirst(strtolower($data['lastName'])),
                'post_number' => $data['postalCode']
            ]
        ];
    }

    /**
     * @return Forms
     */
    private function getFormsModel()
    {
        $model = new Forms();
        $data = Yii::$app->request->post();

        if (isset($data['Forms']) && isset($data['Forms']['megler_booking_date'])) {
            $data['Forms']['message'] = "Kunden ønsker å møte {$data['Forms']['megler_booking_date']}";
        }

        $scenarios = [
            'book_visning' => Forms::SCENARIO_BOOKING_VISNING,
            'meglerbooking' => Forms::SCENARIO_MEGLER_BOOKING,
            'contact' => Forms::SCENARIO_KONTAKT_MEG,
            'salgssum_venter' => Forms::SCENARIO_SALGSSUM,
            'salgssum_landing' => Forms::SCENARIO_SALGSSUM,
            'budvarsel' => Forms::SCENARIO_BUDVARSEL,
            'visningliste' => Forms::SCENARIO_VISNINGLISTE,
            'salgsoppgave' => Forms::SCENARIO_SALGSOPPGAVE,
        ];

        $scenario = !empty($data['Forms']['type']) && isset($scenarios[$data['Forms']['type']]) ?
            $scenarios[$data['Forms']['type']] : Forms::SCENARIO_OTHER
        ;
        $model->setScenario($scenario);

        $model->load($data);

        //$model->phone = strpos($model->phone,'+') === false ? "+47{$model->phone}" : $model->phone;
        $model->token = StaticMethods::generateToken(15);
//        $model->booking_date = !$model->booking_date ? null
//            : preg_replace('/\s+/', '', str_replace('kl', '', $model->booking_date));
        return $model;
    }

    /**
     * Check token and redirect to associated form on admin
     * @param $token
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionVerify($token)
    {
        $form = Forms::findOne(['token' => $token]);

        if ($form) {
            $url = 'https://intra.partners.no/admin/clients/check-url?' . http_build_query([
                'lead_id' => $form->id,
                'token' => $form->token
            ]);

            return $this->redirect($url);
        }

        throw new NotFoundHttpException('Beklager, denne lead har allerede blitt delegert til Turshow-kontoret.');
    }


    public function actionUnsubscribe($id, $code)
    {
        $form = Boligvarsling::findOne($id);

        if (!$form || (md5($form->id . $form->email) != $code) || !$form->subscribe) {
            return $this->goHome();
        } else {
            $form->subscribe = 0;
            $form->save(false);
        }

        Yii::$app->view->params['page'] = 'unsubscribe';

        return $this->render('unsubscribe');
    }

    /**
     * Display a listing of the subscriptions.
     *
     * @param null $hash
     * @return string
     *
     * @throws NotFoundHttpException
     * @throws InvalidConfigException
     */
    public function actionSubscriptions($hash = null)
    {
        $encryptor = Yii::$app->getSecurity();

        if (!$email = $encryptor->validateData($hash, 'boligvarsling')) {
            throw new NotFoundHttpException('Side ikke funnet!');
        }

        $subscriptions = Boligvarsling::find()
            ->where(['email' => $email])
            ->all();

        $request = Yii::$app->request;

        if ($request->isAjax && $request->isPost) {
            foreach ($subscriptions as $subscription) {
                if ($subscription->id == $request->post('id')) {
                    $subscription->updateAttributes([
                        'subscribe' => !$subscription->subscribe
                    ]);
                }
            }

            return Json::encode([]);
        }

        return $this->render('subscriptions', compact('subscriptions'));
    }

}
