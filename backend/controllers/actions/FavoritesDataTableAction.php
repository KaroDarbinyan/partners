<?php

namespace backend\controllers\actions;

use common\models\Forms;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class FavoritesDataTableAction extends BaseDataTableAction
{
    //public $requestMethod = DataTableAction::REQUEST_METHOD_POST;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $exists = (new Query())
            ->select('id')
            ->from('lead_log l')
            ->where('l.lead_id = forms.id AND l.type IN ("1014", "1020", "1017", "1011", "1009", "1008", "1018")');

        $this->query = Forms::find()
            ->joinWith(['leadLastLog'], false)
            ->select([
                '{{forms}}.*',
                '{{lead_log}}.message AS latestLogMessage',
            ])
            ->with(['reminder'])
            ->where(['not in', 'status', ['1020', '1017', '1013']])
            //->where(['in', 'forms.type', Forms::getColdTypes()])
            //->andWhere(['exists', $exists])
            ->andWhere(['forms.broker_id' => Yii::$app->user->identity->web_id, 'forms.favorite' => true]);

        parent::init();
    }

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

            $column = $columns[$item['column']]['data'];

            if ($column === 'reminder.notify_at') {
                $query->addOrderBy([
                    new Expression('lead_log.notify_at IS NULL ASC'),
                    'lead_log.notify_at' => $sort
                ]);
            } elseif ($column === 'address') {
                $query->addOrderBy([
                    new Expression('forms.address IS NULL ASC'),
                    'forms.address' => $sort
                ]);
            } else {
                $query->addOrderBy([$column => $sort]);
            }
        }

        return $query;
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