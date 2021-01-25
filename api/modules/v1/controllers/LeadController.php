<?php

namespace api\modules\v1\controllers;

use common\models\Forms;
use Yii;
use yii\base\Exception;
use yii\filters\ContentNegotiator;
use yii\helpers\FileHelper;
use yii\rest\ActiveController;
use yii\web\Response;
use Firebase\JWT\JWT;

/**
 * Default controller for the `lead` module
 */
class LeadController extends ActiveController
{

    public $modelClass = Forms::class;
    public $result = [
        'successTest' => ['description' => 'test success', 'code' => 201],
        'success' => ['description' => 'lead created', 'code' => 201],
        'error' => ['description' => 'invalid object', 'code' => 400]
    ];

    public $publicKey = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9zY2hhbGEtZGV2LmRvbWFpbnMuaW52b2x2ZS5ub1wvIiwiaWF0IjoxNTY0NTgxMDI5LCJuYmYiOjE1NjQ1ODEwMzQsImV4cCI6MTU2OTc2NTAzNH0.V9uF6cym87YGOIQ5jxizz2PC3DFAFQxp1r0I_yU4AQA';

    private $token = 'schala-dev2019';

    private function generateJwtKey($key)
    {
        $now = time();
        $token = [
            "iss" => "http://schala-dev.domains.involve.no/",
            "iat" => $now,
            "nbf" => $now + 5,
            "exp" => $now + 5184000            // Adding 60 Days
        ];

        return JWT::encode($token, $key);
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['delete'], $actions['update'], $actions['create']);
        return $actions;
    }

    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formatParam' => 'format',
                'formats' => [
                    'raw' => Response::FORMAT_RAW,
                ],
            ],
        ];
    }

    /**
     * @return false|string
     * @throws Exception
     */
    public function actionCreate()
    {
        if (!Yii::$app->request->isPost) {
            return json_encode($this->result['error']);
        }
        $data = Yii::$app->request->post();
        $typeMap = [
            "skal_selge" =>"skal_selge",
            "residence"  =>"skal_selge",
            "leisure"    =>"skal_selge",
            "property"   =>"skal_selge",
            "office"     =>"skal_selge",
            "commercial" =>"skal_selge",
            "appartments"=>"skal_selge",
            "industrial" =>"skal_selge",
            "land"       =>"skal_selge",
            "other"      =>"skal_selge",
            "appraisal"  =>"verdivurdering",
            "verdivurdering"  =>"verdivurdering",
        ];
        $type = "UNKNOWN";
        foreach ($data['type'] as $t) {
            if(!isset($typeMap[$t])){continue;}
            $type = $typeMap[$t];
            if ('skal_selge' == $type){break;}
        }
        $model = new Forms();
        $model->setScenario(Forms::SCENARIO_API);
        $model->source = isset($data['company']) ? $data['company'] : 'eiendomsmegler.no';
        $model->source = (strpos($model->source, '://') ? '' : 'http://') . $model->source;
        $model->referer_source = $model->source;
        $model->type   = $type;

        $modelDataMap = [
            'phone'         => 'phone',
            'email'         => 'email',
            'name'          => 'name',
            'post_number'   => 'zip',
            'address'       =>  'address',
            'message'       =>  'message',
        ];
        $errorReport = [];
        foreach ($modelDataMap as $modelAttr=> $dataAttr) {
            if(!isset($data[$dataAttr])){
                $errorReport[] = "<{$dataAttr}> is missing";
                continue;
            }
            $model->setAttribute($modelAttr, $data[$dataAttr]);
        }

        if(count($errorReport)){
            return json_encode($errorReport);
        }

        // Must be removed
        // $model->message = isset($data['company']) ?
        //     "Kommentar: {$model->address} {$model->message}\n" .
        //     implode(',', $data['type'])
        //     : $data['message'];

        if (Yii::$app->params['apiTestingEmail'] == $model->email){
            return json_encode($this->result['successTest']);
        }

        if ($model->save()) {
            $this->addLog($data);
            return json_encode($this->result['success']);
        }
        return json_encode($this->result['error']);
    }

    /**
     * @param $lead
     * @throws Exception
     */
    private function addLog($lead)
    {
        $dirs = [
            "runtime", "logs", "v1", "lead"
        ];

        $directory = Yii::$app->basePath . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $dirs);
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }
        $file = $directory . DIRECTORY_SEPARATOR . 'lead.log';
        $lead = ['id' => time()] + $lead;
        $text = json_encode($lead) . ";\n";
        $fOpen = fopen($file, 'a');
        fwrite($fOpen, $text);
        fclose($fOpen);
    }


}
