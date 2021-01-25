<?php

namespace common\models;


use Yii;
use yii\helpers\Url;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\helpers\ArrayHelper;
use common\components\CdnComponent;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "property_details".
 *
 * @property int $id
 * @property int $endretdato
 * @property int $markedsforingsdato
 * @property string $oppdragsnummer
 * @property int $arkivert
 * @property int $trukket
 * @property string $type_eiendomstyper
 * @property string $type_eierformbygninger
 * @property string $type_eierformtomt
 * @property int $finn_orderno
 * @property string $energimerke_bokstav
 * @property string $energimerke_farge
 * @property string $befaringsdato
 * @property string $prisvurderingsdato
 * @property int $solgt
 * @property int $oppdragsdato
 * @property int $utlopsdato
 * @property int $markedsforingsklart
 * @property int $vispaafinn
 * @property int $avdeling_id
 * @property int $ansatte1_id
 * @property int $ansatte2_id
 * @property int $gaardsnummer
 * @property int $bruksnummer
 * @property int $fylkesnummer
 * @property string $fylkesnavn
 * @property string $kommuneomraade
 * @property int $kommunenummer
 * @property string $kommunenavn
 * @property string $overskrift
 * @property int $postnummer
 * @property string $poststed
 * @property string $adresse
 * @property int $byggeaar
 * @property int $fastpris
 * @property int $prisantydning
 * @property int $prissamletsum
 * @property int $tomteareal
 * @property int $prom
 * @property int $bruksareal
 * @property int $bruttoareal
 * @property int $oppholdsrom
 * @property int $soverom
 * @property int $antallrom
 * @property string $totalkostnadsomtekst
 * @property int $totalkostnadsomtall
 * @property int $totalomkostningsomtall
 * @property string $finnmatchekriterier
 * @property int $bad
 * @property string $akseptdato
 * @property int $salgssum
 * @property int $etasje
 * @property string $borettslag
 * @property string $borettslag_organisasjonsnummer
 * @property string $street
 * @property string $area
 * @property int $bokfortprovisjon
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
 * @property string $sp_boost
 * @property string $firebase_id
 * @property string $slug
 * @property int $is_visible
 * @property int $oppdragsnummer__prosjekthovedoppdrag
 * @property string $bruksenhetsnummer
 * @property string $databasenummer
 * @property string $urlbilder
 *
 * @property string $title
 * @property Docs[] $propertyDocs
 * @property Docs $propertyDoc
 * @property FreeText[] $freeTexts
 * @property Image[] $images
 * @property Department $department
 * @property User $user
 * @property User $user2
 * @property PropertyVisits[] $propertyVisits
 * @property PropertyNabolagsprofil $propertyNeighbourhood
 * @property PropertyNabolagsprofil[] $propertyNeighbourhoods
 * @property PropertyLinks $salgsoppgaveDownloadLink
 * @property PercentText[] $percentTexts
 * @property Forms[] $leads
 * @property Forms[] $sellers
 * @property Partner $partner
 * @property PropertyAds $propertyAds
 * @property Docs $salgsoppgavePDFDownloadLink
 * @property PropertyDetails[] $properties
 * @property PropertyDetails $parent
 * @property FreeText $freeTextTitle
 * @property Criterias[] $criterions
 * @property Accounting $accounting
 * @property ArchiveForm[] $selgers
 * @property ArchiveForm[] $kjopers
 * @property AllPostNumber $allPostNumber
 * @property DigitalMarketing[] $digitalMarketingDeltaStandard
 * @property bool $involve_adv
 * @property int $forventet_salgspris
 * @property PropertyEvent[] $propertiesEvents
 * @property PropertyPrint $propertyPrint
 */
class PropertyDetails extends ActiveRecord
{
    public $leadsCount;
    public $area_real;

