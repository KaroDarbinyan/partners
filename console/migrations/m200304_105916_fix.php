<?php

use yii\db\Migration;

/**
 * Class m200304_105916_fix
 */
class m200304_105916_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(){
        $table = $this->db->getTableSchema('client', true);
        if (!$table) {
            echo "Table client does not exist \n";
        }else{
            if(isset($table->columns['bloked'])) {
                $this->renameColumn('client','bloked', 'blocked');
                $this->alterColumn('client','blocked', $this->boolean());
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema('client', true);
        if (!$table) {
            echo "Table client does not exist \n";
        }else{
            if(isset($table->columns['blocked'])) {
                $this->renameColumn('client','blocked', 'bloked');
                $this->alterColumn('client','bloked', $this->tinyInteger(1));
            }
        }
    }//


}
