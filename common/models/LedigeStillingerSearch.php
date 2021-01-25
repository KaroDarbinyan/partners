<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LedigeStillinger;

/**
 * LedigeStillingerSearch represents the model behind the search form of `common\models\LedigeStillinger`.
 */
class LedigeStillingerSearch extends LedigeStillinger
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kontor', 'status'], 'integer'],
            [['title'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $active = false)
    {
        $query = LedigeStillinger::find();
        if($active) {
            $query->isActive();
        }
        $query->orderBy(['date' => SORT_DESC]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'kontor' => $this->kontor,
            'date' => $this->date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
