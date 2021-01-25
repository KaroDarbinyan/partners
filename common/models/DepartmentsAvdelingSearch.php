<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DepartmentsAvdeling;

/**
 * DepartmentsAvdelingSearch represents the model behind the search form of `common\models\DepartmentsAvdeling`.
 */
class DepartmentsAvdelingSearch extends DepartmentsAvdeling
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id__'], 'integer'],
            [['id', 'id_firma', 'navn', 'juridisknavn', 'organisasjonsnummer', 'urlhtmlpresentasjon_avdeling', 'urlhtmlpresentasjon_konsern', 'logo_url', 'besoksadresse', 'postadresse', 'postnummer', 'poststed', 'telefon', 'telefax', 'email', 'hjemmeside', 'inaktiv', 'dagligleder', 'avdelingsleder', 'fagansvarlig', 'superbruker', 'bilder', 'fritekster'], 'safe'],
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
        $query = DepartmentsAvdeling::find();

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
            ->andFilterWhere(['like', 'id_firma', $this->id_firma])
            ->andFilterWhere(['like', 'navn', $this->navn])
            ->andFilterWhere(['like', 'juridisknavn', $this->juridisknavn])
            ->andFilterWhere(['like', 'organisasjonsnummer', $this->organisasjonsnummer])
            ->andFilterWhere(['like', 'urlhtmlpresentasjon_avdeling', $this->urlhtmlpresentasjon_avdeling])
            ->andFilterWhere(['like', 'urlhtmlpresentasjon_konsern', $this->urlhtmlpresentasjon_konsern])
            ->andFilterWhere(['like', 'logo_url', $this->logo_url])
            ->andFilterWhere(['like', 'besoksadresse', $this->besoksadresse])
            ->andFilterWhere(['like', 'postadresse', $this->postadresse])
            ->andFilterWhere(['like', 'postnummer', $this->postnummer])
            ->andFilterWhere(['like', 'poststed', $this->poststed])
            ->andFilterWhere(['like', 'telefon', $this->telefon])
            ->andFilterWhere(['like', 'telefax', $this->telefax])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'hjemmeside', $this->hjemmeside])
            ->andFilterWhere(['like', 'inaktiv', $this->inaktiv])
            ->andFilterWhere(['like', 'dagligleder', $this->dagligleder])
            ->andFilterWhere(['like', 'avdelingsleder', $this->avdelingsleder])
            ->andFilterWhere(['like', 'fagansvarlig', $this->fagansvarlig])
            ->andFilterWhere(['like', 'superbruker', $this->superbruker])
            ->andFilterWhere(['like', 'bilder', $this->bilder])
            ->andFilterWhere(['like', 'fritekster', $this->fritekster]);

        return $dataProvider;
    }
}
