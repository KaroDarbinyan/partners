<?php

namespace frontend\widgets;

use common\models\Department;
use common\models\Partner;
use common\models\PropertyDetails;
use common\models\User;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class PropertyWidget extends Widget
{
    public $id;
    public $textHeader;
    public $office = false;
    public $partner = false;

    public function run()
    {
        if ($this->partner) {
            if (!$employees = Partner::getAnsatteUsersData($this->id)) {
                return '';
            }
            $employeesIds = ArrayHelper::getColumn($employees, 'web_id');
        } elseif ($this->office) {
            $department = Department::findOne(['web_id' => $this->id]);

            if (!$department) {
                return '';
            }

            $employees = User::find()
                ->where(['inaktiv_status' => -1]);

            if ($brokers = Json::decode($department->brokers)) {
                $employees->andWhere(['web_id' => $brokers]);
            } else {
                $employees->andWhere(['id_avdelinger' => $department->original_id ?? $this->id]);
            }

            if ($brokers = Json::decode($department->extra_brokers)) {
                $employees->orWhere(['web_id' => $brokers]);
            }

            $employeesIds = $employees
                ->select('web_id')
                ->column();

            if (!$employeesIds) {
                return '';
            }
        } else {
            $employeesIds = $this->id;
        }

        $propertiesData = PropertyDetails::find()
            ->with('properties')
            ->getFiltered(1000, null, $employeesIds);

        if (!$properties = ArrayHelper::getValue($propertiesData, 'properties', [])) {
            return '';
        }

        $textHeader = $this->textHeader;
        shuffle($properties);

        return $this->render('properties', compact('properties', 'textHeader'));
    }
}