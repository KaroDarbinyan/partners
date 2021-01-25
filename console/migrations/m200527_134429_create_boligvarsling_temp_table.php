<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%boligvarsling_temp}}`.
 */
class m200527_134429_create_boligvarsling_temp_table extends Migration
{

    private $tableName = '{{%boligvarsling_temp}}';
    private $directory = 'console/migrations/json';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Drop table if exist
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        $fields = [
            "id" => $this->string(),
            "type" => $this->string(),
            "name" => $this->string(),
            "email" => $this->string(),
            "lat" => $this->string(),
            "lon" => $this->string(),
            "radius" => $this->double(),
            "estatetype" => $this->string(),
            "price_min" => $this->string(),
            "price_max" => $this->string(),
            "area_min" => $this->string(),
            "area_max" => $this->string(),
            "consent" => $this->string(),
            "oppdragsaddresse" => $this->string(),
            "oppdragsnummer" => $this->string(),
            "agent" => $this->string(),
            "office" => $this->string()
        ];

        $this->createTable($this->tableName, ["unique_id" => $this->primaryKey()] + $fields, $tableOptions);


        $files = glob($this->directory . '/*');

        foreach ($files as $file) {
            $data = json_decode(file_get_contents($file), true);

            foreach ($data as $key => $item) {
                foreach (array_keys($fields) as $field) {
                    if (!array_key_exists($field, $item)) {
                        $data[$key][$field] = null;
                    }
                }
                $this->insert($this->tableName, $data[$key]);
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop table if exist
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

    }

}
