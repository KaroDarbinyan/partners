<?php

use yii\db\Migration;

/**
 * Class m200203_084724_REPLACE_chars_in_forms_name
 */
class m200203_084724_REPLACE_chars_in_forms_name extends Migration
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
        $origin =    ['Ø',     'ø',     'Å',     'å',      'ü',      'Ü',      'æ',      'Æ'     ];
        $replaceTo = ['&#216;','&#248;','&#197;','&#229;', '&#252;', '&#220;', '&#230;', '&#198;'];
        foreach ($this->columns as $column) {
            if(!isset($table->columns[$column])) {
                continue;
            }
            $connection = Yii::$app->getDb();
            $connection->createCommand("
              ALTER TABLE {$this->tableName} CHANGE {$column} {$column} VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL;
            ")->execute();
            foreach ($origin as $i=>$k) {
                $connection->createCommand("
                  UPDATE {$this->tableName} SET {$column} = REPLACE({$column}, '{$replaceTo[$i]}', '{$k}')
                ")->execute();
            }
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