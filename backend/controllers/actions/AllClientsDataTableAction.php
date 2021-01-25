<?php

namespace backend\controllers\actions;

use common\models\Client;
use common\models\Forms;
use nullref\datatable\DataTableAction;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Expression;

class AllClientsDataTableAction extends BaseDataTableAction
{
    public $requestMethod = DataTableAction::REQUEST_METHOD_POST;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->query = Client::find()->groupBy('client.phone');

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
        $hotForms = Forms::find()
            ->select(['client_id', 'COUNT(*) as totalCount'])
            ->where(['in', 'type', Forms::getHotTypes()])
            ->groupBy('client_id');

        $coldForms = Forms::find()
            ->select(['client_id', 'COUNT(*) as totalCount'])
            ->where(['in', 'type', Forms::getColdTypes()])
            ->groupBy('client_id');

        $query->select([
            '{{client}}.*',
            new Expression('COALESCE(hot.totalCount, 0) as hotCount'),
            new Expression('COALESCE(cold.totalCount, 0) as coldCount')
        ])
            ->joinWith(['lastForm'])
            ->leftJoin(['hot' => $hotForms], 'hot.client_id=client.id')
            ->leftJoin(['cold' => $coldForms], 'cold.client_id=client.id');

        foreach ($columns as $column) {
            if ($column['searchable'] != 'true') {
                continue;
            }
            $value = $column['search']['value'];


            // $query->andFilterWhere(['']);
        }
        return $query;
    }
}