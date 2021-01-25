<?php

namespace common\models;

use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use function foo\func;

class PropertyDetailsQuery extends ActiveQuery
{
    //TODO: adapt following function to be avalibale as separate from request function. we need to call it from concole
    /**
     * @param int $limit
     * @param int $offset
     * @param int $employer_id
     * @param bool $archives
     * @param bool $newBuildings
     * @return array
     */
    public function getFiltered($limit = 30, $offset = null, $employer_id= null, $archives = false, $newBuildings = false)
    {
        $getParameters = \Yii::$app->request->get();

        extract($getParameters);

        $select = [
            'property_details.*',
            'IFNULL(property_details.oppdragsnummer__prosjekthovedoppdrag, property_details.id) as unique_group',
            'CAST(COALESCE(property_details.prom, property_details.bruksareal, property_details.tomteareal, 0) as SIGNED) as area_real',
        ];

        $apn = AllPostNumber::tableName();
        if (
            isset($circle)
            && isset($circle['enable'])
            && $circle['enable']
            && isset($circle['lat'])
            && isset($circle['lon'])
            && isset($circle['radius'])
        ){
            $circle['lat'] = deg2rad($circle['lat']);
            $circle['lon'] = deg2rad($circle['lon']);
            $earthR = 6371 * 1000;
            $this->joinWith(['allPostNumber']);
            $this->andWhere([
                '<=',
                "acos(
                    sin({$circle['lat']})*sin(radians({$apn}.lat))
                    + cos({$circle['lat']})*cos(radians({$apn}.lat))
                    *cos(
                        radians({$apn}.lon)-{$circle['lon']}
                    )
                ) * {$earthR}",
                intval($circle['radius'])
            ]);
            $this->andWhere(['not', ['property_details.postnummer' => null]]);
            $this->andWhere(['not', ["{$apn}.id" => null]]);
        }

        $this->select($select);

        $this->andWhere(['property_details.is_visible' => 1]);

        $this->with([
            'freeTextTitle',
            'propertyImage',
        ]);

        if ($archives) {
            $this->andWhere(['property_details.solgt' => -1]);
        } else {
            $this
                ->andWhere([
                    'property_details.arkivert' => 0,
                    'property_details.vispaafinn' => -1
                ])
                ->andWhere(['or',
                    ['property_details.solgt' => 0],
                    'DATE_ADD( STR_TO_DATE(`property_details`.`akseptdato`, "%d.%m.%Y"), INTERVAL 30 DAY) >= CURRENT_DATE()'
                ])
                //TODO: convert akseptdato to int in Database and optimise this request
//                ->andWhere(['or',
//                    ['=', 'property_details.utlopsdato', 0],
//                    ['>', 'property_details.utlopsdato', time()]
//                ])
            ;
        }

        if ($employer_id) {
            $this->andWhere(['or',
                ['property_details.ansatte1_id' => $employer_id],
                ['property_details.ansatte2_id' => $employer_id]
            ]);
        } else {
            if ($newBuildings) {
                $this->with('properties')
                    ->andWhere(['property_details.tinde_oppdragstype' => 'Prosjekt'])
                    ->andWhere(['or',
                        ['property_details.oppdragsnummer__prosjekthovedoppdrag' => null],
                        'property_details.oppdragsnummer = property_details.oppdragsnummer__prosjekthovedoppdrag'
                    ]);
            } else {
                $this->andWhere(['not', ['property_details.tinde_oppdragstype' => 'Prosjekt']]);
            }
        }

        $priceStart = null;
        $priceEnd = null;

        if (!empty($price_range)) {
            list ($min, $max) = explode(';', $price_range);

            $priceStart = $min;
            $priceEnd = $max;

            if ($max >= 10000000) {
                $max *= 100;
            }

            $this->andWhere(['between', 'property_details.prisantydning', $min, $max]);

            if ($newBuildings) {
                $this->with(['properties' => function (ActiveQuery $query) use ($min, $max) {
                    $query->andWhere(['between', 'p.prisantydning', $min, $max]);
                }]);
            }
        }

        $areaStart = null;
        $areaEnd = null;

        if (!empty($area_range)) {
            list ($min, $max) = explode(';', $area_range);

            $areaStart = $min;
            $areaEnd = $max;

            if ($max >= 300) {
                $max = PHP_INT_MAX;
            }

            $this->andWhere(['between', 'CAST(COALESCE(property_details.prom, property_details.bruksareal, property_details.tomteareal, 0) as SIGNED)', $min, $max]);
        }

        $gettingAreas =
        $gettingTypes =
        $gettingTypesOfOwnership =
        $gettingRooms = [];

