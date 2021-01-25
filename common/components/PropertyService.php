<?php

namespace common\components;

use common\models\Boligvarsling;
use common\models\Forms;
use common\models\PropertyDetails;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\web\Request;

class PropertyService
{
    public function subscribeToRelated(Forms $form)
    {
        if (!$property = PropertyDetails::findOne(['id' => $form->target_id])) {
            return null;
        }

        $model = new Boligvarsling;

        list($costMin, $costMax) = $this->getCalculatedRange($property->prisantydning);
        list($areaMin, $areaMax) = $this->getCalculatedRange($property->prom);

        $model->setAttributes([
            'property_id' => $property->id,
            'property_type' => Json::encode([$property->finn_eiendomstype]),
            'map_lat' => $property->allPostNumber->lat,
            'map_lng' => $property->allPostNumber->lon,
            'map_radius' => 1000,
            'cost_from' => $costMin,
            'cost_to' => $costMax,
            'area_from' => $areaMin,
            'area_to' => $areaMax,
            // 'rooms' => Json::encode([$property->soverom]),
            'domain' => is_console() ? 'console' : (new Request)->getServerName(),
            'name' => $form->name,
            'phone' => str_replace('+47', '', $form->phone),
            'email' => $form->email,
            'subscribe' => true,
        ]);

        if ($model->save(false)) {
            $form->link('boligvarsling', $model);
        }

        return $model;
    }

    /**
     *
     *
     * @param PropertyDetails $property
     *
     * @return array
     */
    public function getRelatedParams(PropertyDetails $property)
    {
        return [
            'address' => $property->adresse,
            'type' => $property->finn_eiendomstype,
            'lat' => $property->allPostNumber->lat,
            'lng' => $property->allPostNumber->lon,
            'radius' => 1000,
            'cost_range' => $this->getCalculatedRange($property->prisantydning),
            'area_range' => $this->getCalculatedRange($property->prom),
        ];
    }

    /**
     * @param PropertyDetails $property
     * @param int $limit
     *
     * @return array|ActiveRecord[]
     */
    public function getRelatedProperties(PropertyDetails $property, $limit = 10)
    {
        list($costMin, $costMax) = $this->getCalculatedRange($property->prisantydning);
        list($areaMin, $areaMax) = $this->getCalculatedRange($property->prom);

        $lat = deg2rad($property->allPostNumber->lat);
        $lng = deg2rad($property->allPostNumber->lon);
        $earthR = 6371 * 1000;

        return PropertyDetails::find()
            ->joinWith('allPostNumber')
            ->where(['or',
                ['like', 'adresse', $property->adresse],
                [
                    '<=',
                    "acos(sin({$lat})*sin(radians(all_post_number.lat))+cos({$lat})*cos(radians(all_post_number.lat))*cos(radians(all_post_number.lon)-{$lng})) * {$earthR}",
                    intval(1000)
                ]
            ])
            ->andWhere(['like', 'finn_eiendomstype', $property->finn_eiendomstype])
            ->andWhere(['between', 'prisantydning', $costMin, $costMax])
            ->andWhere(['between', 'prom', $areaMin, $areaMax])
            ->andWhere(['markedsforingsklart' => -1, 'solgt' => 0])
            ->andWhere(['<>', 'property_details.id', $property->id])
            ->limit($limit)
            ->all();
    }

    /**
     * 
     *
     * @param $value
     *
     * @return array
     */
    protected function getCalculatedRange($value)
    {
        $precision = $this->getDynamicPrecision($value);

        return [
            round($value - $value * 0.10, $precision),
            round($value + $value * 0.20, $precision)
        ];
    }

    /**
     *
     *
     * @param $value
     *
     * @return float|int
     */
    protected function getDynamicPrecision($value)
    {
        return (ceil(log10(abs($value) + 1)) - 2) * -1;
    }
}