<?php

namespace backend\components;

use common\models\Department;
use common\models\Partner;

class PartnerService
{
    public $cacheDuration = 7200;

    public function isActive()
    {
        return !is_null(\Yii::$app->request->get('partner'));
    }

    public function selected()
    {
        if (!$this->isActive()) {
            return null;
        }

        return Partner::find()
            ->where(['url' => \Yii::$app->request->get('partner')])
            ->cache($this->cacheDuration)
            ->one();
    }

    /**
     * Get the partner with parent departments for current user.
     *
     * @return null|Partner
     */
    public function headOfficeWithParentDepartments()
    {
        $user = \Yii::$app->user->identity;

        if (!$user || !$user->hasRole('partner')) {
            return null;
        }

        $department = Department::find()
            ->joinWith('partner.activeDepartments')
            ->where(['department.web_id' => $user->department_id])
            ->cache($this->cacheDuration)
            ->one();

        return $department->partner ?? null;
    }
}
