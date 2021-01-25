<?php

use yii\db\Migration;

/**
 * Class m200430_124355_ADD_COLUMN_oppdragsnummer_prosjekthovedoppdrag_to_properties
 */
class m200430_124355_ADD_COLUMN_oppdragsnummer_prosjekthovedoppdrag_to_properties extends Migration
{
    private $tableName = "property_details";
    private function getColumns(){
        return [
            "oppdragsnummer_prosjekthovedoppdrag" => $this->integer(10),
        ];
    }

    /**
     * {@inheritdoc}
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

        $this->execute('UPDATE property_details SET oppdragsnummer_prosjekthovedoppdrag = `oppdragsnummer-prosjekthovedoppdrag`;');
        if(isset($table->columns['oppdragsnummer-prosjekthovedoppdrag'])) {
            $this->dropColumn($this->tableName, 'oppdragsnummer-prosjekthovedoppdrag');
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