<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%property_images}}`.
 */
class m190408_135112_create_property_images_table extends Migration
{

    private $tableName = '{{%property_images}}';
    private $refTableName = '{{%property}}';
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

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'property_id' => $this->integer()->notNull(),
            'src' => $this->string()->notNull(),
            'alt' => $this->string()->defaultValue(null),
            'angle_name' => $this->string()->defaultValue(null),
            'type' => $this->string()->defaultValue(null),
        ], $tableOptions);

        $this->addForeignKey('image_prop', $this->tableName, 'property_id', $this->refTableName, 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropForeignKey('image_prop', $this->tableName);
            $this->dropTable($this->tableName);
        }
    }
}
