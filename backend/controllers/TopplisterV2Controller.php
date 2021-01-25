<?php

namespace backend\controllers;

use common\components\StaticMethods;
use common\models\Accounting;
use common\models\Department;
use common\models\PropertyDetails;
use common\models\PropertyVisits;
use common\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

/**
 * Topplister controller
 */
class TopplisterV2Controller extends Controller
{

    private $office_id = false;
    private $partner_id = false;
    private $start;
    private $end;

    public function init()
    {
        Yii::$app->view->params['topplister'] = 'active';
        $this->start = strtotime(date('Y-01-01'));
        $this->end = strtotime('December 31st');
        parent::init();
    }


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays leadspage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isAjax) {
            $type = Yii::$app->request->post('tl-type');
            $rating = Yii::$app->request->post('tl-rating');
            $this->start = Yii::$app->request->post('tl-start');
            $this->end = Yii::$app->request->post('tl-end');
            $partner_id = Yii::$app->request->post('tl-partner');
            $office_id = Yii::$app->request->post('tl-office');
            $this->partner_id = ($partner_id && $partner_id !== 'all') ? $partner_id : false;
            $this->office_id = ($office_id && $office_id !== 'all') ? $office_id : false;

            $function = ($type === 'aktiviteter' || $type === 'visninger')
                ? 'get' . ucfirst($rating) . ucfirst($type) . 'Rating'
                : 'get' . ucfirst($rating) . 'Rating';

            if ($rating === 'kjede') {
                $this->partner_id = false;
                $this->office_id = false;
            }

            return $this->renderPartial('/topplister/_topplister-' . $rating, [
                'topplister' => $this->$function($type)
            ]);
        }

        $type = 'provisjon';
        $function = 'getMeglerRating';

        if (Yii::$app->request->get('type')) {
            $type = Yii::$app->request->get('type');
            $function = $type === 'aktiviteter' ? 'getMegler' . ucfirst($type) . 'Rating' : 'getMeglerRating';
        }

        return $this->render('/topplister/index', [
            'topplister' => $this->renderPartial('/topplister/_topplister-megler', [
                'topplister' => $this->$function($type)
            ])
        ]);
    }


    /**
     * @param $type
     * @return array
     */
    private function getRating($type)
    {
        $ratings = User::find()
            ->select(["user.*"])
            ->joinWith([
                "department" => function (ActiveQuery $query) {
                    $query->joinWith(["partner"]);
                }
            ])->leftJoin(PropertyDetails::tableName(),
                "`property_details`.`ansatte1_id` = `user`.`web_id`");

        if ($this->partner_id) {
            $ratings = $ratings->andWhere(['partner.id' => $this->partner_id]);
        }

        if ($this->office_id) {
            $ratings = $ratings->andWhere(['department.id' => $this->office_id]);
        }

        switch ($type) {
            case 'salg':
                $ratings = $ratings
                    ->addSelect(['COUNT(property_details.id) as count'])
                    ->andWhere(['between', 'UNIX_TIMESTAMP(STR_TO_DATE(property_details.akseptdato, "%d.%m.%Y"))', $this->start, $this->end])
                    ->andWhere(['property_details.solgt' => '-1']);
                break;
            case 'signeringer':
                $ratings = $ratings
                    ->addSelect(['COUNT(property_details.oppdragsnummer) as count'])
                    ->andWhere(['not', ['property_details.oppdragsnummer' => null]])
                    ->andWhere(['between', 'property_details.oppdragsdato', $this->start, $this->end]);
                break;
            case 'provisjon':
                $ratings = $ratings
                    ->addSelect(['FLOOR(SUM(property_details.bokfortprovisjon)) as count'])
                    ->andWhere(['between', 'UNIX_TIMESTAMP(STR_TO_DATE(property_details.akseptdato, "%d.%m.%Y"))', $this->start, $this->end]);;
                break;
            default: // default 'befaringer'
                $ratings = $ratings
                    ->addSelect(['COUNT(property_details.id) as count'])
                    ->andWhere(['between', 'UNIX_TIMESTAMP(STR_TO_DATE(property_details.befaringsdato, "%d.%m.%Y"))', $this->start, $this->end]);
        }

        $ratings = $ratings
            ->andWhere(['or',
                ['and',
                    ['>=', 'user.recruitdate', $this->start],
                    ['<=', 'user.recruitdate', $this->end]
                ],
                ['and',
                    ['or',
                        ['>=', 'user.dismissaldate', $this->start],
                        ['user.dismissaldate' => null]],
                    ['<=', 'user.recruitdate', $this->end]
                ],
            ])
            ->andWhere(["department.inaktiv" => 0])

            ->groupBy(["user.id"])
            ->asArray()
        ;$ratings = $ratings->all();

        foreach ($ratings as $key => $val) {

            if ($val["count"] < 1) {
                unset($ratings[$key]);
                continue;
            }

            $ratings[$key] = [
                "user" => [
                    "id" => $val["id"],
                    "navn" => $val["navn"],
                    "tittel" => $val["tittel"],
                    "web_id" => $val["web_id"],
                    "short_name" => $val["short_name"],
                    "urlstandardbilde" => $val["urlstandardbilde"],
                ],
                "partner" => $val["department"]["partner"],
                "kjede" => ["id" => "partners"],
                "department" => $val["department"],
                "count" => $val["count"]
            ];
            unset($ratings[$key]["department"]["partner"]);
        }

        return $ratings;

    }

    /**
     * @return array
     */
    private function getVisitsRating()
    {
        $ratings = User::find()
            ->select(["user.*", "COUNT(property_visits.id) as count"])
            ->joinWith([
                "department" => function (ActiveQuery $query) {
                    $query->joinWith(["partner"]);
                }
            ])
            ->leftJoin(PropertyDetails::tableName(), "`property_details`.`ansatte1_id` = `user`.`web_id`")
            ->leftJoin(PropertyVisits::tableName(), "`property_details`.`id` = `property_visits`.`property_web_id`");


        if ($this->partner_id) {
            $ratings = $ratings->andWhere(['partner.id' => $this->partner_id]);
        }

        if ($this->office_id) {
            $ratings = $ratings->andWhere(['department.id' => $this->office_id]);
        }
        $ratings = $ratings->andWhere(['or',
            ['and',
                ['>=', 'user.recruitdate', $this->start],
                ['<=', 'user.recruitdate', $this->end]
            ],
            ['and',
                ['or',
                    ['>=', 'user.dismissaldate', $this->start],
                    ['user.dismissaldate' => null]],
                ['<=', 'user.recruitdate', $this->end]
            ],
        ])
            ->andWhere(["department.inaktiv" => 0])
            ->andWhere(['>', 'property_visits.fra', $this->start])
            ->andWhere(['<', 'property_visits.til', $this->end])
            ->groupBy(["user.id"])
            ->asArray()->all();


        foreach ($ratings as $key => $val) {

            if ($val["count"] < 1) {
                unset($ratings[$key]);
                continue;
            }

            $ratings[$key] = [
                "user" => [
                    "id" => $val["id"],
                    "navn" => $val["navn"],
                    "tittel" => $val["tittel"],
                    "web_id" => $val["web_id"],
                    "short_name" => $val["short_name"],
                    "urlstandardbilde" => $val["urlstandardbilde"],
                ],
                "partner" => $val["department"]["partner"],
                "kjede" => ["id" => "partners"],
                "department" => $val["department"],
                "count" => $val["count"]
            ];
            unset($ratings[$key]["department"]["partner"]);
        }

        return $ratings;

    }


    // megler

    /**
     * @param $type
     * @return array
     */
    private function getMeglerRating($type)
    {
        return $this->getRating($type);
    }

    /**
     * @return array
     */
    private function getMeglerAktiviteterRating()
    {
        $salgRatingArray = ArrayHelper::index($this->getRating("salg"), "user.id");
        $befaringRatingArray = ArrayHelper::index($this->getRating("befaringer"), "user.id");
        $visitsRatingArray = ArrayHelper::index($this->getVisitsRating(), "user.id");

        foreach ($salgRatingArray as $k => $v) {
            $salgRatingArray[$k]["count"] = $v["count"] * 2;
        }

        $rating = count($befaringRatingArray) > count($salgRatingArray)
            ? StaticMethods::ratingArrayMix($befaringRatingArray, $salgRatingArray)
            : StaticMethods::ratingArrayMix($salgRatingArray, $befaringRatingArray);

        $rating = count($rating) > count($visitsRatingArray)
            ? StaticMethods::ratingArrayMix($rating, $visitsRatingArray)
            : StaticMethods::ratingArrayMix($visitsRatingArray, $rating);

        return $rating;
    }

    /**
     * @return array
     */
    private function getMeglerVisningerRating()
    {
        return $this->getVisitsRating();
    }


    // kontor

    /**
     * @param $type
     * @return array
     */
    private function getKontorRating($type)
    {
        return $this->sumCountsByKey($this->getMeglerRating($type), "department");
    }

    /**
     * @return array
     */
    private function getKontorAktiviteterRating()
    {
        return $this->sumCountsByKey($this->getMeglerAktiviteterRating(), "department");
    }

    /**
     * @return array
     */
    private function getKontorVisningerRating()
    {
        return $this->sumCountsByKey($this->getMeglerVisningerRating(), "department");
    }


    // medlem

    /**
     * @param $type
     * @return array
     */
    private function getMedlemRating($type)
    {
        return $this->sumCountsByKey($this->getMeglerRating($type), $this->partner_id ? "department" : "partner");
    }

    /**
     * @return array
     */
    private function getMedlemAktiviteterRating()
    {
        return $this->sumCountsByKey($this->getMeglerAktiviteterRating(), $this->partner_id ? "department" : "partner");
    }

    /**
     * @return array
     */
    private function getMedlemVisningerRating()
    {
        return $this->sumCountsByKey($this->getMeglerVisningerRating(), $this->partner_id ? "department" : "partner");
    }


    // kjede

    /**
     * @param $type
     * @return array
     */
    private function getKjedeRating($type)
    {
        return $this->sumCountsByKey($this->getMeglerRating($type), "kjede");
    }

    /**
     * @return array
     */
    private function getKjedeAktiviteterRating()
    {
        return $this->sumCountsByKey($this->getMeglerAktiviteterRating(), "kjede");
    }

    /**
     * @return array
     */
    private function getKjedeVisningerRating()
    {
        return $this->sumCountsByKey($this->getMeglerVisningerRating(), "kjede");
    }


    /**
     * @param $array
     * @param $key
     * @return array
     */
    private function sumCountsByKey($array, $key)
    {
        $ratings = [];
        foreach ($array as $rating) {
            if (array_key_exists($rating[$key]["id"], $ratings)) {
                $ratings[$rating[$key]["id"]]["count"] += $rating["count"];
            } else {
                $ratings[$rating[$key]["id"]] = [
                    "count" => $rating["count"],
                    $key => $rating[$key]
                ];
            }
        }

        return $ratings;
    }
}
