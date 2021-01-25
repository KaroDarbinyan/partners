<?php

use yii\db\Migration;

/**
 * Class m200427_133540_add_data_tatus_code_map_table
 */
class m200427_133540_add_data_tatus_code_map_table extends Migration
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
        '1020' => 'Vunnet',
        '1021' => 'Sendte epost'
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert($this->tableName, ['id' => 1021, 'status' => 'Sendte epost']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete($this->tableName, ['id' => 1021, 'status' => 'Sendte epost']);
    }

}
