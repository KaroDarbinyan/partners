<?php

use yii\db\Migration;

/**
 * Class m190501_145426_ADD_FOREIGN_KEY_form_to_user
 */
class m190501_145426_ADD_FOREIGN_KEY_form_to_user extends Migration
{
    private $tableName = '{{%forms}}';
    private $parentTable= '{{%user}}';
    private $leadLogTable= '{{%lead_log}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("SET foreign_key_checks = 0;");
        $this->truncateTable($this->leadLogTable);
        $this->truncateTable($this->tableName);
        try{
            $this->dropIndex('webmegler_id', $this->parentTable);
        }catch(Exception $e){
            echo "no webmegler_id on {$this->parentTable} \n";
        };

        try{
            $this->dropIndex('webmegler_id', $this->tableName);
        }catch(Exception $e){
            echo "no webmegler_id on {$this->tableName} \n";
        };

        try{
            $this->dropForeignKey("form_to_user", $this->tableName);
        }catch(Exception $e){
            echo "no form_to_user on {$this->tableName} \n";
        };

        try{
            $this->dropForeignKey("form_to_user", $this->parentTable);
        }catch(Exception $e){
            echo "no form_to_user on {$this->parentTable} \n";
        };

        $this->execute("SET foreign_key_checks = 1;");
        $this->createIndex('webmegler_id', $this->parentTable, 'web_id', $unique = true );
        $this->addForeignKey("form_to_user", $this->tableName, "delegated", $this->parentTable, "web_id" );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try{
            $this->dropForeignKey("form_to_user", $this->tableName);
        }catch(Exception $e){};
        try{
            $this->dropIndex('webmegler_id', $this->parentTable);
        }catch(Exception $e){};
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190501_145426_ADD_FOREIGN_KEY_form_to_user cannot be reverted.\n";

        return false;
    }
    */
}
