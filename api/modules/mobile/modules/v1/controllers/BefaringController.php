<?php


namespace api\modules\mobile\modules\v1\controllers;


use api\components\ApiResponseHelper;
use api\modules\mobile\modules\v1\models\PropertyDetails;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;

class BefaringController extends ActiveController
{


    public $modelClass = PropertyDetails::class;

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
     */
    public function actionDetaljer()
    {
        $id = Yii::$app->request->get("id");

        if (!$id) {
            return ApiResponseHelper::responseTemplate(400, ["error" => ["message" => "Mangler obligatoriske parametere: id."]]);
        }

        $property_details = PropertyDetails::find()
            ->select([
                'property_details.id',
                'property_details.adresse',
                'property_details.postnummer',
                'property_details.prom',
                'property_details.byggeaar',
                'property_details.type_eierformbygninger',
                'property_details.borettslag',
                'property_details.oppdragsnummer',
                'property_details.salgssum',
                'property_details.prisantydning',
                'property_details.prom',
                'property_details.markedsforingsdato',
                'property_details.akseptdato',
                'property_details.befaringsdato'
            ])
            ->with(["images", "neighbors"])
            ->where(['and',
                ['property_details.avdeling_id' => Yii::$app->user->identity->department_id],
                ['or', ['property_details.oppdragsnummer' => $id], ['property_details.id' => $id]]
            ])->asArray()->one();

        if (!$property_details) {
            return ApiResponseHelper::responseTemplate(404, ["error" => ["message" => "The requested resource was not found."]]);
        }

        return ApiResponseHelper::responseTemplate(200, [
            "data" => [
                "eiendom" => $property_details,
                "markers" => PropertyDetails::getMarkers()->asArray()->all()
            ]
        ]);

    }


    /**
     * @return array
     */
    public function actionSingle()
    {
        $id = Yii::$app->request->get("id");

        if (!$id) {
            return ApiResponseHelper::responseTemplate(400, ["error" => ["message" => "Mangler obligatoriske parametere: id."]]);
        }

        $property_details = PropertyDetails::find()
            ->select([
                'property_details.id',
                'property_details.adresse',
                'property_details.postnummer',
                'property_details.prom',
                'property_details.byggeaar',
                'property_details.type_eierformbygninger',
                'property_details.borettslag',
                'property_details.oppdragsnummer',
                'property_details.salgssum',
                'property_details.prisantydning',
                'property_details.prom',
                'property_details.markedsforingsdato',
                'property_details.akseptdato',
                'property_details.befaringsdato'
            ])
            ->with(["images", "neighbors"])
            ->where(['and',
                ['property_details.avdeling_id' => Yii::$app->user->identity->department_id],
                ['or',
                    ['property_details.oppdragsnummer' => $id],
                    ['property_details.id' => $id]
                ]
            ])->asArray()->one();

        if (!$property_details) {
            return ApiResponseHelper::responseTemplate(404, ["error" => ["message" => "The requested resource was not found."]]);
        }

        return ApiResponseHelper::responseTemplate(200, [
            "data" => [
                "eiendom" => $property_details
            ]
        ]);

    }


    /**
     * @return array|mixed
     */
    public function actionEiendommer()
    {
        $activeDataProvider = new ActiveDataProvider([
            'query' => PropertyDetails::find()
                ->with(['image', 'property'])
                ->andWhere(['property_details.avdeling_id' => Yii::$app->user->identity->department_id])
                ->andWhere(['not', ['lat' => null, 'lng' => null]])->asArray(),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $models = $activeDataProvider->getModels();

        $activeDataProvider->setModels($models);
        $pagination = $activeDataProvider->pagination;

        $links = [];
        foreach ($pagination->getLinks(true) as $rel => $url) {
            $links[] = "<$url>; rel=$rel";
        }

        Yii::$app->response->headers
            ->set("X-Pagination-Total-Count", $pagination->totalCount)
            ->set("X-Pagination-Page-Count", $pagination->pageCount)
            ->set("X-Pagination-Current-Page", $pagination->page + 1)
            ->set("X-Pagination-Per-Page", $pagination->pageSize)
            ->set('Link', implode(', ', $links));

        return ApiResponseHelper::responseTemplate(200, [
            "data" => [
                "eiendommer" => $activeDataProvider->getModels()
            ]
        ]);
    }
}