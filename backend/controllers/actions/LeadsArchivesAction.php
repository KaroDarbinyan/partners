<?php

namespace backend\controllers\actions;

use common\models\ArchiveForm;
use nullref\datatable\DataTableAction;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

final class LeadsArchivesAction extends BaseDataTableAction
{
    public $requestMethod = DataTableAction::REQUEST_METHOD_POST;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        $this->query = ArchiveForm::find()
            ->with(['broker', 'department', 'propertyDetails']);

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
            $value = $column['search']['value'];


            // $query->andFilterWhere(['']);
        }
        return $query;
    }
}