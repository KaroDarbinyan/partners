<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Class m190610_125443_update_all_department_url
 */
class m190617_165944_update_all_department_url extends Migration
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
            $name = str_replace('  ', ' ', $department['navn']);
            $name = str_replace(['Tunsli ','Schala ','& Partners ','avd '], '', $name);
            $name = str_replace('ø', 'o', $name);
            $name = str_replace('ü', 'u', $name);
            $name = str_replace(['/',' '], '_', $name);
//            $name = '/'.$name;
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
        echo "m190610_125443_update_all_department_url cannot be reverted.\n";

        return false;
    }
    */
}
