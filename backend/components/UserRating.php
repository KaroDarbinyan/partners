<?php


namespace backend\components;


use common\models\Accounting;
use common\models\Department;
use common\models\Partner;
use common\models\PropertyDetails;
use common\models\PropertyVisits;
use common\models\User;
use Yii;
use yii\db\ActiveQuery;

/**
 *
 * @property Partner $partner
 * @property Department $department
 * @property User $user
 * @property int $start
 * @property int $end
 */
class UserRating
{

    public $partner;
    public $department;
    public $user;
    private $start;
    private $end;

    /**
     * UserRating constructor.
     * @param int $start
     * @param int $end
     */
    public function __construct(int $start, int $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @param $type
     * @return array
     */
    public function getRatingByType($type)
    {
        $percent = 0;
        $ratings = User::find()
            ->select(["user.*"])
            ->joinWith([
                "department" => function (ActiveQuery $query) {
                    $query->joinWith(["partner"]);
                }
            ])->leftJoin(PropertyDetails::tableName(),
                "`property_details`.`ansatte1_id` = `user`.`web_id`");

        if ($this->partner) $ratings->andWhere(['partner.id' => $this->partner->id]);

        if ($this->department) $ratings->andWhere(['department.id' => $this->department->id]);

        if ($this->user) $ratings->andWhere(['user.id' => $this->user->id]);

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
                $ratings->join = null;
                $ratings = $ratings
                    ->addSelect(['ABS(SUM(belop)) AS count'])
                    ->leftJoin(Accounting::tableName(), "`accounting`.`id_ansatte` = `user`.`web_id`")
                    ->andWhere(["or",
                        ["accounting.linjenummer" => 1],
                        ["accounting.linjenummer" => 2],
                        ["like", "accounting.kommentar", "Delt provisjon%", false],
                        ["like", "accounting.kommentar", "Delt tilrettelegging%", false]
                    ])
                    ->andWhere(['between', 'accounting.bilagsdato', $this->start, $this->end]);


                $ratings = $this->andWhere($ratings);
                $percent = 20;
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
            ->orderBy(['count' => SORT_DESC, 'user.short_name' => SORT_ASC])
            ->indexBy('id')
            ->asArray()
            ->all();

        foreach ($ratings as $key => $val) {

            $count = $val["count"];
            $count = floor($count - $count * $percent / 100);

            if ($count < 1) {
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
                "count" => $count
            ];
            unset($ratings[$key]["department"]["partner"]);
        }

        return $ratings;

    }

    /**
     * @return array
     */
    public function getVisitsRating()
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


        if ($this->partner) $ratings->andWhere(['partner.id' => $this->partner->id]);

        if ($this->department) $ratings->andWhere(['department.id' => $this->department->id]);

        if ($this->user) $ratings->andWhere(['user.id' => $this->user->id]);

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
            ->orderBy(['count' => SORT_DESC, 'user.short_name' => SORT_ASC])
            ->indexBy('id')
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


    /**
     * @param $type
     * @return float|int
     */
    public function getIncomeRating($type)
    {
        $ratings = $this->getRatingByType($type);

        return array_sum(array_column($ratings, 'count'));
    }


    /**
     * @return array
     */
    public function getIncomeRating1()
    {
        $ratings = User::find()
            ->leftJoin(Department::tableName(), "`user`.`id_avdelinger` = `department`.`web_id`")
            ->leftJoin(Partner::tableName(), "`department`.`partner_id` = `partner`.`id`")
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
            ->andWhere(["department.inaktiv" => 0]);

        if ($this->partner) $ratings->andWhere(['partner.id' => $this->partner->id]);

        if ($this->department) $ratings->andWhere(['department.id' => $this->department->id]);

        if ($this->user) $ratings->andWhere(['user.id' => $this->user->id]);


        $provisjon = clone $ratings;

        $ratings = $ratings->addSelect([
            "COUNT(IF((UNIX_TIMESTAMP(STR_TO_DATE(property_details.akseptdato, \"%d.%m.%Y\")) BETWEEN {$this->start} AND {$this->end}) AND (property_details.solgt = -1), 1, null)) AS salg",
            "COUNT(IF((property_details.oppdragsdato BETWEEN {$this->start} AND {$this->end}) AND (property_details.oppdragsnummer is not null), 1, null)) AS signeringer",
            "COUNT(IF(UNIX_TIMESTAMP(STR_TO_DATE(property_details.befaringsdato, \"%d.%m.%Y\")) BETWEEN {$this->start} AND {$this->end}, 1, null)) AS befaringer",
        ])
            ->leftJoin(PropertyDetails::tableName(),
                "`property_details`.`ansatte1_id` = `user`.`web_id`")
            ->asArray()->one();


        $provisjon = $provisjon
            ->addSelect(['ABS(SUM(belop)) AS provisjon'])
            ->leftJoin(Accounting::tableName(), "`accounting`.`id_ansatte` = `user`.`web_id`")
            ->andWhere(["or",
                ["accounting.linjenummer" => 1],
                ["accounting.linjenummer" => 2],
                ["like", "accounting.kommentar", "Delt provisjon%", false],
                ["like", "accounting.kommentar", "Delt tilrettelegging%", false]
            ])
            ->andWhere(['between', 'accounting.bilagsdato', $this->start, $this->end]);

        $provisjon = $this->andWhere($provisjon);

        $provisjon = $provisjon->asArray()->one();

        return [
            "befaringer" => $ratings["befaringer"],
            "signeringer" => $ratings["signeringer"],
            "salg" => $ratings["salg"],
            "provisjon" => floor($provisjon["provisjon"] - $provisjon["provisjon"] * 0.2), // 20%
        ];

    }


    /**
     * @param ActiveQuery $query
     * @return ActiveQuery
     */
    private function andWhere(ActiveQuery $query): ActiveQuery
    {
        $query->andWhere(["accounting.konto" => [3000, 3030, 3120]]);


        if ($this->partner)
            $query->andWhere(["accounting.db_id" => $this->partner->id === 1 ? 343 : 233]);
        else
            $query->andWhere(["accounting.db_id" => [343, 233]]);

        return $query;
    }

    /**
     * @param $arr
     * @return array
     */
    public function arraySlice($arr)
    {
        $best = isset($arr[0]) ? $arr[0] : null;
        $i = 0;
        $count = count($arr);
        $user = $this->user ?? Yii::$app->user->identity;

        for ($j = 0; $j < $count; $j++) {
            $arr[$j]['index'] = $j + 1;
            if ($arr[$j]['user']['id'] == $user->id) {
                $i = $j;
                if ($i != 0) {
                    $arr[$j]['prev_count'] = $arr[$j - 1]['count'];
                }
            }
        }

        if (boolval($i)) {
            if ($count > 5) {
                if ($i <= 2) {
                    $arr = array_slice($arr, 0, 5);
                } elseif ($i == $count - 1) {
                    $arr = array_slice($arr, $count - 3, 3);
                } elseif ($i == $count - 2) {
                    $arr = array_slice($arr, $count - 4, 4);
                } else {
                    $arr = array_slice($arr, $i - 2, 5);
                }
            }
        } else {
            $arr = array_slice($arr, 0, 5);
        }

        $best = (isset($best) && isset($arr[0])) && $arr[0]['user']['id'] != $best['user']['id'] ? $best : null;

        return ['top' => $arr, 'best' => $best];
    }

}