        if (!empty($homeType)) {
            $gettingTypes = !is_array($homeType) ? explode(',', $homeType) : $homeType;

            foreach ($gettingTypes as $type){
                if ($type === 'Andre'){
                    $gettingType = PropertyDetails::find()->select(['property_details.finn_eiendomstype'])
                        ->where(['not in', 'property_details.finn_eiendomstype', ['Leilighet', 'Enebolig','Tomannsbolig','Hytte', 'Rekkehus', 'Tomt']])
                        ->groupBy('property_details.finn_eiendomstype')
                        ->asArray()
                        ->column();

                    $gettingTypes = array_merge($gettingTypes, $gettingType);
                    continue;
                }
            }

            if (in_array('Alle Tomt', $gettingTypes)) {
                $homestead = $gettingTypes['tomt'] ?? [];

                if (empty($homestead)) {
                    array_push($gettingTypes, 'Tomt', 'Hytte-tomt');
                } else {
                    unset($gettingTypes['tomt']);
                    $gettingTypes = array_merge($gettingTypes, $homestead);
                }
            }

            if (!empty($gettingTypes)) {
                $this->andWhere(['property_details.finn_eiendomstype' => $gettingTypes]);
            }
        }

        if (!empty($roomsCount)) {
            $gettingRooms = $roomsCount;

            if (in_array(5, $roomsCount)) {
                $roomsCount = array_merge($roomsCount, range(6, 15));
            }

            $this->andWhere(['IN', 'property_details.soverom', $roomsCount]);
        }

        if (!empty($criterions)) {
            if (in_array('garage', $criterions)) {
                array_push($criterions, 'parking');
            }

            $groupedCriteriasTableName = 'GCriterias';

            $cottageCriterions = ['inland', 'mountains','coast'];

            $unusedCottageCriterions = array_diff($cottageCriterions, $criterions);

            $hasOtherCriterions = !empty(array_diff($criterions, $cottageCriterions));

            $andFields = [
                "balcony",
                "lift",
                "garage",
                "fireplace",
                "parking",
            ];
            $orBlock = $criterions;
            $andBlock = [];
            foreach ($orBlock as $i=>$field) {// move fileds that must be used in "and" condition to $andBlock
                if (in_array($field, $andFields)){
                    $andBlock[] = $field;
                    unset($orBlock[$i]);
                }
            }
            $criteriasTableName = Criterias::tableName();
            $propertyDTableName = PropertyDetails::tableName();

            $groupedCriterias = Criterias::find()
                ->select([
                    "{$criteriasTableName}.property_web_id",
                    "GROUP_CONCAT(criterias.iadnavn) as cIadnavns",
                    "COUNT(criterias.iadnavn) as c",
                ])
                ->groupBy("{$criteriasTableName}.property_web_id")
                ->createCommand()->getRawSql()
            ;

            $this->innerJoin(
                "($groupedCriterias) as {$groupedCriteriasTableName}",
                "{$groupedCriteriasTableName}.property_web_id = {$propertyDTableName}.id"
            );
            $filter = ['and',];
            foreach ($andBlock as $f) {
                $filter[]=['like', "{$groupedCriteriasTableName}.cIadnavns", "%{$f}%", false];
            }
            $or=['or',];
            foreach ($orBlock as $f) {
                $or[]=['like', "{$groupedCriteriasTableName}.cIadnavns", "%{$f}%", false];
            }
            $filter[]=$or;
            $this->andFilterWhere($filter);
        }

        if (!empty($street)){
            $street = !is_array($street) ? explode(',',(string)$street) : $street;
            $this->andWhere(['IN','property_details.street',$street]);
        }

        if (!empty($city)){
            $city = !is_array($city) ? explode(',',(string)$city) : $city;
            $this->andWhere(['IN','property_details.poststed',$city]);
        }

        if (!empty($parent_area)) {
            $query = '';

            foreach ($parent_area as $area => $subareas) {
                if (StringHelper::endsWith($query, 'AND')) {
                    $query = rtrim($query, 'AND') . ' OR ';
                }

                $query .= " (`property_details`.`fylkesnavn` = '{$area}') AND";

                $column = ($area === 'Oslo') ? 'kommuneomraade' : 'kommunenavn';

                $subareas = array_filter($subareas, function ($val) use ($area) {
                    return $val !== $area;
                });

                if (count($subareas) > 0) {
                    $query .= " (`property_details`.`$column` IN ('" . join("','", $subareas) . "')) OR";
                    $gettingAreas[$area] = $subareas;
                } else {
                    //$query .= " (`property_details`.`$column` IS NULL) OR";
                    $gettingAreas[$area] = [$area];
                }
            }
            if (!empty($query)) {
                $substr = substr($query, 0, -3);
                $this->andWhere($substr);
            }
        } else {
            if (!empty($area)) {
                $this->joinWith('allPostNumber')->andWhere(['or',
                    ['all_post_number.area' => $area],
                    ['all_post_number.area1' => $area],
                    ['all_post_number.area2' => $area]
                ]);
            }
        }

