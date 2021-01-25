<?php

use yii\db\Migration;

/**
 * Class m190502_130535_connect_post_numbers_to_departments
 */
class m190502_130535_connect_post_numbers_to_departments extends Migration
{


    private $tableName = '{{%post_number}}';
    private $deletedTableName = '{{%offices}}';
    private $fileName = 'frontend/web/requests/office.json';
    private $data = [];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        if ($this->db->getTableSchema($this->deletedTableName, true) !== null) {
            $this->dropTable($this->deletedTableName);
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'index' => $this->string()->notNull(),
            'department_id' => $this->integer()->notNull(),
        ], $tableOptions);


        $this->data = json_decode(
            file_get_contents($this->fileName),
            true)["office"];
        
        foreach ($this->data as $dataRow) {
            $department_id = $dataRow['address'];
            $post_nummers = explode(",", $dataRow["post_nummer"]);
            foreach ($post_nummers as $post_nummer) {
                $this->insert($this->tableName, [
                    "index" => $post_nummer,
                    "department_id" => $department_id,
                ]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->execute("SET foreign_key_checks = 0;");
            $this->dropTable($this->tableName);
            $this->execute("SET foreign_key_checks = 1;");
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190502_130535_connect_post_numbers_to_departments cannot be reverted.\n";

        return false;
    }
    */
}
