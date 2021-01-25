<?php

namespace backend\controllers\actions;

use common\models\Boligvarsling;
use nullref\datatable\DataTableAction;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

final class BoligvarslingAction extends BaseDataTableAction
{
    public $requestMethod = DataTableAction::REQUEST_METHOD_POST;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        $this->query = Boligvarsling::find()
            ->select(['boligvarsling.*', 'COUNT(boligvarsling.id) AS totalSubscriptions'])
            ->with(['property'])
            ->groupBy(['email']);

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

        foreach ($columns as $column) {
            if ($column['searchable'] != 'true') {
                continue;
            }

            $value = empty($search['value']) ? $column['search']['value'] : $search['value'];

            $query->orFilterWhere(['like', $column['data'], $value]);
        }

        return $query;
    }
}