        if (!empty($eierform)) {
            $gettingTypesOfOwnership = !is_array($eierform) ? explode(',', (string)$eierform) : $eierform;
            $this->andWhere(['IN', 'property_details.type_eierformbygninger', $eierform]);
        }

        if (!empty($text)) {
            $text = strip_tags(clean($text));

            $this->joinWith('freeTexts')
                ->andFilterWhere(['or',
                    ['like', 'property_details.overskrift', $text],
                    ['like', 'free_text.htmltekst', $text]
                ]);
        }

        $this->groupBy(['unique_group']);

        $propertiesCount = clone $this;
        $propertiesCount = $propertiesCount->count();

        // Pagination
            $pages = new Pagination([
                'route' => \Yii::$app->urlManager->createUrl([\Yii::$app->request->pathInfo]),
                'totalCount' => $propertiesCount,
                'pageSizeLimit' => $limit,
                'defaultPageSize' => $limit
            ]);

            if (is_null($offset)) {
                $offset = $pages->offset;
                $this->offset($offset);
            }
            $this
                ->offset($offset)
                ->limit($pages->limit);

        if (!empty($sort)) {
            try {
                list ($name, $order) = explode('_', $sort);

                $columns = [
                    'price' => 'property_details.prisantydning',
                    'area' => 'area_real',
                ];

                if (isset($columns[$name])) {
                    $this->orderBy("{$columns[$name]} $order");
                }
            } catch (\Exception $exception) { }
        }

        $properties = $this
            ->addOrderBy([
                'solgt' => SORT_DESC,
                'markedsforingsdato' => SORT_DESC,
            ])
        ;

        // echo "<pre>";
        // var_dump($properties->createCommand()->getRawSql());
        // echo "</pre>";
        // exit();

        $properties = $properties->all();

        if (\Yii::$app->request->isAjax) {
            $result = [
                'properties' => $properties,
                'pages' => $pages,
                'count' => $propertiesCount,
            ];
        } else {
            $result = [
                'properties' => $properties,
                'pages' => $pages,
                'price' => [
                    'start' => $priceStart,
                    'end' => $priceEnd,
                ],
                'area' => [
                    'start' => $areaStart,
                    'end' => $areaEnd
                ],
                'count' => $propertiesCount,
                'gettingAreas' => $gettingAreas,
                'gettingTypes' => $gettingTypes,
                'gettingTypesOfOwnership' => $gettingTypesOfOwnership,
                'gettingRooms' => $gettingRooms,
                'criterions' => $criterions ?? [],
                'new_buildings' => !empty($new_buildings) && $new_buildings,
                'text' => $text ?? '',
            ];
        }

