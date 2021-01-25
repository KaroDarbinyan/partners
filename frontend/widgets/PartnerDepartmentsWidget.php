<?php

namespace frontend\widgets;

use common\models\Department;
use yii\base\Widget;

final class PartnerDepartmentsWidget extends Widget
{
    public $id;
    public $textHeader;

    public function run()
    {
        $departments = Department::find()
            ->filterWhere([
                'inaktiv' => 0,
                'partner_id' => $this->id
            ])
            ->cache()
            ->all();

        if (!$departments) {
            return '';
        }

        $groupedDepartments = [];

        foreach ($departments as $department) {
            $groupedDepartments[$department->poststed][] = [
                'partner_name' => $department->partner->name,
                'short_name' => $department->short_name,
                'url' => $department->url
            ];
        }

        return $this->render('departments', [
            'textHeader' => $this->textHeader,
            'groupedDepartments' => $groupedDepartments
        ]);
    }
}
