<?php

use moonland\phpexcel\Excel;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m190425_123209_create_all_post_number_table extends Migration
{

    public $tableName = '{{%all_post_number}}';
    public $fileName = 'frontend/web/requests/Postnummerregister-Excel.xlsx';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'index' => $this->string(),
            'city' => $this->string(),
            'municipal_number' => $this->string(),
            'municipal_name' => $this->string(),
            'category' => $this->string(),
        ]);

        $data = Excel::import($this->fileName);
        foreach ($data as $key) {
            $this->insert($this->tableName, [
                'index' => $key['Postnummer'],
                'city' => $key['Poststed'],
                'municipal_number' => $key['Kommunenummer'],
                'municipal_name' => $key['Kommunenavn'],
                'category' => $key['Kategori'],
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
}
