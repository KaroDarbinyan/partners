<?php

use yii\db\Migration;

/**
 * Class m200415_085820_UPDATE_forms_andLead_log_tables
 */
class m200415_085820_UPDATE_forms_andLead_log_tables extends Migration
{
    private $tableName = 'forms';
    /**
     * {@inheritdoc}
     * @throws \Matrix\Exception
     * @throws \yii\base\Exception
     */
    public function safeUp(){
        $table = $this->db->getTableSchema($this->tableName, true);
        if (!$table) {
            echo "Table {$this->tableName} dose not exist \n";
            return;
        }
        $this->execute("
            UPDATE forms 
            LEFT JOIN lead_log ON lead_log.id =(
            SELECT id 
                FROM lead_log 
                WHERE lead_log.lead_id = forms.id AND lead_log.type NOT IN (1006, 'sett',  1007, 'Åpnet sms') 
                ORDER BY lead_log.created_at 
                DESC LIMIT 1
            )
            LEFT JOIN status_code_map ON lead_log.type = status_code_map.id OR lead_log.type = status_code_map.status
            SET forms.status = status_code_map.id
            WHERE forms.status <> status_code_map.id 
        ");

        $this->execute("
            UPDATE lead_log LEFT JOIN status_code_map ON lead_log.type = status_code_map.status OR lead_log.type = status_code_map.id
            SET lead_log.type = status_code_map.id
        ");

        $this->execute("
            UPDATE forms 
            LEFT JOIN lead_log ON lead_log.id =(
            SELECT id 
                FROM lead_log 
                WHERE lead_log.lead_id = forms.id AND lead_log.type NOT IN (1006, 'sett',  1007, 'Åpnet sms') 
                ORDER BY lead_log.created_at 
                DESC LIMIT 1
            )
            LEFT JOIN status_code_map ON lead_log.type = status_code_map.id OR lead_log.type = status_code_map.status
            SET forms.handle_type = status_code_map.id
            WHERE forms.handle_type <> status_code_map.id AND status_code_map.id NOT IN ( 1001, 1002, 1003, 1004, 1005 )
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200415_085820_UPDATE_forms_andLead_log_tables cannot be reverted.\n";
    }

}

