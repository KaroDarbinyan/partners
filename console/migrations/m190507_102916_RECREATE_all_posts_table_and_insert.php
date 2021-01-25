<?php

use yii\db\Migration;

/**
 * Class m190507_102916_RECREATE_all_posts_table_and_insert
 */
class m190507_102916_RECREATE_all_posts_table_and_insert extends Migration
{

    public $tableName = '{{%all_post_number}}';
    public $fileName = 'frontend/web/requests/all_post_numbers_for_norwey.csv';

    /**
     * {@inheritdoc}
     */
    public function safeUp(){
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        //TODO: change all postnumbers types to varchar(4)

        $this->createTable($this->tableName, [
            'id'               => $this->primaryKey(),
            'index'            => $this->string(),
            'lat'              => $this->double(15),
            'lon'              => $this->double(15),
            'city'             => $this->string(),
            'municipal_name'   => $this->string(),
            'municipal_g_name' => $this->string(),
        ], $tableOptions);

        $data = $this->csvToArray(file_get_contents($this->fileName));
        foreach ($data as $row) {
            $this->insert($this->tableName, [
                'index'            => $row['PostalCode'],
                'lat'              => $row['Latitude'],
                'lon'              => $row['Longitude'],
                'city'             => $row['Locality'],
                'municipal_name'   => $row['Region2Name'],
                'municipal_g_name' => $row['Region1Name'],
            ]);
        }
    }



    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
    }


    private function csvToArray($csv){
        $rowLimiter = "\n";
        $colLimiter = ";";

        $rows = explode($rowLimiter, $csv);
        $keys = explode( $colLimiter,$rows[0]);
        unset($rows[0]);

        $return = [];

        foreach ($rows as $i => $row) {
            if (!strlen($row)){ continue; }// Pass iteration on empty row
            $return[] = array_combine( $keys , explode($colLimiter,$row) );
        }

        return $return;
    }
}

/*
 {
"3CountryA2": "NO",
"Language": "NO",
"PostalCode": 7950,
"Region0Code": "01",
"Region0Name": "Midt-Norge",
"Region1Code": 17,
"Region1Name": "Nord-Trøndelag", 	FYLKE
"Region2Code": 16,
"Region2Name": "Nærøy", 			КОММУНА
"Region3Code": "",
"Region3Name": "",
"Region4Code": "",
"Region4Name": "",
"LocalityCode": 448387,
"LocalityType": "",
"Locality": "Abelvær", 				ГОРОД
"SubLocalityCode": "",
"SubLocalityType": "",
"SubLocality": "",
"AreaCode": "",
"AreaType": "",
"AreaName": "",
"Latitude": 64.733299,
"Longitude": 11.183299,
"Altitude": "",
"TimeZone": "Europe/Oslo",
"UTC": "+01:00",
"DST": "+02:00"
},
 */
