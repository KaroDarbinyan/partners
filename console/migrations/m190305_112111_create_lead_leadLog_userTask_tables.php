<?php

use yii\db\Migration;

/**
 * Class m190305_112111_create_lead_leadLog_userTask_tables
 */
class m190305_112111_create_lead_leadLog_userTask_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createLeadTable($tableOptions);
        $this->createLeadLogTable($tableOptions);
        $this->createUserTaskTable($tableOptions);
    }

    /**
     * Create Lead Table
     * @param $tableOptions
     */
    private function createLeadTable($tableOptions){
        $tableName = '{{%lead}}';
        $this->createTable($tableName, [
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull()->unique(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey("lead_to_user", $tableName, "userId", "{{%user}}", "id");
    }

    /**
     * Create LeadLog Table
     * @param $tableOptions
     */
    private function createLeadLogTable($tableOptions){
        $tableName = '{{%leadLog}}';
        $this->createTable($tableName, [
            'id' => $this->primaryKey(),
            'leadId' => $this->integer()->notNull()->unique(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey("log_to_lead", $tableName, "leadId", "{{%lead}}", "id");
    }

    /**
     * Create LeadLog Table
     * @param $tableOptions
     */
    private function createUserTaskTable($tableOptions){
        $tableName = '{{%userTask}}';
        $this->createTable($tableName, [
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull()->unique(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey("task_to_user", $tableName, "userId", "{{%user}}", "id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        $this->dropTable('{{%lead}}');
        $this->dropTable('{{%leadLog}}');
        $this->dropTable('{{%userTask}}');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190305_112111_create_lead_leadLog_userTask_tables cannot be reverted.\n";

        return false;
    }
    */
}
