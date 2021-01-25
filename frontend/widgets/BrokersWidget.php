<?php

namespace frontend\widgets;

use common\models\Department;
use common\models\User;
use yii\base\Widget;
use yii\db\Expression;
use yii\helpers\Json;

class BrokersWidget extends Widget
{
    public $id = null;
    public $textHeader;
    public $except = [];

    public function run()
    {
        $department = Department::findOne(['web_id' => $this->id]);

        if (!$department) {
            return '';
        }

        $query = User::find()
            ->with('department')
            ->where(['inaktiv_status' => -1])
            ->orderBy(new Expression('rand()'))
            ->andWhere(['<>','web_id', User::TEST_BROKER_ID])
        ;

        if ($brokers = Json::decode($department->brokers)) {
            $query->andWhere(['web_id' => $brokers]);
        } else {
            $query->andWhere(['id_avdelinger' => $department->original_id ?? $this->id]);
        }

        if ($brokers = Json::decode($department->extra_brokers)) {
            $query->orWhere(['web_id' => $brokers]);
        }

        $query->andWhere(['not in', 'web_id', $this->except]);

        if (!$users = $query->all()) {
            return '';
        }

        return $this->render('brokers', [
            'title' => $this->textHeader,
            'users' => $users
        ]);
    }
}
