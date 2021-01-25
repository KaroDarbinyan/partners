<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%property_details}}`.
 */
class m190807_100821_add_columns_to_property_details_table extends Migration
{

    private $tableName = '{{%property_details}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if (!isset($table->columns['finn_adid']))
            $this->addColumn($this->tableName, 'finn_adid', $this->text());

        if (!isset($table->columns['finn_viewings']))
            $this->addColumn($this->tableName, 'finn_viewings', $this->text());

        if (!isset($table->columns['finn_emails']))
            $this->addColumn($this->tableName, 'finn_emails', $this->text());

        if (!isset($table->columns['finn_general_emails']))
            $this->addColumn($this->tableName, 'finn_general_emails', $this->text());

        if (!isset($table->columns['eiendom_viewings']))
            $this->addColumn($this->tableName, 'eiendom_viewings', $this->integer()->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if (isset($table->columns['finn_adid']))
            $this->dropColumn($this->tableName, 'finn_adid');

        if (isset($table->columns['finn_viewings']))
            $this->dropColumn($this->tableName, 'finn_viewings');

        if (isset($table->columns['finn_emails']))
            $this->dropColumn($this->tableName, 'finn_emails');

        if (isset($table->columns['finn_general_emails']))
            $this->dropColumn($this->tableName, 'finn_general_emails');

        if (isset($table->columns['eiendom_viewings']))
            $this->dropColumn($this->tableName, 'eiendom_viewings');

        return true;
    }
}
