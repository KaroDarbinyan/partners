<?php


namespace common\components;


use common\models\AllPostNumber;
use common\models\Department;
use common\models\Partner;
use common\models\PropertyDetails;
use common\models\User;
use Yii;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\Url;

class StaticMethods
{

    public static function getSearchDataBefaring($search)
    {
        $results = PropertyDetails::find()
            ->select([
                'adresse', 'vispaafinn', 'arkivert',
                'utlopsdato',
                'oppdragsnummer',
                'CONCAT("/befaring/", id) AS href',
                'CONCAT("street") AS type',
                'CONCAT(adresse, "+", oppdragsnummer) as navn'
            ])
            ->where([
                'solgt' => 0,
                'arkivert' => 0,
//                'vispaafinn' => -1,
            ])
            /* ->andWhere(['or',
                 ['=', 'utlopsdato', 0],
                 ['>', 'utlopsdato', time()]
             ])*/
            ->andWhere(
                ['like', 'CONCAT(adresse, " ", oppdragsnummer)', "%{$search}%", false])
            ->orWhere(["oppdragsnummer" => $search])
            ->asArray()->all();


        return $results;
    }


    public static function getSearchData($search)
    {
        $userTableName = User::tableName();
        $partnerTableName = Partner::tableName();
        $propertiesTableName = PropertyDetails::tableName();

        $propertyQuery = PropertyDetails::find()
            ->joinWith('allPostNumber')
            ->where(['not', ['property_details.oppdragsnummer' => null]])
            // ->andWhere('`property_details`.`oppdragsnummer__prosjekthovedoppdrag` = `property_details`.`oppdragsnummer`')
            ->andWhere([
                'property_details.arkivert' => 0,
                'property_details.vispaafinn' => -1,
            ])->andWhere(['property_details.is_visible' => 1])
            ->andWhere(['or',
                ['property_details.solgt' => 0],
                'DATE_ADD(STR_TO_DATE(`property_details`.`akseptdato`, "%d.%m.%Y"), INTERVAL 30 DAY) >= CURRENT_DATE()'
            ]);

        $departmentsTableName = Department::tableName();
        $searchItems = [
            "Users" => [
                'query' => (new Query())
                    ->from($userTableName)
                    ->leftJoin(
                        $departmentsTableName,
                        "{$userTableName}.department_id = {$departmentsTableName}.web_id"
                    )->where(['inaktiv_status' => -1]),
                'href' => "{$userTableName}.url",
                'label' => "{$userTableName}.navn",
                'type' => "user",
                'selector' => "{$userTableName}.navn",
                'isStrict' => false,
                'grouper' => "{$userTableName}.navn",
                'count' => -1,
            ],
            "Partners" => [
                'query' => (new Query())
                    ->from($partnerTableName)->leftJoin(
                        $departmentsTableName,
                        "{$partnerTableName}.id = {$departmentsTableName}.partner_id"
                    ),
                'href' => "partner.slug",
                'label' => "partner.name",
                'type' => "partner",
                'selector' => "partner.name",
                'isStrict' => false,
                'grouper' => "partner.name",
                'count' => -1,
            ],
            "Cities" => [
                'query' => clone $propertyQuery,
                'href' => "property_details.poststed",
                'label' => "property_details.poststed",
                'type' => "city",
                'selector' => "property_details.poststed",
                'isStrict' => false,
                'grouper' => "property_details.poststed",
                'count' => "COUNT(property_details.id)",
            ],
            "Area" => [
                'query' => clone $propertyQuery,
                'href' => "all_post_number.area",
                'label' => "all_post_number.area",
                'type' => "area",
                'selector' => "all_post_number.area",
                'isStrict' => false,
                'grouper' => "all_post_number.area",
                'count' => "COUNT(property_details.id)",
            ],
            "Streets" => [
                'query' => clone $propertyQuery,
                'href' => "property_details.street",
                'label' => "property_details.street",
                'type' => "street",
                'selector' => "property_details.adresse",
                'isStrict' => false,
                'grouper' => "property_details.street",
                'count' => "COUNT(property_details.id)",
            ],
            "PostNumber" => [
                'query' => clone $propertyQuery,
                'href' => "property_details.id",
                'label' => "CONCAT(property_details.postnummer, ':', property_details.adresse)",
                'type' => "postNumber",
                'selector' => "property_details.postnummer",
                'isStrict' => true,
                'grouper' => "property_details.postnummer",
                'count' => "COUNT(property_details.id)",
            ],
        ];

        for ($i = 1; $i <= 2; $i++) {
            $searchItems["Area{$i}"] = [
                'query' => clone $propertyQuery,
                'href' => "all_post_number.area{$i}",
                'label' => "all_post_number.area{$i}",
                'type' => "area",
                'selector' => "all_post_number.area{$i}",
                'isStrict' => false,
                'grouper' => "all_post_number.area{$i}",
                'count' => "COUNT(property_details.id)",
            ];
        }

        /** @var Query|bool $results */
        $results = false;
        foreach ($searchItems as $key => $item) {
            // TODO :: move loop step to function
            // TODO :: add default value for that function
            /** @var array $item */
            /** @var Query $query */
            $query = $item['query'];
            $select = [
                "{$item['href']} as href",
                "{$item['selector']} as navn",
                "{$item['label']} as label",
                new Expression("'{$item['type']}' as type"),
                "{$item['grouper']} as grouper",
                new Expression("{$item['count']} as count"),
            ];

            if (in_array($key, ['Cities', 'Streets', 'PostNumber']) || StringHelper::startsWith($key, 'Area')) {
                $select[] = 'property_details.tinde_oppdragstype AS building_type';
            } else {
                $select[] = $item['selector'] . ' AS building_type';
            }

            $query = $query->select($select);

            if ($item['isStrict']) {
                $query = $query->andWhere([$item['selector'] => $search]);
            } else {
                $query = $query->andWhere(['or',
                    ['like', $item['selector'], "{$search}%", false],
                    ['like', $item['selector'], "% {$search}%", false],
                    ['like', $item['selector'], "%-{$search}%", false],
                ]);
            }
            $query = $query->groupBy([$item['grouper'], $item['selector']]);
            $results = $results ? $results->union($query) : $query;
        }

        $results = $results->all();
        $exists = [];

        foreach ($results as $key => $result) {
            $uniqueKey = Inflector::slug($result['href'] . '-' . $result['type']);

            if (empty($result['label']) || in_array($uniqueKey, $exists)) {
                unset($results[$key]);
                continue;
            }

            $exists[] = $uniqueKey;

            $actionName = "urlFor" . ucfirst($result['type']);
            if ($result['type'] == User::TYPE_BROKER) {
                $result['href'] = ArrayHelper::getValue($result, 'navn', '');
            }
            $actionName = 'self::' . $actionName;

            if ($result['building_type'] !== $result['label']) {
                if (StringHelper::startsWith($result['building_type'], 'Prosjekt')) {
                    $path = '/eiendommer/nybygg';
                }

                $results[$key]['href'] = call_user_func_array($actionName, [$path ?? '/eiendommer', $result['href']]);
            } else {
                $results[$key]['href'] = call_user_func($actionName, $result['href']);
            }
        }

        return array_values($results);
    }


