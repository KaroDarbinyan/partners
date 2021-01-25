<?php

namespace api\modules\mobile\modules\v1\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "property_details".
 *
 * @property int $id
 * @property string $statusdato
 * @property string $endretdato
 * @property int $markedsforingsdato
 * @property string $oppdragsnummer
 * @property int $arkivert
 * @property int $trukket
 * @property string $type_eiendomstyper
 * @property string $type_eierformbygninger
 * @property string $type_eierformtomt
 * @property string $finn_orderno
 * @property string $energimerke_bokstav
 * @property string $energimerke_farge
 * @property string $befaringsdato
 * @property string $prisvurderingsdato
 * @property int $solgt
 * @property string $oppdragsdato
 * @property string $utlopsdato
 * @property int $markedsforingsklart
 * @property int $vispaafinn
 * @property string $avdeling_id
 * @property string $ansatte1_id
 * @property string $ansatte2_id
 * @property string $gaardsnummer
 * @property string $bruksnummer
 * @property string $fylkesnummer
 * @property string $fylkesnavn
 * @property string $kommuneomraade
 * @property string $kommunenummer
 * @property string $kommunenavn
 * @property string $overskrift
 * @property string $postnummer
 * @property string $poststed
 * @property string $adresse
 * @property int $byggeaar
 * @property int $fastpris
 * @property string $prisantydning
 * @property string $prissamletsum
 * @property string $tomteareal
 * @property int $prom
 * @property string $bruksareal
 * @property string $bruttoareal
 * @property int $oppholdsrom
 * @property int $soverom
 * @property int $antallrom
 * @property string $totalkostnadsomtekst
 * @property string $totalkostnadsomtall
 * @property string $totalomkostningsomtall
 * @property string $finnmatchekriterier
 * @property int $bad
 * @property string $akseptdato
 * @property string $salgssum
 * @property int $etasje
 * @property string $borettslag
 * @property string $borettslag_organisasjonsnummer
 * @property string $street
 * @property string $area
 * @property string $bokfortprovisjon
 * @property int $ligningsverdi
 * @property string $kommentarleie
 * @property string $urlelektroniskbudgivning
 * @property int $modernisert
 * @property string $tinde_oppdragstype
 * @property int $fellesutgifter
 * @property int $andelfellesgjeld
 * @property string $finn_eiendomstype
 * @property string $finn_importstatisticsurl
 * @property int $overtagelse
 * @property int $kontraktsmoteinklklokkeslett
 * @property string $lat
 * @property string $lng
 * @property int $sold_date
 * @property Property $property
 * @property ActiveQuery $broker
 * @property ActiveQuery $freeText
 * @property mixed $brokerAvatar
 * @property ActiveQuery $image
 * @property ActiveQuery $neighbors
 * @property Image[] $images
 * @property ActiveQuery $broker1
 * @property ActiveQuery $broker2
 * @property string $firebase_id
 */
class PropertyDetails extends ActiveRecord
{
    /**
     * @return ActiveQuery
     */
    public function getFreeText()
    {
        return $this->hasOne(FreeText::className(), ['propertyDetailId' => 'id'])
            ->andWhere(['free_text.overskrift' => 'Finn.no: Lokalområde']);
    }

    /**
     * @return ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['propertyDetailId' => 'id'])->andOnCondition(['nr' => 1]);
    }

    /**
     * @return ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['propertyDetailId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['web_id' => 'id']);
    }


    /**
     * @return ActiveQuery
     */
    public function getNeighbors()
    {
        return $this->hasMany(PropertyNeighbourhood::className(), ['property_web_id' => 'id']);
    }


    /**
     * @return ActiveQuery
     */
    public function getBroker1()
    {
        return $this->hasOne(User::className(), ["web_id" => "ansatte1_id"])->select(User::$fields);
    }

    /**
     * @return ActiveQuery
     */
    public function getBroker2()
    {
        return $this->hasOne(User::className(), ["web_id" => "ansatte2_id"])->select(User::$fields);
    }


    public function getBrokerAvatar()
    {
        return $this->user->urlstandardbilde;
    }

