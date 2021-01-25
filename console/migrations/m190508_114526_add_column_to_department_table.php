<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Class m190508_114526_add_column_to_department_table
 */
class m190508_114526_add_column_to_department_table extends Migration
{

    private $tableName = '{{%department}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName,true);
        if(!isset($table->columns['url'])) {
            $this->addColumn($this->tableName,'url',$this->string());
        }

        $departments = (new Query())
            ->select(['id','navn'])
            ->from($this->tableName)
            ->all();

        foreach ($departments as $department){
            $name = str_replace('ø', 'o', $department['navn']);
            $name = str_replace('ü', 'u', $name);
            $name = str_replace(' ', '-', $name);
            $name = str_replace('/', '', $name);
            $name = str_replace('&','',str_replace(' ', '-', $name));
            $name = preg_replace('/_+/', '_',$name);
            $row['url'] = strtolower($name);
            $this->update($this->tableName,$row,['id'=>$department['id']]);
        }



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName,'url');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190508_114526_add_column_to_department_table cannot be reverted.\n";

        return false;
    }
    */
}
