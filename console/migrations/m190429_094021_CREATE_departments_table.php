<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Class m190429_094021_CREATE_departments_table
 */
class m190429_094021_CREATE_departments_table extends Migration
{
    private $tableName = '{{%department}}';
    private $sourceTableName = '{{%departments_avdeling}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Drop table if exist
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        $meglerDepartments = (new Query())
            ->select('*')
            ->from($this->sourceTableName)
            ->all()
        ;
        $fields = [];
        foreach ($meglerDepartments[0]  as $key => $v) {
            $fields[$key] = 'LONGTEXT';
        }
        $fields['id']               = $this->primaryKey();
        $fields['web_id']           = $this->integer();
        $fields['id_firma']         = $this->integer();
        $fields['dagligleder']      = $this->integer();
        $fields['avdelingsleder']   = $this->integer();
        $fields['fagansvarlig']     = $this->integer();
        $fields['postnummer']       = $this->string();
        unset($fields['id__']);

        $this->createTable($this->tableName, $fields, $tableOptions);

        foreach ($meglerDepartments as $i => $dep) {
            $insertDep = $dep;
            $insertDep['id'] = $dep['id__'];
            $insertDep['web_id'] = $dep['id'];

            $insertDep['dagligleder'] =    json_decode($dep['dagligleder']);
            $insertDep['avdelingsleder'] = json_decode($dep['avdelingsleder']);
            $insertDep['fagansvarlig'] =   json_decode($dep['fagansvarlig']);

            //Change json array to id
            $insertDep['dagligleder'] =    count($insertDep['dagligleder'])     && isset($insertDep['dagligleder'][0]->dagligleder_id )       ? $insertDep['dagligleder'][0]->dagligleder_id       : 3000216 ;
            $insertDep['avdelingsleder'] = count($insertDep['avdelingsleder'])  && isset($insertDep['avdelingsleder'][0]->avdelingsleder_id ) ? $insertDep['avdelingsleder'][0]->avdelingsleder_id : 3000216 ;
            $insertDep['fagansvarlig'] =   count($insertDep['fagansvarlig'])    && isset($insertDep['fagansvarlig'][0]->fagansvarlig_id )     ? $insertDep['fagansvarlig'][0]->fagansvarlig_id     : 3000216 ;
            unset($insertDep['id__']);

            $this->insert ( $this->tableName, $insertDep );
        }
        
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
