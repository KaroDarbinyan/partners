<?php

namespace backend\controllers\actions;

use common\models\Forms;
use common\models\User;
use nullref\datatable\DataTableAction;
use Yii;
use yii\db\ActiveQuery;

class CallingListClientsDataTableAction extends BaseDataTableAction
{
    public $requestMethod = DataTableAction::REQUEST_METHOD_POST;

    /** @var User */
    protected $activeUser;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->activeUser = Yii::$app->user->identity;
        $this->query = Forms::find();

        parent::init();
    }

    /**
     *
     *
     * @param ActiveQuery $query
     * @param array $columns
     * @param array $search
     *
     * @return ActiveQuery
     */
    public function applyFilter(ActiveQuery $query, $columns, $search)
    {
        $request = Yii::$app->request;
        $session = Yii::$app->session;

        $user = $request->get('user');
        $office = $request->get('office');

        $isAdmin = $this->activeUser->hasRole('superadmin');

        $query->select([
            '{{forms}}.*',
            '{{department}}.short_name AS departmentName',
            'CASE 
                WHEN ({{forms}}.department_id IS NULL AND {{forms}}.broker_id IS NULL) THEN "Felles"
                WHEN ({{forms}}.department_id IS NOT NULL AND {{forms}}.broker_id IS NULL) THEN "Kontor"
                WHEN ({{forms}}.department_id IS NOT NULL AND {{forms}}.broker_id = ' . $this->activeUser->web_id . ') THEN "Min"
                ELSE {{department}}.short_name
            END AS belongsType'
        ])->joinWith(['client', 'propertyDetails', 'department', 'user'], false);

        if (!$isAdmin || ($isAdmin && $user)) {
            $query->orWhere([
                'forms.department_id' => [$this->activeUser->department_id, null],
                'forms.broker_id' => null
            ]);

            if ($partner = $this->activeUser->partner) {
                $query->andWhere(['forms.partner_id' => $partner->id]);
            }
        }

        if ($user) {
            $query->orWhere(['user.url' => $user]);
        }

        if ($department = Yii::$app->departmentService->selected()) {
            $query
                ->andWhere(['or',
                    ['department.url' => $office, 'forms.broker_id' => null],
                    ['forms.department_id' => null]
                ])
                ->andWhere([
                    'forms.partner_id' => $department->partner_id,
                ]);
        } else {
            if ($isAdmin) {
                $query->orWhere([
                    'department.url' => $office,
                    'forms.broker_id' => null
                ]);
            }
        }

        if ($partner = Yii::$app->partnerService->selected()) {
            $query->andFilterWhere([
                'forms.partner_id' => $partner->id
            ]);
        }

        foreach ($columns as $column) {
            $this->addFilter($query, $column);
        }

        if ($dateRange = $session->get('date')) {
            $query->andWhere(['between', 'UNIX_TIMESTAMP(STR_TO_DATE(property_details.akseptdato, "%d.%m.%Y"))', $dateRange['start'], $dateRange['end']]);
        }

        $today = new \DateTime();
        $today->modify('-1 month');

        $query->andWhere(['>=', 'STR_TO_DATE(property_details.akseptdato, "%d.%m.%Y")', $today->format('Y-m-d')]);

        return $query->andWhere([
            'forms.type' => Forms::getColdTypes(),
            'property_details.solgt' => -1,
            'client.status' => null
        ]);
    }

    protected function addFilter(ActiveQuery $query, array $column)
    {
        $value = trim($column['search']['value']);

        if (!boolval($column['searchable']) || empty($column['name']) || empty($value)) {
            return;
        }

        $method = 'set' . ucfirst($column['name']) . 'Filter';

        if (method_exists($this, $method)) {
            call_user_func_array([$this, $method], [$query, $value]);
        }
    }

    protected function setBelongsFilter(ActiveQuery $query, $value)
    {
        switch ($value) {
            case 'pers':
                $query
                    ->andWhere(['forms.broker_id' => $this->activeUser->web_id]);
                break;
            case 'kontor':
                $query
                    ->andWhere(['not', ['forms.department_id' => null]])
                    ->andWhere(['forms.broker_id' => null]);
                break;
            case 'felles':
                $query
                    ->andWhere(['forms.department_id' => null, 'forms.broker_id' => null]);
                break;
        }
    }
}