    /**
     * Generate url from department.id for User's department
     * @param int|string $key
     * @return string Url
     */
    private static function urlForUser($key)
    {
        return '/ansatte/' . $key;
    }


    /**
     * Generate url from partner.slug for partner
     * @param int|string $key
     * @return string Url
     */
    private static function urlForPartner($key)
    {
        return '/partner/' . $key;
    }

    /**
     * Generate url with street filter for property.
     *
     * @param string $path
     * @param int|string $key
     *
     * @return string Url
     */
    private static function urlForStreet($path, $key)
    {
        return Url::to([$path, 'street' => $key]);
    }

    /**
     * Generate url with city filter for property.
     *
     * @param string $path
     * @param int|string $key
     *
     * @return string Url
     */
    private static function urlForCity($path, $key)
    {
        return Url::to([$path, 'city' => $key]);
    }

    /**
     * Generate url with area filter for property.
     *
     * @param string $path
     * @param int|string $key
     *
     * @return string Url
     */
    private static function urlForArea($path, $key)
    {
        return Url::to([$path, 'area' => $key]);
    }

    /**
     * Generate url from id for property
     * @param int|string $key
     * @return string Url
     */
    private static function urlForPostNumber($key)
    {
        return Url::to(["/annonse/{$key}"]);
    }


