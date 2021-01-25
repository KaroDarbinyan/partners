<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AllPostNumber;

/**
 * AllPostNumberSearch represents the model behind the search form of `common\models\AllPostNumber`.
 */
class AllPostNumberSearch extends AllPostNumber
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['post_number', 'city', 'municipal_number', 'municipal_name', 'category', 'neighbourhood'], 'safe'],
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
    public function search($params)
    {
        $query = AllPostNumber::find();

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
        ]);

        $query->andFilterWhere(['like', 'post_number', $this->post_number])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'municipal_number', $this->municipal_number])
            ->andFilterWhere(['like', 'municipal_name', $this->municipal_name])
            ->andFilterWhere(['like', 'category', $this->category]);

        return $dataProvider;
    }
}
