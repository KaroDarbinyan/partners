<?php

namespace backend\controllers\actions;

use common\models\PropertyDetails;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\Expression;

class OppdragPrintTableAction extends BaseDataTableAction
{
    public $requestMethod = self::REQUEST_METHOD_POST;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        $this->query = PropertyDetails::find()
            ->joinWith(['department', 'leads', 'propertyAds']);

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
        $query
            ->select([
                '{{property_details}}.*',
                'COUNT({{forms}}.id) AS leadsCount',
            ])
            ->with(['user', 'propertyVisits']);

        $useDefaultDateRange = true;

        foreach ($columns as $column) {
            if (empty($column['name']) || !$column['searchable']) {
                continue;
            }

            if (!empty($search['value']) && $column['name'] !== 'partner') {
                if ($column['name'] === 'department.navn') {
                    $query
                        ->joinWith(['user'])
                        ->orFilterWhere(['like', 'user.navn', $search['value']]);
                }

                $query->orFilterWhere(['like', $column['name'], $search['value']]);
            }

            if (empty($column['search']['value'])) {
                continue;
            }

            $searchValue = $column['search']['value'];

            if ($column['name'] === 'partner') {
                $query->joinWith(['department' => function (ActiveQuery $query) use ($searchValue) {
                    if ($searchValue === 'partners') {
                        $query->filterWhere(['not', ['department.partner_id' => 1]]);
                    } else {
                        $query->filterWhere(['department.partner_id' => 1]);
                    }
                }]);
            }

            if (in_array($column['name'], ['markedsforingsdato', 'akseptdato'])) {
                try {
                    $range = $this->getDateRange($searchValue);
                    $useDefaultDateRange = false;

                    if ($column['name'] === 'akseptdato') {
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
                    // Ignore
                }
            }
        }

        if ($useDefaultDateRange) {
            $query
                ->andWhere('FROM_UNIXTIME(property_details.markedsforingsdato) >= "2019-08-01 00:00:00"')
                ->andWhere(['property_details.markedsforingsklart' => '-1']);
        }

        return $query->groupBy('property_details.id');
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
            $columnName = $columns[$item['column']]['name'];

            if (!empty($columnName)) {
                if ($columnName === 'property_ads.finn_adid') {
                    $query->addOrderBy([
                        new Expression("$columnName IS NULL ASC"),
                        "CAST($columnName AS UNSIGNED INTEGER)" => $sort
                    ]);
                } else {
                    $query->addOrderBy([$columnName => $sort]);
                }
            } else {
                $query->addOrderBy([$columns[$item['column']]['data'] => $sort]);
            }
        }

        return $query;
    }
}