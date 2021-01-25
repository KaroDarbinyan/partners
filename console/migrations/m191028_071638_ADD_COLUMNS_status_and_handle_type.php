<?php

use yii\db\Migration;

/**
 * Class m191028_071638_ADD_COLUMNS_status_and_handle_type
 */
class m191028_071638_ADD_COLUMNS_status_and_handle_type extends Migration
{
    private $tableName = "forms";
    private function getColumns(){
        return [
            "status"=> $this->char(32),
            "handle_type"=> $this->char(32),
        ];
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
        $q1 = Yii::$app->db->createCommand("
          UPDATE forms INNER JOIN lead_log 
            ON forms.id = lead_log.lead_id AND lead_log.id = (
                    SELECT lead_log.id FROM lead_log 
                    WHERE lead_log.lead_id = forms.id AND lead_log.type IN (
                        'Påminnelse',
                        'Vunnet',
                        'Tapt',
                        'Har tatt kontakt',
                        'Får ikke kontakt',
                        'Ønsker ikke kontakt',
                        'Avtalt befaring',
                        'Utført befaring'
                    )
                    ORDER BY lead_log.created_at DESC LIMIT 1
                ) SET forms.handle_type = lead_log.type, forms.status = lead_log.type
        ");

        $q2 = Yii::$app->db->createCommand("
          UPDATE forms INNER JOIN lead_log 
            ON forms.id = lead_log.lead_id AND lead_log.id = (
                    SELECT lead_log.id FROM lead_log 
                    WHERE lead_log.lead_id = forms.id 
                    ORDER BY lead_log.created_at DESC LIMIT 1
                ) SET forms.status = lead_log.type
            WHERE forms.status IS NULL
        ");

        $q1->execute();
        $q2->execute();
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