        return $result;
    }


    /**
     * @return array|PropertyDetailsQuery|mixed|ActiveQuery|\yii\db\ActiveRecord[]
     */
    public function getAreas()
    {
        $areas = PropertyDetails::find()->select([
            'id',
            'kommuneomraade as area',
            'poststed',
            'kommunenavn',
            'fylkesnavn as omrade',
            'IFNULL(oppdragsnummer__prosjekthovedoppdrag, id) as unique_group'
        ]);

        $areas = $areas->andWhere(['not', ['fylkesnavn' => null, 'area' => null]])
            ->andWhere(['>', 'LENGTH(fylkesnavn)', 0])
            ->andWhere([
                'arkivert' => 0,
                'vispaafinn' => -1
            ])
            ->andWhere(['property_details.is_visible' => 1])
            ->andWhere(['or',
                ['solgt' => 0],
                'DATE_ADD(STR_TO_DATE(`property_details`.`akseptdato`, "%d.%m.%Y"), INTERVAL 30 DAY) >= CURRENT_DATE()'
            ])
//            ->andWhere(['or',
//                ['=', 'utlopsdato', 0],
//                ['>', 'utlopsdato', time()]
//            ])
            ->andWhere(['or',
                ['and', ['in', 'fylkesnavn', ['Oslo']], ['not', ['area' => null]]],
                ['not in', 'fylkesnavn', ['Oslo']]
            ])
            ->groupBy(['unique_group'])
            ->asArray()
            ->all();

        $areas = ArrayHelper::getValue($areas, function ($areas) {
            $temp = [];
            $count = 0;
            foreach ($areas as $area) {
                $count++;

                if (!isset($temp[$area['omrade']])) {
                    $temp[$area['omrade']] = [
                        'omrade' => $area['omrade'],
                        'count' => 0,
                        'area' => []
                    ];
                }

                $temp[$area['omrade']]['count'] += 1;

                if ($area['omrade'] !== 'Oslo') {
                    $area['area'] = $area['kommunenavn'];
                }

                if ($area['area']) {
                    if (!isset($temp[$area['omrade']]['area'][$area['area']])) {
                        $temp[$area['omrade']]['area'][$area['area']]['count'] = 0;
                    }

                    $temp[$area['omrade']]['area'][$area['area']]['count'] += 1;
                }

                ksort($temp[$area['omrade']]['area']);
            }

            ArrayHelper::multisort($temp, 'omrade', SORT_ASC);

            return [
                'areas' => $temp,
                'count' => $count
            ];
        });

        return $areas;

    }

    public function _getAreas()
    {
        $areas = $this->select([
            'id',
            'area',
            'fylkesnavn as omrade'
        ])->andWhere(['not', ['fylkesnavn' => null, 'area' => null]])
            ->andWhere(['>', 'LENGTH(fylkesnavn)', 0])
            ->andWhere([
                'arkivert' => 0,
                'vispaafinn' => -1
            ])
            ->andWhere(['or',
                ['solgt' => 0],
                'DATE_ADD(STR_TO_DATE(`property_details`.`akseptdato`, "%d.%m.%Y"), INTERVAL 30 DAY) >= CURRENT_DATE()'
            ])
            ->andWhere(['or',
                ['=', 'utlopsdato', 0],
                ['>', 'utlopsdato', time()]
            ])
            ->andWhere(['or',
                ['and', ['in', 'fylkesnavn', ['Oslo']], ['not', ['area' => null]]],
                ['not in', 'fylkesnavn', ['Oslo']]
            ])
            ->asArray()
            ->all();

        $areas = ArrayHelper::getValue($areas, function ($areas) {
            $temp = [];
            $count = 0;
            foreach ($areas as $area) {
                $count++;
                if (!isset($temp[$area['omrade']])) {
                    $temp[$area['omrade']] = [
                        'omrade' => $area['omrade'],
                        'count' => 0,
                        'area' => []
                    ];
                }
                $temp[$area['omrade']]['count'] += 1;
                if ($area['area']) {
                    if (!isset($temp[$area['omrade']]['area'][$area['area']])) {
                        $temp[$area['omrade']]['area'][$area['area']] = 0;
                    }
                    $temp[$area['omrade']]['area'][$area['area']] += 1;
                }
            }

            ArrayHelper::multisort($temp, 'omrade', SORT_ASC);

            return [
                'areas' => $temp,
                'count' => $count
            ];
        });

        return $areas;
    }

    public function getTypes()
    {
        return $this->select([
            "(CASE WHEN property_details.finn_eiendomstype NOT IN ('Leilighet', 'Enebolig', 'Tomannsbolig', 'Hytte', 'Rekkehus', 'Tomt', 'Hytte-tomt')
                  THEN 'Andre'
                  WHEN property_details.finn_eiendomstype IN ('Leilighet', 'Enebolig', 'Tomannsbolig', 'Hytte', 'Rekkehus')
                  THEN finn_eiendomstype
                  WHEN property_details.finn_eiendomstype IN ('Tomt', 'Hytte-tomt')
                  THEN 'Alle Tomt'
              END) AS `type`",
            "COUNT(property_details.id) as count"
        ])->where(['solgt' => 0, 'arkivert' => 0, 'vispaafinn' => -1])
            ->andWhere(['or', ['=', 'utlopsdato', 0], ['>', 'utlopsdato', time()]])
            ->groupBy('type')
            ->orderBy([new Expression('FIELD(type, "Leilighet", "Enebolig", "Tomannsbolig", "Rekkehus", "Hytte", "Forretning", "Alle Tomt", "Andre")')])
            ->indexBy('type');
    }

    public function getTypesOfOwnership()
    {
        return $this->select('type_eierformbygninger as type')
            ->where(['solgt' => 0, 'arkivert' => 0, 'vispaafinn' => -1])
            ->andWhere(['or', ['=', 'utlopsdato', 0], ['>', 'utlopsdato', time()]])
            ->andWhere(['not', ['type_eierformbygninger' => null]])
            ->groupBy('type')
            ->indexBy('type');
    }

    public function getActive() {
        return $this->where(['solgt' => 0, 'arkivert' => 0, 'vispaafinn' => -1])
            ->andWhere(['or', ['=', 'utlopsdato', 0], ['>', 'utlopsdato', time()]])
            ->andWhere(['not', ['type_eierformbygninger' => null]])
            ->andWhere(['not', ['soverom' => null]]);
    }
}