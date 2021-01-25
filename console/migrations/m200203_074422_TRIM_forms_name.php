<?php

use yii\db\Migration;

/**
 * Class m200203_074422_TRIM_forms_name
 */
class m200203_074422_TRIM_forms_name extends Migration
{
    private $tableName = "forms";
    private $columns = ['name'];

    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        foreach ($this->columns as $column) {
            if(!isset($table->columns[$column])) {
                continue;
            }
            $connection = Yii::$app->getDb();
            $connection->createCommand("UPDATE {$this->tableName} set {$column} = TRIM({$column});")->execute();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Revrting m200203_074422_TRIM_forms_name is useless \n";
    }


}