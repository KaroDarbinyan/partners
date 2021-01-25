<?php

use common\models\PropertyDetails;
use yii\db\Migration;
use yii\httpclient\Client;

/**
 * Handles adding columns to table `{{%property_details}}`.
 */
class m191017_162501_add_columns_to_property_details_table extends Migration
{
    private $tableName = '{{%property_details}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if (!isset($table->columns['lat']))
            $this->addColumn($this->tableName, 'lat', $this->string());
        if (!isset($table->columns['lng']))
            $this->addColumn($this->tableName, 'lng', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if (isset($table->columns['lat']))
            $this->dropColumn($this->tableName, 'lat');
        if (isset($table->columns['lng']))
            $this->dropColumn($this->tableName, 'lng');

        return true;
    }
}
