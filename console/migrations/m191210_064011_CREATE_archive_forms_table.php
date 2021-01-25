<?php

use common\models\Forms;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%archive_forms}}`.
 */
class m191210_064011_CREATE_archive_forms_table extends Migration
{
    private $tableName = '{{%archive_form}}';
    private $sourceTable = '{{%forms}}';

    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Drop table if exist
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        $fields = [
            'id'           => $this->primaryKey(),
            'name'         => $this->char(255),
            'type'         => $this->char(16),
            'target_id'    => $this->integer(10),
            'broker_id'    => $this->integer(10),
            'department_id'=> $this->integer(10),
            'source_id'    => $this->integer(10),
            'address'      => $this->char(255),
            'post_number'  => $this->char(4),
            'phone'        => $this->char(30),
            'email'        => $this->char(255),
            'dob'          => $this->char(20),
            'created_at'   => $this->integer(11),
            'updated_at'   => $this->integer(11),
        ];

        $this->createTable($this->tableName, $fields, $tableOptions);
        unset($fields['id']);
        $fields = implode(',',array_keys($fields));
        $insert = Yii::$app->db->createCommand("
          INSERT {$this->tableName} ({$fields})
          SELECT {$fields}
          FROM {$this->sourceTable}
          WHERE type IN ('selger', 'kjoper');
        ");
        $insert->execute();

        $delete = Yii::$app->db->createCommand("
          DELETE FROM {$this->sourceTable}
          WHERE type IN ('selger', 'kjoper');
        ");
        echo $delete->getRawSql();
        $delete->execute();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop table if exist
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

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
