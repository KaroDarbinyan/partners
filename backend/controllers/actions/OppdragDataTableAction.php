<?php

namespace backend\controllers\actions;

use common\models\PropertyDetails;
use common\models\User;
use Yii;
use yii\db\ActiveQuery;

class OppdragDataTableAction extends BaseDataTableAction
{
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->query = PropertyDetails::find();

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
        /** @var User $currentUser */
        $currentUser = Yii::$app->user->identity;
        $request = Yii::$app->request;
        $session = Yii::$app->session;
        $ignoreDefaultDateRange = false;
        $ignoreForLike = [
            'oppdragsdato',
            'endretdato',
            'markedsforingsdato',
            'akseptdato',
            'user.navn',
            'solgt'
        ];
        $dateMap = ['oppdragsdato', 'endretdato', 'markedsforingsdato', 'akseptdato'];

        $query->select([
            '{{property_details}}.*',
            'COUNT({{forms}}.id) AS leadsCount'
        ])->joinWith(['leads'])->with(['user', 'department']);

        if ($owner = $request->get('user', false)) {
            $query->joinWith(['user', 'department'])
                ->andFilterWhere([
                    'or',
                    ['user.url' => $owner],
                    ['department.partner_id' => $currentUser->department->partner_id]
                ]);
        }

        if ($office = $request->get('office', false)) {
            $query->joinWith('department')->andFilterWhere(['department.url' => $office]);
        }

        if ($partner = $request->get('partner', false)) {
            $query->joinWith('department')->andFilterWhere(['department.partner_id' => $partner]);
        }

        foreach ($columns as $column) {
            if ('true' != $column['searchable']) {
                continue;
            }
            $filterValue = $column['search']['value'];

            if ($column['data'] === 'solgt' && $filterValue !== '') {
                $filterValue = intval($filterValue);

                if ($filterValue === 1) {
                    $query->andFilterWhere(['solgt' => 0])
                        ->andFilterWhere(['<', 'markedsforingsdato', 1]);
                } else if ($filterValue === 0) {
                    $query->andFilterWhere(['solgt' => 0])
                        ->andFilterWhere(['>', 'markedsforingsdato', 0]);
                } else {
                    $query->andFilterWhere(['like', $column['data'], $filterValue]);
                }
            }

            if (in_array($column['data'], $dateMap) && !empty($filterValue)) {
                try {
                    $ignoreDefaultDateRange = true;
                    $range = $this->getDateRange($filterValue);

                    if ($column['data'] === 'akseptdato') {
                        $query->andFilterWhere([
                            'between',
                            'UNIX_TIMESTAMP(STR_TO_DATE(property_details.akseptdato, \'%d.%m.%Y\'))',
                            $range['start'],
                            $range['end']
                        ]);
                    } else {
                        $query->andFilterWhere(['between', $column['data'], $range['start'], $range['end']]);
                    }
                } catch (\Exception $exception) {
                    Yii::error($exception->getMessage());
                }
            }

            if ($column['data'] === 'user.navn' && !empty($column['search']['value'])) {
                $query->joinWith('user')
                    ->andFilterWhere(['like', $column['data'], $column['search']['value']]);

                $query->joinWith('department')
                    ->orFilterWhere(['like', 'department.short_name', $column['search']['value']]);
            }

            if (!in_array($column['data'], $ignoreForLike)) {
                $query->andFilterWhere(['like', $column['data'], $filterValue]);
            }
        }

        if (
            !$ignoreDefaultDateRange
            && ($start = $session->get('date')['start'])
            && ($end = $session->get('date')['end'])
        ) {
            $query->andWhere(['between', 'property_details.endretdato', $start, $end]);
        }

        if ($request->get('type') === 'befaring') {
            $query->andWhere(['property_details.oppdragsnummer' => null]);
        } else {
            $query->andWhere(['not', ['property_details.oppdragsnummer' => null]]);
        }

        $query->groupBy('{{property_details}}.id');

        return $query;
    }

    /**
     * @param ActiveQuery $query
     * @param array $columns
     * @param array $order
     *
     * @return ActiveQuery
     */
    public function applyOrder(ActiveQuery $query, $columns, $order)
    {
        if ($this->applyOrder !== null) {
            return call_user_func($this->applyOrder, $query, $columns, $order);
        }

        foreach ($order as $key => $item) {
            if (array_key_exists('orderable', $columns[$item['column']]) && $columns[$item['column']]['orderable'] === 'false') {
                continue;
            }

            $sort = $item['dir'] == 'desc' ? SORT_DESC : SORT_ASC;

            if ($columns[$item['column']]['data'] === 'akseptdato') {
                $query->addOrderBy(['UNIX_TIMESTAMP(STR_TO_DATE(property_details.akseptdato, \'%d.%m.%Y\'))' => $sort]);
            } else {
                $query->addOrderBy([$columns[$item['column']]['data'] => $sort]);
            }
        }


        return $query;
    }
}