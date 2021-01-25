<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\WebmeglerEmployees;

/**
 * WebmeglerEmployeesSearch represents the model behind the search form of `common\models\WebmeglerEmployees`.
 */
class WebmeglerEmployeesSearch extends WebmeglerEmployees
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id__'], 'integer'],
            [['id', 'avdeling_id', 'navn', 'tittel', 'inaktiv', 'mobiltelefon', 'email', ], 'safe'],
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
        $query = WebmeglerEmployees::find();

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
            'id__' => $this->id__,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'avdeling_id', $this->avdeling_id])
            ->andFilterWhere(['like', 'navn', $this->navn])
            ->andFilterWhere(['like', 'tittel', $this->tittel])
            ->andFilterWhere(['like', 'inaktiv', $this->inaktiv])
            ->andFilterWhere(['like', 'mobiltelefon', $this->mobiltelefon])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
