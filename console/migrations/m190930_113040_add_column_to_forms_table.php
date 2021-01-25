<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%forms}}`.
 */
class m190930_113040_add_column_to_forms_table extends Migration
{

    private $tableName = '{{%forms}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if (!isset($table->columns['referer_source']))
            $this->addColumn($this->tableName, 'referer_source', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if (isset($table->columns['referer_source']))
            $this->dropColumn($this->tableName, 'referer_source');

        return true;
    }
}
