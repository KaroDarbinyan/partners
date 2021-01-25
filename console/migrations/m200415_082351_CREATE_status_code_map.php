<?php

use yii\db\Migration;

/**
 * Class m200415_082351_CREATE_status_code_map
 */
class m200415_082351_CREATE_status_code_map extends Migration
{
    private $tableName = '{{%status_code_map}}';
    private $data = [
        '1001' => 'registrert',
        '1002' => 'delegert',
        '1003' => 'fjernet',
        '1004' => 'ufordelt',
        '1005' => 'ufordelt_prosess',
        '1006' => 'sett',
        '1007' => 'Åpnet sms',
        '1008' => 'Avtalt befaring',
        '1009' => 'Får ikke kontakt',
        '1010' => 'Har ringt',
        '1011' => 'Har tatt kontakt',
        '1012' => 'Notat',
        '1013' => 'Ønsker ikke kontakt',
        '1014' => 'Påminnelse',
        '1015' => 'Sendt tilbud',
        '1016' => 'Sendte sms',
        '1017' => 'Tapt',
        '1018' => 'Utført befaring',
        '1019' => 'Venter svar',
        '1020' => 'Vunnet'
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp(){
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
        $fields = array(
            'id' => $this->primaryKey(),
            'status' => $this->string(),
        );
        $this->createTable($this->tableName, $fields, $tableOptions);

        foreach ($this->data as $id=>$status) {
            $this->insert($this->tableName, ['id'=>$id, 'status'=>$status]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
    }


}

