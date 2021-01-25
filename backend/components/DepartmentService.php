<?php

namespace backend\components;

use common\models\Department;

class DepartmentService
{
    public $cacheDuration = 7200;

    public function isActive()
    {
        return !is_null(\Yii::$app->request->get('office'));
    }

    public function selected()
    {
        if (!$this->isActive()) {
            return null;
        }

        return Department::find()
            ->filterWhere(['url' => \Yii::$app->request->get('office')])
            ->cache($this->cacheDuration)
            ->one();
    }
}
