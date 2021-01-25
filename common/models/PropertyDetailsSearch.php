<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PropertyDetailsSearch represents the model behind the search form of `frontend\models\PropertyDetails`.
 */
class PropertyDetailsSearch extends PropertyDetails
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'endretdato', 'markedsforingsdato', 'oppdragsnummer', 'arkivert', 'trukket', 'finn_orderno', 'solgt', 'oppdragsdato', 'utlopsdato', 'markedsforingsklart', 'vispaafinn', 'avdeling_id', 'ansatte1_id', 'ansatte2_id', 'gaardsnummer', 'bruksnummer', 'fylkesnummer', 'kommunenummer', 'postnummer', 'byggeaar', 'fastpris', 'prisantydning', 'prissamletsum', 'tomteareal', 'prom', 'bruksareal', 'bruttoareal', 'oppholdsrom', 'soverom', 'antallrom', 'totalkostnadsomtall', 'totalomkostningsomtall', 'bad', 'salgssum', 'etasje', 'borettslag_organisasjonsnummer', 'bokfortprovisjon', 'ligningsverdi', 'modernisert', 'fellesutgifter', 'andelfellesgjeld', 'overtagelse', 'kontraktsmoteinklklokkeslett', 'sold_date', 'is_visible', 'oppdragsnummer__prosjekthovedoppdrag'], 'integer'],
            [['type_eiendomstyper', 'type_eierformbygninger', 'type_eierformtomt', 'energimerke_bokstav', 'energimerke_farge', 'befaringsdato', 'prisvurderingsdato', 'fylkesnavn', 'kommuneomraade', 'kommunenavn', 'overskrift', 'poststed', 'adresse', 'totalkostnadsomtekst', 'finnmatchekriterier', 'akseptdato', 'borettslag', 'street', 'area', 'kommentarleie', 'urlelektroniskbudgivning', 'tinde_oppdragstype', 'finn_eiendomstype', 'finn_importstatisticsurl', 'lat', 'lng', 'sp_boost', 'firebase_id', 'slug', 'statusdato', 'bruksenhetsnummer'], 'safe'],
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
        $query = PropertyDetails::find();

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
            'endretdato' => $this->endretdato,
            'markedsforingsdato' => $this->markedsforingsdato,
            'oppdragsnummer' => $this->oppdragsnummer,
            'arkivert' => $this->arkivert,
            'trukket' => $this->trukket,
            'finn_orderno' => $this->finn_orderno,
            'solgt' => $this->solgt,
            'oppdragsdato' => $this->oppdragsdato,
            'utlopsdato' => $this->utlopsdato,
            'markedsforingsklart' => $this->markedsforingsklart,
            'vispaafinn' => $this->vispaafinn,
            'avdeling_id' => $this->avdeling_id,
            'ansatte1_id' => $this->ansatte1_id,
            'ansatte2_id' => $this->ansatte2_id,
            'gaardsnummer' => $this->gaardsnummer,
            'bruksnummer' => $this->bruksnummer,
            'fylkesnummer' => $this->fylkesnummer,
            'kommunenummer' => $this->kommunenummer,
            'postnummer' => $this->postnummer,
            'byggeaar' => $this->byggeaar,
            'fastpris' => $this->fastpris,
            'prisantydning' => $this->prisantydning,
            'prissamletsum' => $this->prissamletsum,
            'tomteareal' => $this->tomteareal,
            'prom' => $this->prom,
            'bruksareal' => $this->bruksareal,
            'bruttoareal' => $this->bruttoareal,
            'oppholdsrom' => $this->oppholdsrom,
            'soverom' => $this->soverom,
            'antallrom' => $this->antallrom,
            'totalkostnadsomtall' => $this->totalkostnadsomtall,
            'totalomkostningsomtall' => $this->totalomkostningsomtall,
            'bad' => $this->bad,
            'salgssum' => $this->salgssum,
            'etasje' => $this->etasje,
            'borettslag_organisasjonsnummer' => $this->borettslag_organisasjonsnummer,
            'bokfortprovisjon' => $this->bokfortprovisjon,
            'ligningsverdi' => $this->ligningsverdi,
            'modernisert' => $this->modernisert,
            'fellesutgifter' => $this->fellesutgifter,
            'andelfellesgjeld' => $this->andelfellesgjeld,
            'overtagelse' => $this->overtagelse,
            'kontraktsmoteinklklokkeslett' => $this->kontraktsmoteinklklokkeslett,
            'sold_date' => $this->sold_date,
            'is_visible' => $this->is_visible,
            'oppdragsnummer__prosjekthovedoppdrag' => $this->oppdragsnummer__prosjekthovedoppdrag,
        ]);

        $query->andFilterWhere(['like', 'type_eiendomstyper', $this->type_eiendomstyper])
            ->andFilterWhere(['like', 'type_eierformbygninger', $this->type_eierformbygninger])
            ->andFilterWhere(['like', 'type_eierformtomt', $this->type_eierformtomt])
            ->andFilterWhere(['like', 'energimerke_bokstav', $this->energimerke_bokstav])
            ->andFilterWhere(['like', 'energimerke_farge', $this->energimerke_farge])
            ->andFilterWhere(['like', 'befaringsdato', $this->befaringsdato])
            ->andFilterWhere(['like', 'prisvurderingsdato', $this->prisvurderingsdato])
            ->andFilterWhere(['like', 'fylkesnavn', $this->fylkesnavn])
            ->andFilterWhere(['like', 'kommuneomraade', $this->kommuneomraade])
            ->andFilterWhere(['like', 'kommunenavn', $this->kommunenavn])
            ->andFilterWhere(['like', 'overskrift', $this->overskrift])
            ->andFilterWhere(['like', 'poststed', $this->poststed])
            ->andFilterWhere(['like', 'adresse', $this->adresse])
            ->andFilterWhere(['like', 'totalkostnadsomtekst', $this->totalkostnadsomtekst])
            ->andFilterWhere(['like', 'finnmatchekriterier', $this->finnmatchekriterier])
            ->andFilterWhere(['like', 'akseptdato', $this->akseptdato])
            ->andFilterWhere(['like', 'borettslag', $this->borettslag])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'kommentarleie', $this->kommentarleie])
            ->andFilterWhere(['like', 'urlelektroniskbudgivning', $this->urlelektroniskbudgivning])
            ->andFilterWhere(['like', 'tinde_oppdragstype', $this->tinde_oppdragstype])
            ->andFilterWhere(['like', 'finn_eiendomstype', $this->finn_eiendomstype])
            ->andFilterWhere(['like', 'finn_importstatisticsurl', $this->finn_importstatisticsurl])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'lng', $this->lng])
            ->andFilterWhere(['like', 'sp_boost', $this->sp_boost])
            ->andFilterWhere(['like', 'firebase_id', $this->firebase_id])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'statusdato', $this->statusdato])
            ->andFilterWhere(['like', 'bruksenhetsnummer', $this->bruksenhetsnummer]);

        return $dataProvider;
    }
}
