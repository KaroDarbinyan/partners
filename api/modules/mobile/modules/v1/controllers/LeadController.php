<?php

namespace api\modules\mobile\modules\v1\controllers;


use api\components\ApiResponseHelper;
use common\components\WebmeglerApiHelper;
use common\models\Forms;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\httpclient\Client;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;

/**
 * Lead controller for the `mobile/v1` module
 */
class LeadController extends Controller
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => HttpBearerAuth:: class, // Implementing access token authentication
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
     * @return array
     * @throws \Matrix\Exception
     */
    public function actionContactsOffline()
    {
        $saved = 0;
        $not_saved = 0;
        try {
            $bodyParams = Yii::$app->request->bodyParams;
            if (!$bodyParams) {
                throw new BadRequestHttpException();
            }
            foreach ($bodyParams as $bodyParam) {
                $form = $this->leadInit($bodyParam);

                if ($form->save()) $saved++;
                else $not_saved++;

                if (in_array($form->getScenario(), [Forms::SCENARIO_VISNINGLISTE, Forms::SCENARIO_BUDVARSEL]) || $form->type == 'salgsoppgave') {
                    $apiHelper = new WebmeglerApiHelper();
                    $apiHelper->registerInteressent($form->toArray());
                }
            }
        } catch (BadRequestHttpException $e) {
            return ApiResponseHelper::responseTemplate(400, ["error" => ["message" => "Invalid JSON data in request body"]]);
        }

        return ApiResponseHelper::responseTemplate(200, [
            "data" => [
                "saved" => $saved,
                "not_saved" => $not_saved,
            ]
        ]);
    }


    /**
     * @return array
     * @throws \Matrix\Exception
     */
    public function actionContact()
    {
        try {
            $bodyParam = Yii::$app->request->bodyParams;

            if (!array_key_exists("phone", $bodyParam)) {
                throw new BadRequestHttpException("Invalid JSON data in request body");
            }

            $form = $this->leadInit($bodyParam);

            if (!$form->validate() || !$form->save()) {
                return ApiResponseHelper::responseTemplate(400, ["error" => $form->getFirstErrors()]);
            }

        } catch (BadRequestHttpException $e) {
            return ApiResponseHelper::responseTemplate(400, ["error" => ["message" => $e->getMessage()]]);
        }

        if (in_array($form->getScenario(), [Forms::SCENARIO_VISNINGLISTE, Forms::SCENARIO_BUDVARSEL]) || $form->type == 'salgsoppgave') {
            $apiHelper = new WebmeglerApiHelper();
            $apiHelper->registerInteressent($form->toArray());
        }


        return ApiResponseHelper::responseTemplate(200);

    }


    /**
     * @param $attributes
     * @return Forms
     */
    private function leadInit($attributes)
    {
        $form = new Forms();
        if (isset($attributes["adress"]) && $attributes["adress"]) $form->address = $attributes["adress"];
        if (isset($attributes["postCode"]) && $attributes["postCode"]) $form->post_number = $attributes["postCode"];

        unset($attributes["postCode"], $attributes["adress"]);

        $form->updateAttributes($attributes);
        $form->phone = substr($attributes["phone"], 0, 3) === '+47' ? $attributes["phone"] : '+47' . $attributes["phone"];
        $form->type = "visningliste";
        $form->setScenario(Forms::SCENARIO_VISNINGLISTE);

        return $form;
    }


    public function actionAutofill()
    {
        if ($phone = Yii::$app->request->post('phone')) {
            $username = 'involve';
            $password = 'anMbyR34RBfA';
            $phone = strpos($phone, '+') === false ? "+47{$phone}" : $phone;// use NO as default region
            $client = new Client(['baseUrl' => 'https://api.nrop.no/nrop/' . $phone]);
            $response = $client->createRequest()
                ->setFormat(Client::FORMAT_JSON)
                ->setMethod('GET')
                ->addHeaders(['Authorization' => 'Basic ' . base64_encode($username . ':' . $password)])
                ->addData(['username' => $username, 'password' => $password])->send();
            $content = json_decode($response->content, true);

            if ((isset($content["code"]) || isset($content["message"]))) {
                Yii::$app->response->statusCode = 404;
                $response_params = [
                    "error" => [
                        "message" => "Phone not found"
                    ]
                ];
            } else {
                $response_params = [
                    "data" => [
                        "autofill" => [
                            "name" => preg_replace(['/\s+/'], ' ', "{$content["firstName"]} {$content["middleName"]} {$content["lastName"]}"),
                            "address" => $content["address"],
                            "postalCode" => $content["postalCode"],
                            "city" => $content["city"]
                        ]
                    ]
                ];
            }
        } else {
            Yii::$app->response->statusCode = 400;
            $response_params = [
                "error" => [
                    "message" => "Invalid JSON data in request body."
                ]
            ];
        }

        return ApiResponseHelper::responseTemplate(Yii::$app->response->statusCode, $response_params);

    }


}
