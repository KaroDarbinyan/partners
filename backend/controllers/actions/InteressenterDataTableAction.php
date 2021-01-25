<?php

namespace backend\controllers\actions;

use common\models\Forms;
use Yii;
use yii\db\ActiveQuery;

class InteressenterDataTableAction extends BaseDataTableAction
{
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
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

        $targetId = Yii::$app->request->get('target_id');
        $query->filterWhere(['target_id' => $targetId]);

        $types = $request->get('type', []);
        $query->andFilterWhere(['IN', 'forms.type', $types]);

        $ignoreForLike = [
            'created_at',
            'updated_at',
            'brokerName',
            'status',
        ];

        $ignoreDefaultDateRange = false;

        foreach ($columns as $column) {
            //TODO:: optimise following conditions
            if ($column['searchable'] == 'true') {
                $filterValue = $column['search']['value'];

                if (in_array($column['data'], ['created_at', 'updated_at']) && !empty($filterValue)) {
                    try {
                        $range = $this->getDateRange($filterValue);

                        $ignoreDefaultDateRange = true;

                        $query->andFilterWhere(['between', 'forms.' . $column['data'], $range['start'], $range['end']]);
                    } catch (\Exception $exception) {
                        Yii::error($exception->getMessage());
                    }
                }

                if ($column['data'] === 'brokerName' && !empty($filterValue)) {
                    $query->andWhere(['or',
                        ['like', 'user.navn', $filterValue],
                        ['like', 'u2.navn', $filterValue]
                    ]);
                }

                if ($column['data'] === 'status' && !empty($filterValue)) {
                    if ($filterValue === 'Ubehandlede') {
                        $query->andFilterWhere(['not', ['in', 'forms.status', [
                            '1011',
                            '1013',
                            '1020',
                        ]]]);
                    } else {
                        $query->andFilterWhere(['like', 'forms.status', $filterValue]);
                    }
                }

                if (!in_array($column['data'], $ignoreForLike)) {
                    $query->andFilterWhere(['like', 'forms.' . $column['data'], $filterValue]);
                }
            }
        }

        if (!$ignoreDefaultDateRange
            && ($start = $session->get('date')['start'])
            && ($end = $session->get('date')['end'])) {
            $query->andFilterWhere(['between', 'forms.updated_at', $start, $end]);
        }

        return $query;
    }
}