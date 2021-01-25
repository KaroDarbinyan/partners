<?php

namespace backend\controllers\actions;

use common\models\Forms;
use Yii;
use yii\db\ActiveQuery;

class ClientLeadsDataTableAction extends BaseDataTableAction
{
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->query = Forms::find()
            ->where([
                'forms.client_id' => request()->get('client_id'),
            ])
            ->groupBy('forms.id');

        if (user()->hasRole('partner')) {
            $this->query->andWhere([
                'forms.partner_id' => user()->partner->id ?? null,
            ]);
        } else {
            $this->query->andWhere([
                'forms.department_id' => user()->id_avdelinger,
            ]);
        }

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
        $query->joinWith(['user', 'delegatedUser', 'property', 'latestLog']);

        foreach ($columns as $column) {
            if ($column['searchable'] == 'true') {
                $value = $column['search']['value'];

                // ...
            }
        }

        return $query;
    }
}