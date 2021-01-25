<?php

use yii\db\Migration;

/**
 * Class m190430_091530_CREATE_lead_log
 */
class m190430_091530_CREATE_lead_log extends Migration
{
    private $tableName = '{{%lead_log}}';
    private $parentTable= '{{%forms}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createLeadLogTable($tableOptions);
    }

    /**
     * Create LeadLog Table
     * @param $tableOptions
     */
    private function createLeadLogTable($tableOptions){
        // Drop table if exist
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
        try{
            $this->dropForeignKey("log_form", $this->tableName);
        }catch(Exception $e){};

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'lead_id' => $this->integer()->notNull(),
            'type' => $this->string()->notNull(),
            'message' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);



        $this->addForeignKey("log_form",  $this->tableName, "lead_id", $this->parentTable, "id" );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop table if exist
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropForeignKey("log_form", $this->tableName);
            $this->dropTable($this->tableName);
        }

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190429_094021_CREATE_departments_table cannot be reverted.\n";

        return false;
    }
    */
}
