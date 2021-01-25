<?php

use yii\db\Migration;

/**
 * Class m190620_085616_CREATE_links_table
 */
class m190620_085616_CREATE_links_table extends Migration
{
    private $tableName = "{{%property_links}}";
    private $parentTableName = "{{%property}}";
    private $data;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = "";
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
        $this->createTable( $this->tableName, [
            'id'       => $this->primaryKey()->notNull(),
            'nr'       => $this->integer(),
            'link_id'  => $this->integer(),
            'navn'     => $this->char(100),
            'url'      => $this->char(255),
            'ikkevisiportal'  => $this->integer(3),
            'nettpublisert'   => $this->integer(3),
            'property_web_id' => $this->integer(),
        ],$tableOptions);

        $this->addForeignKey(
            "property_to_links",
            $this->tableName,
            "property_web_id",
            $this->parentTableName,
            "web_id"
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->execute("SET foreign_key_checks = 0;");
            $this->dropTable($this->tableName);
            $this->execute("SET foreign_key_checks = 1;");
        }

    }

}
