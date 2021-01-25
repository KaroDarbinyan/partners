<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\WebmeglerEmployeeProperties;

/**
 * WebmeglerEmployeePropertiesSearch represents the model behind the search form of `common\models\WebmeglerEmployeeProperties`.
 */
class WebmeglerEmployeePropertiesSearch extends WebmeglerEmployeeProperties
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id__'], 'integer'],
            [['id', 'oppdragsnummer', 'markedsforingsklart', 'type_oppdragstatus', 'adresse'], 'safe'],
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
        $query = WebmeglerEmployeeProperties::find();

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
            ->andFilterWhere(['like', 'oppdragsnummer', $this->oppdragsnummer])
            ->andFilterWhere(['like', 'markedsforingsklart', $this->markedsforingsklart])
            ->andFilterWhere(['like', 'type_oppdragstatus', $this->type_oppdragstatus])
            ->andFilterWhere(['like', 'adresse', $this->adresse]);

        return $dataProvider;
    }
}