    /**
     * @param int $length
     * @return false|string
     */
    public static function generateToken($length = 10)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        return substr(str_shuffle($chars), 0, $length);
    }


    /**
     * @param $array1 array
     * @param $array2 array
     * @return mixed
     */
    public static function ratingArrayMix($array1, $array2): array
    {
        foreach ($array1 as $key => $value) {
            if (array_key_exists($key, $array2)) {
                $array2[$key]['count'] += $value['count'];
            } else {
                $array2[$key] = $value;
            }
        }
        return $array2;
    }

    /**
     * @param $array1 array
     * @param $array2 array
     * @return mixed
     */
    public static function statistikkArrayMix($array1, $array2): array
    {
        foreach ($array1 as $key => $value) {
            if (array_key_exists($key, $array2)) {
                $array2[$key] = self::mergeValue((count($array1[$key]) > count($array2[$key])) ?
                    [0 => $array1[$key], 1 => $array2[$key]] : [0 => $array2[$key], 1 => $array1[$key]]);
            } else {
                $array2[$key] = $value;
            }
        }
        return $array2;
    }

    /**
     * @param $array array
     * @return mixed
     */
    private static function mergeValue($array)
    {
        foreach ($array[0] as $k => $v) {
            if (!is_numeric($k)) continue;
            else if (array_key_exists($k, $array[1])) $array[1][$k] += $v;
            else $array[1][$k] = $v;
        }
        return $array[1];
    }


    /**
     * Return the closest department for 00-14 postcodes and random one for the others
     * @param int $postNumber
     * @param int $minRange
     * @return array
     */
    public static function closestDepartments($postNumber = 0, $minRange = 100000)
    {
        $dep = Department::find()->joinWith(['postNumbers', 'partner'])
            ->where(['post_number.index' => $postNumber, 'department.inaktiv' => 0])
            ->one();

        if ($dep) return [$dep];

        $deps = Department::find()
            ->joinWith(["postNumberDetails", "partner"])
            ->where(['department.inaktiv' => 0])
            ->all();

        $postPrefix = intval(substr($postNumber, 0, 2));
        $arr = [];
        if (
            // May be needed later
            // $postPrefix >= 0 &&
            // $postPrefix <= 14 &&
            // If belongs to Oslo or Akerhuse
        $post = AllPostNumber::findOne(['post_number' => $postNumber])
        ) { // If belongs to Oslo or Akerhuse
            foreach ($deps as $dep) {
                if (!$dep->postNumberDetails) {
                    continue;
                }
                $d = self::distance(
                    $dep->postNumberDetails->lat,// φ1
                    $dep->postNumberDetails->lon,// λ1
                    $post->lat,// φ2
                    $post->lon // λ2
                );
                $arr[$d] = $dep;
            }

        }
        return $arr ? [$arr[min(array_keys($arr))]] : [];
    }

    /**
     * @param $f1
     * @param $d1
     * @param $f2
     * @param $d2
     * @return float|int
     */
    private static function distance($f1, $d1, $f2, $d2)
    {
        /*
         * a = sin²(Δφ/2) + cos φ1 ⋅ cos φ2 ⋅ sin²(Δλ/2)
         * c = 2 ⋅ atan2( √a, √(1−a) )
         * d = R ⋅ c
        */
        $R = 6371 * 1000; // R Earth Radius in meters
        $f1 = deg2rad($f1);// φ1
        $f2 = deg2rad($f2);// φ2
        $d1 = deg2rad($d1);// λ1
        $d2 = deg2rad($d2);// λ2
        $df = sin(($f1 - $f2) / 2);
        $df = $df * $df;// sin²(Δφ/2)

        $dd = sin(($d1 - $d2) / 2);
        $dd = $dd * $dd;// sin²(Δλ/2)
        $a = $df + cos($f1) * cos($f2) * $dd;// sin²(Δφ/2) + cos φ1 ⋅ cos φ2 ⋅ sin²(Δλ/2)
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));// 2 ⋅ atan2( √a, √(1−a) )

        $L = $R * $c;// R ⋅ c
        return $L;
    }

    public static function bodyClass()
    {
        $pathname = Yii::$app->request->url;

        if (strpos($pathname, "eiendommer/") !== false) {
            preg_match('/(\/\d+)/i', $pathname, $found);
            $classname = isset($found[0]) ? "eiendommer eiendom$found[0]" : substr($pathname, 1);
        } else if (strpos($pathname, "kontor/") !== false) {
            $classname = "kontorer " . substr($pathname, 1);
        } else {
            $classname = substr($pathname, 1);
        }

        return preg_replace('~/+~', '-', $classname);

    }

    /**
     * @param string $str
     * @return string
     */
    public static function convertSymbols($str = "")
    {
        $origin = ['Ø', 'ø', 'Å', 'å', 'ü', 'Ü', 'æ', 'Æ'];
        $replaceTo = ['&#216;', '&#248;', '&#197;', '&#229;', '&#252;', '&#220;', '&#230;', '&#198;'];
        return str_replace($origin, $replaceTo, $str);
    }


    public static function convertPhone(string $phone): string
    {
        $phone = str_replace("+47", "", $phone);
        $phone = preg_replace("/\s+/", "", $phone);
        $phone = chunk_split($phone, 2, " ");
        return "+47 {$phone}";
    }

    public static function number_format($number)
    {
        return number_format($number, 0, '', ' ');
    }

    public static function mix_archive_form_data($archive_form)
    {
        $result = [];
        foreach ($archive_form as $item) {
           $result[$item["name"]] = [
               "name" => $item["name"],
               "phone" => $item["phone"] ?? null,
               "email" => $item["email"] ?? null,
           ];
        }

        return $result;
    }


}