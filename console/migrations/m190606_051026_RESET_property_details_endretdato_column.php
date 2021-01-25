<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Class m190606_051026_RESET_property_details_endretdato_column
 */
class m190606_051026_RESET_property_details_endretdato_column extends Migration
{
    private $tableName = "{{%property_details}}";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (!$this->db->getTableSchema($this->tableName, true)) {
            echo "m190606_051026_RESET_property_details_endretdato_column cant be migrated \n";
            return true;
        }
        $data = (new Query())
            ->select([
                'id',
                'endretdato',
            ])
            ->from('property_details')
            ->all()
        ;
        foreach ($data as $i => $row) {
            $data[$i]['endretdato'] = strtotime($data[$i]['endretdato']);
            $this->update(
                $this->tableName,
                ['endretdato' => $data[$i]['endretdato']],
                ['id' => $data[$i]['id']]
            );
        }
        $this->alterColumn($this->tableName,'endretdato', $this->integer(11) );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if(isset($table) && isset($table->columns['endretdato'])) {
            $this->alterColumn($this->tableName,'endretdato', 'LONGTEXT');
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190606_051026_RESET_property_details_endretdato_column cannot be reverted.\n";

        return false;
    }
    */
}
