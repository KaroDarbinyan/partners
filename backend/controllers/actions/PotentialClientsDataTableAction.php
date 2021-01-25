<?php

namespace backend\controllers\actions;

use backend\components\PermitionControll;
use common\models\Forms;
use common\models\PropertyDetails;
use common\models\User;
use nullref\datatable\DataTableAction;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Json;

class PotentialClientsDataTableAction extends BaseDataTableAction
{
    public $requestMethod = DataTableAction::REQUEST_METHOD_POST;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->query = Forms::find()
            ->select([
                '{{forms}}.*',
                '{{property_details}}.salgssum as propertyCost'
            ])
            ->joinWith(['propertyDetails'])
        ;

        parent::init();
    }

    /**
     * @param ActiveQuery $query
     * @param array $columns
     * @param array $search
     *
     * @return ActiveQuery
     */
    public function applyFilter(ActiveQuery $query, $columns, $search)
    {

        foreach ($columns as $column) {
            if ($column['searchable'] != 'true') { continue;}
            $value = $column['search']['value'];

            if ($column['name'] === 'property_type' && !empty($value)) {
                $value = explode(',', $value);
                foreach ($value as $item){
                    if ($item === 'Andre'){
                        $gettingType = PropertyDetails::find()->select(['property_details.finn_eiendomstype'])
                            ->where(['not in', 'property_details.finn_eiendomstype', ['Leilighet', 'Enebolig','Tomannsbolig','Hytte','Rekkehus']])
                            ->groupBy('property_details.finn_eiendomstype')->asArray()->column();
                        $value = array_merge($value, $gettingType);
                        continue;
                    }
                }
                $query->andFilterWhere(['property_details.type_eiendomstyper'=>$value]);
            }

            if ($column['name'] === 'price_range' && !empty($value)) {
                $range = $this->getRange($value);
                $query->andFilterWhere(['between', 'property_details.prisantydning', $range['from'], $range['to']]);
            }

            if ($column['name'] === 'area_range' && !empty($value)) {
                $range = $this->getRange($value);
                $query->andFilterWhere(['between', 'property_details.prom', $range['from'], $range['to']]);
            }

            if ($column['name'] === 'map_coordinates' && !empty($value)) {
                list ($lat, $lng, $radius) = explode(';', $value);

                $lat = deg2rad((float) $lat);
                $lng = deg2rad((float) $lng);
                $earthR = 6371 * 1000;
                $query->joinWith(['allPostNumber']);
                $query->andWhere([
                    '<=',
                    "acos(sin({$lat})*sin(radians(all_post_number.lat))+cos({$lat})*cos(radians(all_post_number.lat))*cos(radians(all_post_number.lon)-{$lng})) * {$earthR}",
                    intval($radius)
                ]);
                $query->andWhere(['not', ['forms.post_number' => null]]);
                $query->andWhere(['not', ['all_post_number.id' => null]]);
            }

            if ($column['data'] === 'created_at' && !empty($value)) {
                $range = $this->getRange($value);
                $range['from'] = time() - 60*60*24*30*$range['from'];
                $range['to'] = time() - 60*60*24*30*$range['to'];
                $query->andFilterWhere(['between', 'forms.created_at', $range['to'], $range['from']]);
            }

            if (in_array($column['data'], ['type', 'post_number']) && !empty($value)) {
                $query->andFilterWhere([$column['data']=>explode(',', $value)]);
            }
            // $query->andFilterWhere(['']);
        }
        $query = $query->andWhere(['forms.type'=>Forms::getInterestedTypes()]);

        // echo $query->createCommand()->getRawSql();exit();
        return $query;
    }

    protected function getRange($range)
    {
        list ($from, $to) = explode('-', $range);

        return compact('from', 'to');
    }
}