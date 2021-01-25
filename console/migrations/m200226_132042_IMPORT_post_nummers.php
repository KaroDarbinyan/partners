<?php

use yii\db\Migration;

/**
 * Class m200226_132042_IMPORT_post_nummers
 */
class m200226_132042_IMPORT_post_nummers extends Migration
{
    private $tableName = 'post_number';

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
        if(isset($table->columns['in_queue'])) {
            $this->dropColumn($this->tableName, 'in_queue');
        }
        $this->addColumn($this->tableName, 'in_queue', $this->boolean()->defaultValue(true));

        try{
            $this->createIndex('post_nummer_department_pair',
                $this->tableName,
                ['index', 'department_id'],
                true
            );
        }catch (Exception $e){
            echo $e->getMessage() . "\n";
        }
        $csv = __DIR__ . DIRECTORY_SEPARATOR .'sqls'. DIRECTORY_SEPARATOR .'partners-postnummers.csv';
        $csv = fopen($csv, 'r');
        $keys = fgetcsv($csv);
        while (($row = fgetcsv($csv)) !== FALSE) {
            if (!$row[0] || !$row[4]){continue;}
            try{
                $this->insert($this->tableName,[
                    'index' => $row[0],
                    'department_id' => $row[4],
                ]);
            }catch (Exception $e){
                echo $e->getMessage() . "\n";
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200226_132042_IMPORT_post_nummers cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200226_132042_IMPORT_post_nummers cannot be reverted.\n";

        return false;
    }
    */
}
