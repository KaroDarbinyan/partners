<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\WebmeglerContacts;

/**
 * WebmeglerContactsSearch represents the model behind the search form of `common\models\WebmeglerContacts`.
 */
class WebmeglerContactsSearch extends WebmeglerContacts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id__'], 'integer'],
            [['id', 'har_tilgang_til_detaljer', 'kontakttype', 'id_kontakter__ny', 'id_kunder', 'fornavn', 'etternavn', 'firmanavn', 'organisasjonsnummer', 'adresse', 'postnummer', 'poststed', 'land', 'nyadresse', 'nypostnummer', 'nypoststed', 'nyadressefradato', 'nyland', 'email', 'telefon', 'mobiltelefon', 'personnummer', 'fodselsdato', 'id_ansatte__registrertav', 'id_ansatte__endretav', 'endretdato', 'registrertdato', 'relatertegrupper', 'budgiveroppdrag', 'andrekontakteroppdrag', 'interessentoppdrag', 'selgerkjoperoppdrag', 'samtykkeregistreringer'], 'safe'],
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
        $query = WebmeglerContacts::find();

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
            ->andFilterWhere(['like', 'har_tilgang_til_detaljer', $this->har_tilgang_til_detaljer])
            ->andFilterWhere(['like', 'kontakttype', $this->kontakttype])
            ->andFilterWhere(['like', 'id_kontakter__ny', $this->id_kontakter__ny])
            ->andFilterWhere(['like', 'id_kunder', $this->id_kunder])
            ->andFilterWhere(['like', 'fornavn', $this->fornavn])
            ->andFilterWhere(['like', 'etternavn', $this->etternavn])
            ->andFilterWhere(['like', 'firmanavn', $this->firmanavn])
            ->andFilterWhere(['like', 'organisasjonsnummer', $this->organisasjonsnummer])
            ->andFilterWhere(['like', 'adresse', $this->adresse])
            ->andFilterWhere(['like', 'postnummer', $this->postnummer])
            ->andFilterWhere(['like', 'poststed', $this->poststed])
            ->andFilterWhere(['like', 'land', $this->land])
            ->andFilterWhere(['like', 'nyadresse', $this->nyadresse])
            ->andFilterWhere(['like', 'nypostnummer', $this->nypostnummer])
            ->andFilterWhere(['like', 'nypoststed', $this->nypoststed])
            ->andFilterWhere(['like', 'nyadressefradato', $this->nyadressefradato])
            ->andFilterWhere(['like', 'nyland', $this->nyland])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'telefon', $this->telefon])
            ->andFilterWhere(['like', 'mobiltelefon', $this->mobiltelefon])
            ->andFilterWhere(['like', 'personnummer', $this->personnummer])
            ->andFilterWhere(['like', 'fodselsdato', $this->fodselsdato])
            ->andFilterWhere(['like', 'id_ansatte__registrertav', $this->id_ansatte__registrertav])
            ->andFilterWhere(['like', 'id_ansatte__endretav', $this->id_ansatte__endretav])
            ->andFilterWhere(['like', 'endretdato', $this->endretdato])
            ->andFilterWhere(['like', 'registrertdato', $this->registrertdato])
            ->andFilterWhere(['like', 'relatertegrupper', $this->relatertegrupper])
            ->andFilterWhere(['like', 'budgiveroppdrag', $this->budgiveroppdrag])
            ->andFilterWhere(['like', 'andrekontakteroppdrag', $this->andrekontakteroppdrag])
            ->andFilterWhere(['like', 'interessentoppdrag', $this->interessentoppdrag])
            ->andFilterWhere(['like', 'selgerkjoperoppdrag', $this->selgerkjoperoppdrag])
            ->andFilterWhere(['like', 'samtykkeregistreringer', $this->samtykkeregistreringer]);

        return $dataProvider;
    }
}
