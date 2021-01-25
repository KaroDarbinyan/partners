<?php

use yii\db\Migration;

/**
 * Class m190729_105547_REMOVE_useless_columns
 */
class m190729_105547_REMOVE_useless_columns extends Migration
{
    private $tableName = "{{%property_details}}";
    private function getColumns(){
        return [
            'databasenummer',
            'styringskoder',
            'finn_oppdragstype',
            'finn_eierformbygninger',
            'finn_eierformtomt',
            'tinde_eiendomstype',
            'tinde_eierformbygninger',
            'tinde_eierformtomt',
            'klientkonto',
            'urlnettversjon',
            'urlprospektbestilling',
            'urlpersonvernerklaring',
            'autoprospekt_harferdigsalgsoppgave',
            'kundenummer_finn',
            'avdeling_juridisknavn',
            'avdeling_organisasjonsnummer',
            'avdeling_navn',
            'avdeling_fagansvarlig_id',
            'avdeling_fagansvarlig_navn',
            'avdeling_fagansvarlig_inaktiv',
            'avdeling_fagansvarlig_email',
            'avdeling_fagansvarlig_mobiltelefon',
            'avdeling_fagansvarlig_urlstandardbilde',
            'avdeling_fagansvarlig_urlstandardbildelink',
            'avdeling_fagansvarlig_standardbildefil',
            'avdeling_fagansvarlig_urloriginalbilde',
            'avdeling_fagansvarlig_urloriginalbildelink',
            'avdeling_fagansvarlig_originalbildefil',
            'avdeling_avdelingsleder_id',
            'avdeling_avdelingsleder_navn',
            'avdeling_avdelingsleder_tittel',
            'avdeling_avdelingsleder_inaktiv',
            'avdeling_avdelingsleder_email',
            'avdeling_avdelingsleder_mobiltelefon',
            'logo_url_b',
            'logo_url_c',
            'logo_url_d',
            'avdeling_besoksadresse',
            'avdeling_postadresse',
            'avdeling_postnummer',
            'avdeling_poststed',
            'avdeling_telefon',
            'avdeling_telefax',
            'avdeling_email',
            'avdeling_urlhjemmeside',
            'urlhtmlpresentasjon_konsern',
            'ansatte1_navn',
            'ansatte1_tittel',
            'ansatte1_inaktiv',
            'ansatte1_statusioppdrag',
            'ansatte1_email',
            'ansatte1_mobiltelefon',
            'ansatte1_urlstandardbilde',
            'ansatte1_urlstandardbildelink',
            'ansatte1_standardbildefil',
            'ansatte1_urloriginalbilde',
            'ansatte1_urloriginalbildelink',
            'ansatte1_originalbildefil',
            'ansatte2_navn',
            'ansatte2_tittel',
            'ansatte2_inaktiv',
            'ansatte2_statusioppdrag',
            'ansatte2_email',
            'ansatte2_mobiltelefon',
            'ansatte2_urlstandardbilde',
            'ansatte2_urlstandardbildelink',
            'ansatte2_standardbildefil',
            'ansatte2_urloriginalbilde',
            'ansatte2_urloriginalbildelink',
            'ansatte2_originalbildefil',
            'ansatteansvarligmegler_id',
            'ansatteansvarligmegler_navn',
            'ansatteansvarligmegler_tittel',
            'ansatteansvarligmegler_inaktiv',
            'ansatteansvarligmegler_statusioppdrag',
            'ansatteansvarligmegler_email',
            'ansatteansvarligmegler_mobiltelefon',
            'ansatteansvarligmegler_urlstandardbilde',
            'ansatteansvarligmegler_urlstandardbildelink',
            'ansatteansvarligmegler_standardbildefil',
            'ansatteansvarligmegler_urloriginalbilde',
            'ansatteansvarligmegler_urloriginalbildelink',
            'ansatteansvarligmegler_originalbildefil',
            'hovedoppdrag',
            'oppdragsnummer__prosjekthovedoppdrag',
            'avdeling_fagansvarlig_tittel',
            'avdeling_avdelingsleder_urlstandardbilde',
            'avdeling_avdelingsleder_urlstandardbildelink',
            'avdeling_avdelingsleder_standardbildefil',
            'avdeling_avdelingsleder_urloriginalbilde',
            'avdeling_avdelingsleder_urloriginalbildelink',
            'avdeling_avdelingsleder_originalbildefil',
            'avdeling_fagansvarlig_urlhtmlpresentasjon_ansatt',
            'avdeling_avdelingsleder_urlhtmlpresentasjon_ansatt',
            'ansatte1_urlhtmlpresentasjon_ansatt',
            'ansatte2_urlhtmlpresentasjon_ansatt',
            'oppgjordobbeltsignaturdato',
            'oppgjorsansvarlig_navn',
            'oppgjorsansvarlig_tittel',
            'oppgjorsansvarlig_inaktiv',
            'oppgjorsansvarlig_statusioppdrag',
            'oppgjorsansvarlig_email',
            'oppgjorsansvarlig_mobiltelefon',
            'oppgjorsansvarlig_interntelefon',
            'oppgjorsansvarlig_urlhtmlpresentasjon_ansatt',
            'oppgjorsansvarlig_avdelingnavn',
            'oppgjorsansvarlig_id_avdeling',
            'oppgjorsansvarlig_juridisknavn',
            'oppgjorsansvarlig_id_firma',
            'oppgjorsansvarlig_organisasjonsnummer',
            'avdeling_fagansvarlig_interntelefon',
            'avdeling_avdelingsleder_interntelefon',
            'ansatte1_interntelefon',
            'ansatteansvarligmegler_interntelefon',
            'type_funnetgjennom__selger',
            'type_funnetgjennom__kjoper',
            'matrikkelkommentar',
            'festekommentar',
            'urlinteressentregistrering',
            'leieperkvm',
            'leieinntekterperkvm',
            'intern_ansiennitet',
            'antallsenger',
            'visningstekst',
            'rtffritekst',
            'fritekster',
            'visninger',
            'bilder',
            'dokumenter',
            'alledokumenter',
            'allelinker',
            'lenker',
            'prosjektaktiviteter',
            'id_oppdrag_prosjekt',
            'prosjekt',
            'ligningsverdi2',
            'ligningsverdidato',
            'forsikringsselskap',
            'polisenummer',
            'forretningsforer',
            'forretningsforer_adresse',
            'forretningsforer_postnummer',
            'forretningsforer_poststed',
            'forretningsforer_telefon',
            'urlhtmlpresentasjon_avdeling',
            'ansatteansvarligmegler_urlhtmlpresentasjon_ansatt',
            'takstmann',
            'takstdato',
            'ekstratoalett',
            'oppgjortdato',
            'oppgjorsansvarlig_id',
            'latitude',
            'longtitude',
            'type_periode__fellesutgifter',
            'fellesutgifteretteravdragsfriperiode',
            'leie',
            'type_periode__leie',
            'leieinntekter',
            'type_periode__leieinntekter',
            'kommentarleieinntekter',
            'type_periode__kommunaleavgifter',
            'depositum',
            'urlhjemmeside',
            'urlbilder',
            'id_firma',
            'id_avdelinger',
            'type_oppdrag',
            'fornyelsesdato',
            'markedsforingsdato',
            'markedsforingversjon',
            'visisokemotor',
            'httplinkoppdrag',
            'flertype_internett',
            'kommunaleavgifter',
            'type_periode_kommunaleavgifter',
            'kommentarkommunaleavgifter',
            'befaringutfort',
            'prisvurderingutfort',
            'akseptdatob',
            'type_periode_fellesutgifter',
            'andelfellesformue',
            'festenummer',
            'festeavgift',
            'festeaar',
            'budmottat',
            'gebyrforkjopsrett',
            'noteringsgebyr',
            'markedsforingstildato',
            'premie',
            'medlemsskap',
            'promkommentar',
            'grunnflate',
            'forsikringsselskapb',
            'totalformue',
            'leilighetsnummer',
            'transportgebyr',
            'oppgang',
            'andelrestbelop',
            'kontraktsmoteinklklokkeslett',
            'kontraktsmote',
            'kortbeskrivelse',
            'utland',
            'tekniskverdi',
            'verditakst',
            'laanetakst',
            'skattetakst',
            'kommentartakst',
            'promtil',
            'boligareal',
            'boligarealtil',
            'bruttoarealtil',
            'partialrestbelop',
            'andelopprinneligbelop',
            'kommentargjeld',
            'totalomkostningsomprosent',
            'totalomkostninger',
            'matchekriterier',
            'prisantydningtil',
            'bruksarealtil',
            'soveromtil',
            'seksjonsnummer',
            'bruksenhetsnummer',
            'andelsbrevnummer',
            'eierskiftegebyr',
            'totalgjeld',
            'andelfellesgjeldpr',
            'forkjopsrett',
            'ideellandel',
            'seksjonsbrok',
            'tilgjengeligfra',
            'overtagelse',
        ];
    }

