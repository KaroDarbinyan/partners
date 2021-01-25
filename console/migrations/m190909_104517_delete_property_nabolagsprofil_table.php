<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m190909_104517_delete_property_nabolagsprofil_table
 */
class m190909_104517_delete_property_nabolagsprofil_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->getTableSchema('{{%property_nabolagsprofil}}', true)) {
            $this->dropTable('{{%property_nabolagsprofil}}');
        }

        $table = $this->db->getTableSchema('{{%property_neighbourhood}}', true);

        if (!isset($table->columns['percent_text_data'])) {
            $this->addColumn('{{%property_neighbourhood}}', 'percent_text_data', $this->text());
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (isset($table->columns['percent_text_data'])) {
            $this->dropColumn('{{%property_neighbourhood}}', 'percent_text_data');
        }
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190909_104517_delete_property_nabolagsprofil_table cannot be reverted.\n";

        return false;
    }
    */
}
