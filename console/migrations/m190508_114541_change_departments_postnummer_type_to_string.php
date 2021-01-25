<?php

use yii\db\Migration;

/**
 * Class m190508_114541_change_departments_postnummer_type_to_string
 */
class m190508_114541_change_departments_postnummer_type_to_string extends Migration
{
    private $tableName = '{{%department}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn($this->tableName, 'postnummer', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn($this->tableName,'postnummer', 'LONGTEXT' );
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
