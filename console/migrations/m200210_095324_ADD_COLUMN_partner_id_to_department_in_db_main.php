<?php

use yii\db\Migration;

/**
 * Class m200210_095324_ADD_COLUMN_partner_id_to_department_in_db_main
 */
class m200210_095324_ADD_COLUMN_partner_id_to_department_in_db_main extends Migration
{
    private $tableName = "{{%department}}";
    private function getColumns(){
        return [
            "partner_id"=> $this->integer(11),
        ];
    }

    public function init()
    {
        $this->db->setActiveConnection('main');
        parent::init();
    }

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
        foreach ($this->getColumns() as $name=>$type) {
            if(isset($table->columns[$name])) {
                $this->dropColumn($this->tableName, $name);
            }
            $this->addColumn($this->tableName, $name, $type);
        }

        $deps = file_get_contents('custom_gets/department-all-deps.json');
        $deps = json_decode($deps,true);
        $demoDep = new \common\models\Department();
        $rows = [];
        $this->truncateTable($this->tableName);
        foreach ($deps['avdeling'] as $i => $row) {
            $r = [];
            foreach ($demoDep->attributes() as $i => $name) {
                if (!isset($row[$name])){continue;}
                $r[$name] = isset($row[$name]) ? $row[$name] : null;
            }
            $r['web_id'] = $r['id'];
            unset($r['id']);
            $this->insert($this->tableName,$r);
        }

        $partnerDepartmentMap = [
            '1' => [3000005,3000008,3000006,3000011,3000010,3000007],
            '2' => [3000081,],
            '3' => [21,],
            '4' => [3000028,],
            '5' => [3000090,],
            '6' => [3000051,],
            '7' => [3000014,],
            '8' => [3000047,],
            '9' => [11,],
            '10' => [3000045,],
            '11' => [3000034,],
            '12' => [6,3000060,3000061,3000062],
            '13' => [3000072,],
        ];

        foreach ($partnerDepartmentMap as $partnerId=>$depIds) {
            $this->update(
                $this->tableName,
                ['partner_id'=>$partnerId],
                ['web_id'=>$depIds]
            );
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        foreach ($this->getColumns() as $name=>$type) {
            if(isset($table->columns[$name])) {
                $this->dropColumn($this->tableName, $name);
            }
        }
    }
}