    private function getSpecialColumns(){
        return [
            'finn_importstatisticsurl' => $this->text(),
            'type_eierformtomt' => $this->char(255),
            'type_eierformbygninger' => $this->char(255),
            'finn_eiendomstype' => $this->text(),
            'tinde_oppdragstype' => $this->char(255),
            'ligningsverdi' => $this->integer(),
            'andelfellesgjeld'=>$this->integer(),
            'fellesutgifter'=>$this->integer(),
            'kommentarleie'=>$this->text(),
            'urlelektroniskbudgivning'=>$this->text(),
            'modernisert'=>$this->smallInteger(),
            'finn_orderno'=>$this->bigInteger(),
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        foreach ($this->getSpecialColumns() as $name=>$type) {
            if(isset($table->columns[$name])) {
                $this->alterColumn($this->tableName,$name, $type);
            }else{
                $this->addColumn($this->tableName,$name, $type);
            }
            echo "\n {$name} fixed \n";
        }
        foreach ($this->getColumns() as $i => $name) {

            if(!isset($table->columns[$name])) {
                continue;
            }
            $this->dropColumn($this->tableName, $name);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo 'this migration reverted partial';
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        foreach ($this->getColumns() as $name=>$type) {
            if(!isset($table->columns[$name])) {
                echo "Column {$this->tableName}.{$name} dose not exists \n";
                continue;
            }
            $this->addColumn($this->tableName, $name, 'LONGTEXT');
        }
    }

}
