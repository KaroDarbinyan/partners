<?php

namespace api\modules\mobile\modules\v1\controllers;


use api\modules\mobile\modules\v1\exception\EiendomNotFoundException;
use api\modules\mobile\modules\v1\models\PropertyDetails;
use Kreait\Firebase\Database;
use Kreait\Firebase\Database\Reference;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\Response;

/**
 * Eiendom controller for the `mobile/v1` module
 */
class EiendomController extends ActiveController
{

    public $modelClass = PropertyDetails::class;

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

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['view']);
        return $actions;
    }


    public function actionIndex()
    {
        $activeDataProvider = new ActiveDataProvider([
            'query' => PropertyDetails::getFilteredProperties(),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $models = $activeDataProvider->getModels();

        foreach ($models as $key => $model) {
            $models[$key]["brokers"] = [];

            if ($model["broker1"]) array_push($models[$key]["brokers"], $model["broker1"]);
            if ($model["broker2"]) array_push($models[$key]["brokers"], $model["broker2"]);

            unset($models[$key]["broker1"], $models[$key]["broker2"]);
        }

        $activeDataProvider->setModels($models);

        return $activeDataProvider;

    }

    public function actionView($id)
    {
        $property_details = PropertyDetails::find()
            ->select([
                'property_details.id',
                'property_details.solgt',
                'property_details.kommuneomraade',
                'property_details.prisantydning',
                'property_details.overskrift',
                'property_details.prisantydning',
                'property_details.prissamletsum',
                'property_details.fellesutgifter',
                'property_details.kommentarleie',
                'property_details.totalkostnadsomtall',
                'property_details.totalomkostningsomtall',
                'property_details.type_eiendomstyper',
                'property_details.prom',
                'property_details.bruksareal',
                'property_details.bruttoareal',
                'property_details.etasje',
                'property_details.antallrom',
                'property_details.oppholdsrom',
                'property_details.soverom',
                'property_details.byggeaar',
                'property_details.energimerke_farge',
                'property_details.energimerke_bokstav',
                'property_details.gaardsnummer',
                'property_details.bruksnummer',
                'property_details.fylkesnummer',
                'property_details.finn_orderno',
                'property_details.kommuneomraade',
                'property_details.overskrift',
                'property_details.adresse',
                'property_details.urlelektroniskbudgivning',
                'property_details.andelfellesgjeld',
                'property_details.ligningsverdi',
                'property_details.ansatte1_id',
                'property_details.ansatte2_id',
                'property_details.endretdato',
                'property_details.modernisert',
            ])
            ->with(["images", "broker1", "broker2"
            ])
            ->where(['and',
                ['property_details.avdeling_id' => Yii::$app->user->identity->department_id],
                ['or', ['property_details.oppdragsnummer' => $id], ['property_details.id' => $id]]
            ])->asArray()->one();

        if (!$property_details) {
            throw new EiendomNotFoundException('The requested resource was not found.', 404);
        }

        $property_details["brokers"] = [];

        if ($property_details["broker1"]) array_push($property_details["brokers"], $property_details["broker1"]);
        if ($property_details["broker2"]) array_push($property_details["brokers"], $property_details["broker2"]);

        unset($property_details["broker1"], $property_details["broker2"]);

        return $property_details;
    }


    public function actionSave()
    {
        $this->save(0);
    }

    private function save($offset)
    {
        $limit = 20;
        $props = PropertyDetails::find()->with([
            'freeText',
            'image',
            'property'
        ])
            ->andWhere([
                'property_details.arkivert' => 0,
                'property_details.vispaafinn' => -1,
                "property_details.tinde_oppdragstype" => "Til salgs",
            ])
            ->andWhere(['or',
                ['property_details.solgt' => 0],
                'DATE_ADD(STR_TO_DATE(`property_details`.`akseptdato`, "%d.%m.%Y"), INTERVAL 30 DAY) >= CURRENT_DATE()'
            ])
            ->andWhere(['or',
                ['=', 'property_details.utlopsdato', 0],
                ['>', 'property_details.utlopsdato', time()]
            ])
            ->offset($offset)->limit($limit + 1)->asArray()->all();

        $count = count($props) <= $limit ? count($props) : $limit;

        for ($i = 0; $i < $count; $i++) {
            $this->fb_table->push($props[$i]);
        }

        if (count($props) > $limit) {
            $this->save($offset + $limit);
        }

    }

}