    private $title;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_details';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => null,
                'ensureUnique' => false,
                'immutable' => false,
                'value' => function ($event) {
                    return $this->generateSlug();
                }
            ],
        ];
    }

    /**
     * Get the slug for property.
     *
     * @return string
     */
    public function generateSlug()
    {
        $slug = Inflector::slug("$this->poststed $this->kommuneomraade $this->postnummer $this->adresse $this->soverom roms $this->type_eiendomstyper");

        return preg_replace('!\s{2,}|-{2,}+!u', '', $slug);
    }

    /**
     * Save slug for property.
     *
     * @return void
     */
    public function saveSlug()
    {
        try {
            $this->slug = $this->generateSlug();
            $this->update(false);
        } catch (\Throwable $e) {}
    }

    /**
     *
     *
     * @return PropertyDetailsQuery|ActiveQuery
     */
    public static function find()
    {
        return new PropertyDetailsQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['endretdato', 'markedsforingsdato', 'oppdragsnummer', 'arkivert', 'trukket', 'finn_orderno', 'solgt', 'oppdragsdato', 'utlopsdato', 'markedsforingsklart', 'vispaafinn', 'avdeling_id', 'ansatte1_id', 'ansatte2_id', 'gaardsnummer', 'bruksnummer', 'fylkesnummer', 'kommunenummer', 'postnummer', 'byggeaar', 'fastpris', 'prisantydning', 'prissamletsum', 'tomteareal', 'prom', 'bruksareal', 'bruttoareal', 'oppholdsrom', 'soverom', 'antallrom', 'totalkostnadsomtall', 'totalomkostningsomtall', 'bad', 'salgssum', 'etasje', 'borettslag_organisasjonsnummer', 'bokfortprovisjon', 'ligningsverdi', 'modernisert', 'fellesutgifter', 'andelfellesgjeld', 'overtagelse', 'kontraktsmoteinklklokkeslett', 'sold_date', 'is_visible', 'oppdragsnummer__prosjekthovedoppdrag', 'databasenummer'], 'integer'],
            [['befaringsdato', 'prisvurderingsdato', 'overskrift', 'totalkostnadsomtekst', 'finnmatchekriterier', 'akseptdato', 'borettslag', 'kommentarleie', 'urlelektroniskbudgivning', 'finn_importstatisticsurl'], 'string'],
            [['type_eiendomstyper', 'type_eierformbygninger', 'type_eierformtomt', 'energimerke_farge', 'fylkesnavn', 'kommuneomraade', 'kommunenavn', 'poststed', 'adresse', 'street', 'area', 'tinde_oppdragstype', 'finn_eiendomstype', 'lat', 'lng', 'firebase_id', 'slug', 'bruksenhetsnummer', 'sp_boost'], 'string', 'max' => 255],
            [['energimerke_bokstav'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'endretdato' => 'Endretdato',
            'oppdragsnummer' => 'Oppdragsnummer',
            'arkivert' => 'Arkivert',
            'trukket' => 'Trukket',
            'type_eiendomstyper' => 'Type Eiendomstyper',
            'type_eierformbygninger' => 'Type Eierformbygninger',
            'type_eierformtomt' => 'Type Eierformtomt',
            'finn_orderno' => 'Finn Orderno',
            'energimerke_bokstav' => 'Energimerke Bokstav',
            'energimerke_farge' => 'Energimerke Farge',
            'befaringsdato' => 'Befaringsdato',
            'prisvurderingsdato' => 'Prisvurderingsdato',
            'solgt' => 'Solgt',
            'oppdragsdato' => 'Oppdragsdato',
            'utlopsdato' => 'Utlopsdato',
            'markedsforingsklart' => 'Markedsforingsklart',
            'vispaafinn' => 'Vispåfinn',
            'avdeling_id' => 'Avdeling ID',
            'ansatte1_id' => 'Ansatte1 ID',
            'ansatte2_id' => 'Ansatte2 ID',
            'gaardsnummer' => 'Gårdsnummer',
            'bruksnummer' => 'Bruksnummer',
            'fylkesnummer' => 'Fylkesnummer',
            'fylkesnavn' => 'Fylkesnavn',
            'kommuneomraade' => 'Kommuneområde',
            'kommunenummer' => 'Kommunenummer',
            'kommunenavn' => 'Kommunenavn',
            'overskrift' => 'Overskrift',
            'postnummer' => 'Postnummer',
            'poststed' => 'Poststed',
            'adresse' => 'Adresse',
            'byggeaar' => 'Byggeår',
            'fastpris' => 'Fastpris',
            'prisantydning' => 'Prisantydning',
            'prissamletsum' => 'Prissamletsum',
            'tomteareal' => 'Tomteareal',
            'prom' => 'Primærrom',
            'bruksareal' => 'Bruksareal',
            'bruttoareal' => 'Bruttoareal',
            'oppholdsrom' => 'Oppholdsrom',
            'soverom' => 'Soverom',
            'antallrom' => 'Antallrom',
            'totalkostnadsomtekst' => 'Totalkostnadsomtekst',
            'totalkostnadsomtall' => 'Totalpris',
            'totalomkostningsomtall' => 'Omkostninger',
            'finnmatchekriterier' => 'Kriterier',
            'bad' => 'Bad',
            'akseptdato' => 'Akseptdato',
            'salgssum' => 'Salgssum',
            'etasje' => 'Etasje',
            'borettslag' => 'Borettslag',
            'borettslag_organisasjonsnummer' => 'Borettslag Organisasjonsnummer',
            'street' => 'Adresse',
            'area' => 'Område',
            'bokfortprovisjon' => 'Bokfortprovisjon',
            'urlelektroniskbudgivning' => 'Urlelektroniskbudgivning',
            'ligningsverdi' => 'Ligningsverdi',
            'kommentarleie' => 'Kommentarleie',
            'modernisert' => 'Modernisert',
            'tinde_oppdragstype' => 'Tinde Oppdragstype',
            'andelfellesgjeld' => 'Fellesgjeld',
            'fellesutgifter' => 'Fellesutgifter',
            'finn_eiendomstype' => 'Eiendomstype',
            'finn_importstatisticsurl' => 'Finn Statistikk',
            'markedsforingsdato' => 'Markedsforingsdato',
            'overtagelse' => 'Overtagelse',
            'kontraktsmoteinklklokkeslett' => 'Kontraktsmøte',
            'sold_date' => 'Sold Date',
            'is_visible' => 'Is Visible',
            'oppdragsnummer__prosjekthovedoppdrag' => 'Sold Date',
            'bruksenhetsnummer' => 'Bruksenhets Nummer',
            'databasenummer' => 'Database Id',
        ];
    }

    public function getCriterions()
    {
        return $this->hasMany(Criterias::class, ['property_web_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->freeTextTitle->htmltekst ?? $this->poststed ?? $this->kommuneomraade;
    }

    public function getFreeTextTitle()
    {
        return $this->hasOne(FreeText::class, ['propertyDetailId' => 'id'])
            ->where(['like', 'overskrift', 'Finn.no: Lokalområde']);
    }

    public function getProperties()
    {
        return $this->hasMany(self::class, ['oppdragsnummer__prosjekthovedoppdrag' => 'oppdragsnummer'])
            ->alias('p')
            ->where(['not', ['p.id' => $this->id]])
            ->andWhere([
                'p.markedsforingsklart' => -1,
                'p.solgt' => 0
            ]);
    }

    public function getParent()
    {
        return $this->hasOne(self::class, ['oppdragsnummer' => 'oppdragsnummer__prosjekthovedoppdrag'])
            ->alias('pp')
            ->where(['not', ['pp.oppdragsnummer' => $this->oppdragsnummer]]);
    }

    public function isParent()
    {
        $projectOppdragnummer = $this->getAttribute('oppdragsnummer__prosjekthovedoppdrag');

        return $projectOppdragnummer == $this->oppdragsnummer && !is_null($projectOppdragnummer);
    }

    public function isNewBuilding()
    {
        return $this->tinde_oppdragstype === 'Prosjekt';
    }

    public function getCost()
    {
        return $this->getCostRange('prisantydning');
    }

    public function getTotalCost()
    {
        return $this->getCostRange('totalkostnadsomtall');
    }

    public function getCostRange($column)
    {
        if ($this->isRelationPopulated('properties')) {
            $range = ArrayHelper::getColumn($this->properties, $column);
            $range = array_unique($range);

            $range = array_filter($range, function ($val) {
                return $val > 0;
            });

            $range = array_map(function($val) {
                return number_format($val, 0, ' ', ' ');
            }, $range);

            if (count($range) >= 2) {
                return min($range) . ' - ' . max($range);
            }

            if (count($range)) {
                return min($range);
            }
        }

        return $this->{$column} > 0 ? number_format($this->{$column}, 0, ' ', ' ') : '';
    }

    public function getGalleryImages()
    {
        if (empty($this->images) && $this->parent) {
            return [$this->parent->propertyImage];
        }

        return $this->images;
    }

    public function getProm()
    {
        if ($this->isRelationPopulated('properties')) {
            $range = ArrayHelper::getColumn($this->properties, 'bruksareal');
            $range = array_unique($range);
            $range = array_filter($range);

            if (count($range) > 1) {
                return min($range) . ' - ' . max($range);
            }
        }

        return $this->propertyArea();
    }

    /**
     * @return ActiveQuery
     */
    public function getLeads()
    {
        return $this->hasMany(Forms::class, ['target_id' => 'id']);
    }

    /**
     * The property consists a sellers.
     *
     * @return ActiveQuery
     */
    public function getSellers()
    {
        return $this->getLeads()
            ->where(['type' => 'selger']);
    }

    /**
     * @return ActiveQuery
     */
    public function getFreeTexts()
    {
        return $this->hasMany(FreeText::class, ['propertyDetailId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::class, ['propertyDetailId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPropertyDocs()
    {
        return $this->hasMany(Docs::class, ['property_web_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPropertyDoc()
    {
        return $this->hasOne(Docs::class, ['property_web_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['web_id' => 'ansatte1_id'])
            ->where(['inaktiv_status' => -1]);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser2()
    {
        return $this->hasOne(User::class, ['web_id' => 'ansatte2_id'])
            ->where(['not', ['web_id' => $this->ansatte1_id]])
            ->onCondition(['inaktiv_status' => -1]);
    }

    /**
     * Get a brokers for property.
     *
     * @return array|User[]
     */
    public function getBrokers()
    {
        return array_filter([$this->user, $this->user2]);
    }

    /**
     * @return ActiveQuery
     */
    public function getAnsatte2()
    {
        return $this->hasOne(User::class, ['web_id' => 'ansatte2_id'])
            ->where(['inaktiv_status' => -1]);
    }

    /**
     * @return ActiveQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Department::class, ['web_id' => 'avdeling_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPropertyVisits()
    {
        return $this->hasMany(PropertyVisits::class, ['property_web_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['web_id' => 'avdeling_id']);
            //->alias('d2');
    }

    /**
     * @return ActiveQuery
     */
    public function getPropertyImage()
    {
        return $this->hasOne(Image::class, ['propertyDetailId' => 'id'])
            ->orderBy(['nr' => SORT_ASC]);
    }

    /**
     * @return ActiveQuery
     */
    public function getDoc()
    {
        return $this->hasOne(Docs::class, ['property_web_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPropertyNeighbourhood(){
        return $this->hasOne(PropertyNeighbourhood::class, ['property_web_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPropertyNeighbourhoods()
    {
        return $this->hasMany( PropertyNeighbourhood::class, ['property_web_id' => 'id'] );
    }

    /**
     * @return ActiveQuery
     */
    public function getNabolagsprofilLink()
    {
        return $this->hasOne(PropertyLinks::class, ['property_web_id' => 'id'])
            ->andOnCondition([PropertyLinks::tableName() . '.navn' => 'Interaktiv Nabolagsprofil']);
    }

    /**
     * @return ActiveQuery
     *
     * Will be deprecated when database get updated docs, also remove all usages of current relation
     */
    public function getSalgsoppgaveDownloadLink()
    {
        return $this->hasOne(PropertyLinks::class, ['property_web_id' => 'id'])
            ->andOnCondition(['like', 'navn', 'Digitalformat salgsoppgave - '])
        ;
    }

    /**
     * @return ActiveQuery
     */
    public function getSalgsoppgavePDFDownloadLink()
    {
        return $this->hasOne(Docs::class, ['property_web_id' => 'id'])
            ->andOnCondition(['typeid' => [3706, 3742]])
            ->orderBy(['id' => SORT_DESC]);
    }

    public static function getBefaringerCount($start, $end, $condition)
    {
        $count = self::find()
            ->andWhere(['between', 'UNIX_TIMESTAMP(STR_TO_DATE(befaringsdato, "%d.%m.%Y"))', $start, $end]);
        if ($condition) {
            $count = $count->andWhere($condition);
        }
          return $count->count('id');
    }

    public static function getSigneringerCount($start, $end, $condition)
    {
        $count = self::find()
            ->andWhere(['not', ['oppdragsnummer' => null]])
            ->andWhere(['between', 'oppdragsdato', $start, $end]);
        if ($condition) {
            $count = $count->andWhere($condition);
        }

        return $count->count('oppdragsnummer');
    }


    public static function getSalgSolgtCount($start, $end, $condition)
    {
        $count = self::find()
            ->andWhere(['solgt' => -1])
            ->andWhere(['between', 'UNIX_TIMESTAMP(STR_TO_DATE(akseptdato, "%d.%m.%Y"))', $start, $end]);
        if ($condition) {
            $count = $count->andWhere($condition);
        }
            return $count->count('solgt');
    }


    public static function getProvisjonSum($start, $end, $condition)
    {
        $count = self::find()
            ->andWhere(['solgt' => -1])
            ->andWhere(['between', 'UNIX_TIMESTAMP(STR_TO_DATE(akseptdato, "%d.%m.%Y"))', $start, $end]);
        if ($condition) {
            $count = $count->andWhere($condition);
        }
           return $count->sum('bokfortprovisjon');
    }

    /**
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ((int)$this->solgt === -1) {
            $this->tinde_oppdragstype = 'Solgt';
        }

        // Temporary
        $this->slug = $this->generateSlug();

        return parent::beforeSave($insert);
    }

    public function getDigitalMarketing()
    {
        return $this->hasMany(DigitalMarketing::class, ['source_object_id' => 'oppdragsnummer']);
    }

    public function getDigitalMarketingDeltaStandard()
    {
        return $this->hasMany(DigitalMarketing::class, ['source_object_id' => 'oppdragsnummer'])
            ->select(['stats'])
            ->andWhere(['not', ['digital_marketing.stats'=>null]])
            ->andWhere(['in', 'digital_marketing.type', ['deltaStandard', 'instagram', 'facebook', 'facebookAB', 'facebookVideo']])
            ->column();
    }

    public function getPropertyPrint()
    {
        return $this->hasOne(PropertyPrint::class, ['property_id' => 'id']);
    }

    public function getRegisterAt()
    {
        return strftime("%d. %B %Y %H:%M ", $this->oppdragsdato);
    }

    public function getBrokerDepartmentShortName()
    {
        return $this->user && $this->user->department ? $this->user->department->short_name : '';
    }

    public function getBrokerAvatar()
    {
        return $this->user ? $this->user->urlstandardbilde : '';
    }

    /*public function getLeadsCount()
    {
        return count($this->leads);
    }*/

    public function fields()
    {
        return array_merge(parent::fields(), [
            'brokerDepartmentShortName',
            'brokerAvatar',
            //'leadsCount'
        ]);
    }

    public static function getSalgssnitt()
    {
        $data = [];
        $office = false;
        $user = Yii::$app->user->identity;

        if (Yii::$app->request->get('office')) {
            $office = Yii::$app->request->get('office');
        }
        if (Yii::$app->request->get('user')) {
            $office = Yii::$app->request->get('user');
        }
        $properties = self::find()
            ->select([
                'substring(property_details.akseptdato,7,4) as year',
                'substring(property_details.akseptdato,4,2) as month',
                'COUNT(property_details.id) as count',
            ])
            ->where(['in', 'substring(property_details.akseptdato,7,4)', range(2015, date('Y')), 'and', 'property_details.solgt' => '-1']);

        if ($office) {
            if ($office === $user->url) {
                $properties = $properties
                    ->addSelect(['property_details.ansatte1_id'])
                    ->joinWith('user')
                    ->andWhere(['user.url' => $user->url]);
            } else {
                $properties = $properties
                    ->addSelect(['property_details.avdeling_id'])
                    ->joinWith('department')
                    ->andWhere(['department.url' => $office]);
            }
        }

        $properties = $properties
            ->orderBy(['year' => SORT_ASC])
            ->groupBy(['year', 'month'])
            ->asArray()
            ->all();

        foreach ($properties as $key => $property) {
            $data[$property['year']]['months'][] = (int)$property['count'];
            $data[$property['year']]['total'] = array_sum($data[$property['year']]['months']);
        }

        foreach ($data as $year => $value) {
            for ($i = 0; $i < 12; $i++) {
                if ($year == date('Y')) {
                    $average = 0;
                    foreach ($data as $item) {
                        if (!isset($item['months'][$i])) {
                            $item['months'][$i]['average'] = 0;
                        }
                        $average += $item['months'][$i]['average'];
                    }

                    $average = round($average / (count($data) - 1), 1);
                    $current = 0;

                    if (isset($data[$year]['months'][$i]) && $i + 1 != date('n')) {
                        $current = round(($value['months'][$i] * 100) / $value['total'], 1);
                    }

                    $data[$year]['months'][$i] = $current > 0
                        ? ['current' => $current, 'average' => $average]
                        : ['average' => $average];
                } else {
                    if (!isset($data[$year]['months'][$i])) {
                        $data[$year]['months'][$i]['average'] = 0;
                    } else {
                        $data[$year]['months'][$i] = ['average' => round(($value['months'][$i] * 100) / $value['total'], 1)];
                    }
                }
            }
        }

        return $data;
    }

    /**
     * @return ActiveQuery
     */
    public function getPercentTexts()
    {
        return $this->hasMany(PercentText::class, ['property_web_id' => 'id']);
    }

    public function getAllPostNumber()
    {
        return $this->hasOne(AllPostNumber::class, ['post_number' => 'postnummer']);
    }

    public function getPropertyAds()
    {
        return $this->hasOne(PropertyAds::class, ['property_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getPartner()
    {
        return $this->hasOne(Partner::class, ['id' => 'partner_id'])
            ->viaTable(Department::tableName(), ['web_id' => 'avdeling_id']);
    }

    /**
     * Determine if the current property is marked as the sold.
     *
     * @return bool
     */
    public function isSold(): bool
    {
        return $this->solgt == -1;
    }

    /**
     * Get a string path for the property.
     *
     * @return string
     */
    public function path(): string
    {
        return Url::toRoute(['properties/show',
            'id' => $this->oppdragsnummer,
            'slug' => $this->slug ?? $this->generateSlug()
        ], true);
    }

    /**
     * Get the string property area column.
     *
     * @return string
     */
    private function getPropertyAreaColumn()
    {
        static $types = [
            'Hytte' => 'prom',
            'Enebolig' => 'prom',
            'Tomannsbolig' => 'prom',
            'Leilighet' => 'prom',
            'Rekkehus' => 'prom',
            'Andelsleilighet' => 'prom',
            'Annet' => 'prom',
            'Aksjeleilighet' => 'prom',
            'Kontorlokale' => 'prom',
            'Fritidseiendom' => 'prom',
            'Boligtomt' => 'tomteareal',
            'Hyttetomt' => 'tomteareal',
            'Næringstomt' => 'tomteareal',
            'Parkeringsplass' => 'bruksareal',
            'Næringsbygg' => 'bruksareal',
            'Forretning' => 'bruksareal',
            'Landbrukseiendom' => 'bruksareal',
            'Lager' => 'bruksareal',
        ];

        return $types[$this->type_eiendomstyper] ?? 'prom';
    }

    /**
     * Get the property area.
     *
     * @param bool $formatted
     *
     * @return mixed
     */
    public function propertyArea($formatted = true)
    {
        $value = $this->{$this->getPropertyAreaColumn()};

        if (!$formatted) {
            return $value;
        }

        return number_format($value, 0, ' ', ' ');
    }

    /**
     * Get the poster path.
     *
     * @param string $size
     * @param string $background
     * @param string $textColor
     * @param string $text
     *
     * @return string
     */
    public function posterPath($size = '600x400', $background = '000000', $textColor = 'ffffff', $text = 'Ingen bilder')
    {
        list ($width, $height) = explode('x', $size);

        return !empty($this->propertyImage) && ($this->propertyImage->urlstorthumbnail || $this->propertyImage->urloriginalbilde)
            ? CdnComponent::optimizedUrl($this->propertyImage->urlstorthumbnail ?? $this->propertyImage->urloriginalbilde, $width, $height)
            : sprintf('https://via.placeholder.com/%s/%s/%s/?text=%s', $size, $background, $textColor, $text);
    }

    /**
     * Get the poster text.
     *
     * @return string
     */
    public function posterText()
    {
        return !empty($this->propertyImage) && $this->propertyImage->overskrift
            ? $this->propertyImage->overskrift
            : $this->title;
    }

    /**
     * Get the seo title.
     *
     * @return string
     */
    public function getSeoTitle()
    {
        return $this->type_eiendomstyper . ' på '
            . $this->adresse . ' for '
            . money($this->prissamletsum)
            . ' NOK : Partners eiendomsmegler';
    }


    /**
     * Get pdf link for salgsoppgave.
     *
     * @return PropertyLinks|string
     */
    public function getPdfLinkSalgsoppgave()
    {
        if ($this->isOwnedSchalaPartners()) {
            $url = $this->salgsoppgaveDownloadLink->url ?? null;
        } else {
            $url = $this->salgsoppgavePDFDownloadLink->urldokument ?? $this->salgsoppgaveDownloadLink->url ?? null;
        }
        return $url;
    }

    /**
     * Determine if this property owned by schala partners.
     *
     * @return bool
     */
    public function isOwnedSchalaPartners()
    {
        return in_array($this->department->partner_id, [1]);
    }

    /**
     * @return ActiveQuery
     */
    public function getAccounting()
    {
        return $this->hasMany(Accounting::class, ["oppdragsnummer" => "oppdragsnummer"]);
    }

    /**
     * @return ActiveQuery
     */
    public function getSelgers()
    {
        return $this->hasMany(ArchiveForm::class, ["target_id" => "id"])
            ->andWhere(["and",
                ["type" => "selger"],
                ["or",
                    ["not in", "email", ["", null]],
                    ["not in", "phone", ["", null]]
                ]
            ]);
    }

    /**
     * @return ActiveQuery
     */
    public function getKjopers()
    {
        return $this->hasMany(ArchiveForm::class, ["target_id" => "id"])
            ->andWhere(["and",
                ["type" => "kjoper"],
                ["or",
                    ["not in", "email", ["", null]],
                    ["not in", "phone", ["", null]]
                ]
            ]);
    }

    /**
     * Determine flag if this property has 360 view.
     *
     * @return bool
     */
    public function has360View()
    {
        return $this->urlbilder && strpos($this->urlbilder, 'matterport') !== false;
    }


    /**
     * @return ActiveQuery
     */
    public function getPropertiesEvents()
    {
        return $this->hasMany(PropertyEvent::class, ['property_id' => 'id']);
    }
}
