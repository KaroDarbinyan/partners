<?php

use yii\db\Migration;

/**
 * Class m190628_135402_add_columns_to_forms_table
 */
class m190628_135402_add_columns_to_forms_table extends Migration
{

    private $tableName = '{{%forms}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!isset($table->columns['property_type']))
            $this->addColumn($this->tableName, 'property_type', $this->text()->notNull()->defaultValue(''));
        if (!isset($table->columns['price_range']))
            $this->addColumn($this->tableName, 'price_range', $this->char(255)->notNull()->defaultValue(''));
        if (!isset($table->columns['area_range']))
            $this->addColumn($this->tableName, 'area_range', $this->char(255)->notNull()->defaultValue(''));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (isset($table->columns['property_type']))
            $this->dropColumn($this->tableName, 'property_type');
        if (isset($table->columns['price_range']))
            $this->dropColumn($this->tableName, 'price_range');
        if (isset($table->columns['area_range']))
            $this->dropColumn($this->tableName, 'area_range');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190628_135402_add_columns_to_forms_table cannot be reverted.\n";

        return false;
    }
    */
}
