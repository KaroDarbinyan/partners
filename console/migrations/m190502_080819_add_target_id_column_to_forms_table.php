<?php

use yii\db\Migration;

/**
 * Handles adding target_id to table `{{%forms}}`.
 */
class m190502_080819_add_target_id_column_to_forms_table extends Migration
{
    private $tableName = '{{%forms}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->execute("SET foreign_key_checks = 0;");
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        $this->createTable( $this->tableName, [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string()->notNull(),
            'surname' => $this->string(),

            //New columns
            'delegated' => $this->integer(),

            'post_number'     => $this->integer()->notNull(),
            'phone'           => $this->integer()->notNull(),
            'email'           => $this->string(),
            'message'         => $this->text(),
            'subscribe_email' => $this->boolean()->notNull()->defaultValue(false),
            'advice_to_email' => $this->boolean()->notNull()->defaultValue(false),
            'contact_me'      => $this->boolean()->notNull()->defaultValue(false),
            'type'            => $this->string()->notNull(),
            'target_id'       => $this->integer()->defaultValue(null),
            'created_at'      => $this->integer()->notNull(),
            'updated_at'      => $this->integer()->notNull(),
        ],$tableOptions);
        $this->execute("SET foreign_key_checks = 1;");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("SET foreign_key_checks = 0;");
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropColumn( $this->tableName, 'delegated');
        }
        $this->execute("SET foreign_key_checks = 1;");
    }
}
