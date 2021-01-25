<?php

namespace frontend\modules\api\modules\v1\controllers;

use common\models\Property;
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
class RecentSignedController extends ActiveController
{
    public $modelClass = Property::class;
    public $result = [
        'success' => ['description' => 'test created', 'code' => 201],
        'error' => ['description' => 'invalid object', 'code' => 400]
    ];

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

    public function actionIndex()
    {
        $models = Property::find()->select([
            'web_id',
            'employee_id',
            'address',
        ])->innerJoinWith([
            'propertyDetails' => function ($query) {
                $query->select([
                    'id',
                    'oppdragsnummer',
                    'akseptdato',
                    'solgt',
                    'salgssum',
                    'bokfortprovisjon',
                    'prisantydning',
                    'markedsforingsdato',
                ])->where(['property_details.solgt' => 0]);
            },
        ])->with([
            'propertyDetails.images' => function (\yii\db\ActiveQuery $query) {
                $query->select([
                    'propertyDetailId',
                    'urloriginalbilde',
                    'urlstorthumbnail'
                ])->where(['nr' => 1]);
            },
            'user' => function ($query) {
                $query->select([
                    'web_id',
                    'urlstandardbilde',
                    'navn'
                ]);
            },
        ])->orderBy(['str_to_date(akseptdato, "%d.%m.%Y")' => SORT_DESC])
        ->limit(30)->asArray()->all();

        $results = [];
        foreach ($models as $key => $model) {
            $result = [
                'oppdragsnr' => $model['propertyDetails']['oppdragsnummer'],
                'meglerId' => $model['user']['web_id'],
                'solgtTidspunkt' => $model['propertyDetails']['akseptdato'],
                'opprettet' => $model['propertyDetails']['markedsforingsdato'],
                'adresse' => $model['address'],
                'salgssum' => $model['propertyDetails']['salgssum'],
                'prisantydning' => $model['propertyDetails']['prisantydning'],
                'meglerNavn' => $model['user']['navn'],
                'meglerBilde' => $model['user']['urlstandardbilde'],
                'bokfortprovisjon' => $model['propertyDetails']['bokfortprovisjon'],
                'sumBelopFromBilag' => 0, // TODO: What is this?
            ];

            if (!empty($model['propertyDetails']['images'])) {
                $image = reset($model['propertyDetails']['images']);
                $result['bildeurl1'] = !empty($image['urlstorthumbnail']) ? $image['urlstorthumbnail'] : $image['urloriginalbilde'];
            } else {
                $result['bildeurl1'] = '';
            }

            $results[] = $result;

        }

        return json_encode($results);
    }

}