    /**
     * @return ActiveQuery
     */
    public static function getFilteredProperties()
    {
        $query = self::find()
            ->with([
                'freeText', 'image', 'property', 'broker1', 'broker2'
            ])->andWhere([
                'property_details.arkivert' => 0,
                'property_details.vispaafinn' => -1,
                "property_details.tinde_oppdragstype" => "Til salgs",
                'property_details.avdeling_id' => Yii::$app->user->identity->department_id
            ])
            ->andWhere(['or',
                ['property_details.solgt' => 0],
                'DATE_ADD(STR_TO_DATE(`property_details`.`akseptdato`, "%d.%m.%Y"), INTERVAL 30 DAY) >= CURRENT_DATE()'
            ])
            ->andWhere(['or',
                ['=', 'property_details.utlopsdato', 0],
                ['>', 'property_details.utlopsdato', time()]
            ]);

        return $query->asArray();
    }


    /**
     * for /api/mobile/v1/befaring/oppdrag/eiendomer
     * @return ActiveQuery
     */
    public static function getMarkers()
    {
        $query = self::find()
            ->select(["id", "CONCAT_WS(', ', `adresse`, `postnummer`, `poststed`) AS address", "lat", "lng"])
            ->andWhere(['property_details.avdeling_id' => Yii::$app->user->identity->department_id])
            ->andWhere(['not', ['lat' => null, 'lng' => null]])->asArray();

        if (false) {
            $query = $query->andWhere([
                'property_details.arkivert' => 0,
                'property_details.vispaafinn' => -1,
                "property_details.tinde_oppdragstype" => "Til salgs",
            ])->andWhere(['or',
                ['property_details.solgt' => 0],
                'DATE_ADD(STR_TO_DATE(`property_details`.`akseptdato`, "%d.%m.%Y"), INTERVAL 30 DAY) >= CURRENT_DATE()'
            ])
                ->andWhere(['or',
                    ['=', 'property_details.utlopsdato', 0],
                    ['>', 'property_details.utlopsdato', time()]
                ]);
        }

        if (false && ($filter = Yii::$app->request->get("filter"))) {
            $query->andWhere(['>=', 'byggeaar', $filter['year'] - 1])
                ->andWhere(['or',
                    ['between', 'prom', $filter['meter'] - 10, $filter['meter'] + 10],
                    ['prom' => null]
                ])
                ->andWhere(['or',
                    ['between', 'salgssum', $filter['price'] - 500000, $filter['price'] + 500000],
                    ['salgssum' => null],
                    ['salgssum' => '']
                ])
                ->orWhere(['id' => Yii::$app->request->get('id')]);
        }

        return $query;
    }


    public static function fbFields()
    {
        return [
            "id",
            "statusdato",
//            "endretdato",
//            "markedsforingsdato",
            "oppdragsnummer",
//            "arkivert",
            "trukket",
            "type_eiendomstyper",
            "type_eierformbygninger",
            "type_eierformtomt",
//            "finn_orderno",
//            "energimerke_bokstav",
//            "energimerke_farge",
//            "befaringsdato",
            "prisvurderingsdato",
            "solgt",
//            "oppdragsdato",
            "utlopsdato",
//            "markedsforingsklart",
            "vispaafinn",
            "avdeling_id",
            "ansatte1_id",
            "ansatte2_id",
//            "gaardsnummer",
//            "bruksnummer",
//            "fylkesnummer",
//            "fylkesnavn",
//            "kommuneomraade",
//            "kommunenummer",
//            "kommunenavn",
            "overskrift",
            "postnummer",
            "poststed",
            "adresse",
//            "byggeaar",
//            "fastpris",
            "prisantydning",
            "prissamletsum",
            "tomteareal",
            "prom",
            "bruksareal",
//            "bruttoareal",
            "oppholdsrom",
            "soverom",
            "antallrom",
            "totalkostnadsomtekst",
            "totalkostnadsomtall",
            "totalomkostningsomtall",
//            "finnmatchekriterier",
            "bad",
            "akseptdato",
            "salgssum",
            "etasje",
            "borettslag",
            "borettslag_organisasjonsnummer",
            "street",
            "area",
            "bokfortprovisjon",
//            "ligningsverdi",
//            "kommentarleie",
            "urlelektroniskbudgivning",
            "modernisert",
            "tinde_oppdragstype",
            "fellesutgifter",
            "andelfellesgjeld",
            "finn_eiendomstype",
//            "finn_importstatisticsurl",
            "overtagelse",
            "kontraktsmoteinklklokkeslett",
//            "lat",
//            "lng",
            "sold_date",
            "sp_boost",
            "firebase_id"
        ];
    }
}
