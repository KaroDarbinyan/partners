<?php

namespace backend\controllers\actions;

use common\models\Forms;
use Yii;
use yii\db\ActiveQuery;

class ClientDataTableAction extends BaseDataTableAction
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

        $types = Yii::$app->request->get('type', []);
        $filter = Yii::$app->request->get('filter');

        $query->with(['propertyDetails', 'user', 'delegatedUser']);

        if ($filter) {
            foreach ($filter as $index => $item) {
                if ($columns[$index]['search']['value'] == '')
                    $columns[$index]['search']['value'] = $item;
            }
        }

        if (!empty($types) && $types) {
            if (in_array('book_visning', $types)) {
                $types = array_diff($types, ['book_visning']);

                $query->joinWith('propertyDetails')
                    ->where([
                        'forms.type' => 'book_visning',
                        'property_details.solgt' => 0,
                    ])
                    ->orFilterWhere(['in', 'forms.type', $types]);
            } else {
                $query->andFilterWhere(['in', 'forms.type', $types]);
            }
        }

        $where = false;

        if ($partner = $request->get('partner', false)) {
            $query->joinWith('partner')->andWhere(['partner.url' => $partner]);
        } elseif ($office = $request->get('office', false)) {
            $query->joinWith('department')->andWhere(['department.url' => $office]);
        } elseif ($owner = $request->get('user', false)) {
            $query->joinWith('user')->andWhere(['user.url' => $owner]);
        }

        $ignoreForLike = [
            'created_at',
            'updated_at',
            'brokerName',
            'status',
            'referer_source'
        ];

        $ignoreDefaultDateRange = false;
        $ignoreDefaultLogType = false;

        foreach ($columns as $column) {
            if ($column['searchable'] == 'true') {
                $filterValue = trim($column['search']['value']);

                if ($column['data'] === 'referer_source' && !empty($filterValue)) {
                    $conditions = ['or'];

                    foreach (explode(', ', $filterValue) as $value) {
                        $conditions[] = ['like', 'forms.' . $column['data'], $value];
                    }

                    $query->andFilterWhere($conditions);
                }

                if ($column['data'] === 'type' && !empty($column['search']['value'])) {
                    if ($filterValue === 'ringeliste') {
                        $query->andWhere(['forms.broker_id' => null]);
                    }
                    $ignoreForLike[] = $column['data'];
                    if ($column['search']['value'] == "3rd party"){
                        $query->andWhere(['in', 'forms.type', Forms::getHotTypes()])
                            ->andWhere(['RLIKE ', 'forms.referer_source', "eiendomsmegler.no|meglersiden.no|tjenestetorget.no"])
                            ->andWhere(['not', ['forms.department_id' => null]]);
                    }elseif ($column['search']['value'] == "Our own"){
                        $hotTypes = Forms::getHotTypes();
                        if (($key = array_search("book_visning", $hotTypes)) !== false) unset($hotTypes[$key]);

                        $query->andWhere(['not in', 'forms.status', ['1013', '1003', '1020', '1017']])
                            ->andWhere(['not RLIKE ', 'forms.referer_source', "eiendomsmegler.no|meglersiden.no|tjenestetorget.no"])
                            ->andWhere(['in', 'forms.type', $hotTypes])->andWhere(['not', ['forms.department_id' => null]]);
                    }else{
                        $query->andWhere(['in', 'forms.type', $column['search']['value']]);
                    }

                }

                if (in_array($column['data'], ['created_at', 'updated_at']) && !empty($filterValue)) {
                    try {
                        $range = $this->getDateRange($filterValue);

                        $ignoreDefaultDateRange = true;

                        if ($column['data'] === 'status') {
                            $query->andFilterWhere(['between', 'forms.updated_at', $range['start'], $range['end']]);
                        } else {
                            $query->andFilterWhere(['between', 'forms.' . $column['data'], $range['start'], $range['end']]);
                        }
                    } catch (\Exception $exception) {
                        Yii::error($exception->getMessage());
                    }
                }

                if ($column['data'] === 'brokerName' && !empty($filterValue)) {
                    $query->joinWith('user')->andWhere(['or',
                        ['like', 'user.navn', $filterValue],
                        //['like', 'u2.navn', $filterValue]
                    ]);
                }

                if ($column['data'] === 'status' && !empty($filterValue)) {
                    $lead_log_types = [
                        '1014',
                        '1020',
                        '1017',
                        '1011',
                        '1009',
                        '1013',
                        '1008',
                        '1018',
                        '1016',
                        '1010'
                    ];

                    if ($filterValue === 'Ubehandlede') {
                        $query->andWhere(['not', ['forms.department_id' => null]]);
                        $query->andWhere(['not in', 'forms.status', array_merge($lead_log_types, ['1003'])]);
                    } elseif ($filterValue === 'Behandlede') {
                        $query->andWhere(['in', 'forms.status', $lead_log_types]);
                    } else {
                        $query->andFilterWhere(['in', 'forms.status', $filterValue]);
                    }

                    $ignoreDefaultLogType = true;
                }

                if (!in_array($column['data'], $ignoreForLike)) {
                    $query->andFilterWhere(['like', 'forms.' . $column['data'], $filterValue]);
                }
            }
        }

        if (!$ignoreDefaultLogType) {
            $query->andFilterWhere(['not in', 'forms.status', [
                '1013',
                '1003',
                '1020',
                '1017',
            ]]);
        }

        if (!$ignoreDefaultDateRange
            && ($start = $session->get('date')['start'])
            && ($end = $session->get('date')['end'])) {
            $query->andFilterWhere(['between', 'forms.created_at', $start, $end]);
        }

        // TODO: why the following conditions were comented
        // Include outdated
        /*$query->orFilterWhere(['and',
            ['is', 'forms.department_id', new \yii\db\Expression('NULL')],
            ['forms.type'=>Forms::getColdTypes()],
        ]);
        $query->orFilterWhere(['and',
            ['forms.type'=>Forms::getColdTypes()],
            ['is', 'forms.broker_id', new \yii\db\Expression('NULL')],
            ['forms.department_id'=>Yii::$app->user->identity->department_id],
        ]);*/
        return $query;
    }
}