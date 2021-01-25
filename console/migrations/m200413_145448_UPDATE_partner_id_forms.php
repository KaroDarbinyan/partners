<?php

use yii\db\Migration;

/**
 * Class m200413_145448_UPDATE_partner_id_forms
 */
class m200413_145448_UPDATE_partner_id_forms extends Migration
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
            LEFT JOIN property_details ON forms.target_id = property_details.id
            LEFT JOIN department ON department.web_id = property_details.avdeling_id
            SET forms.partner_id = department.partner_id
            WHERE forms.department_id IS NULL AND forms.broker_id IS NULL  AND forms.target_id IS NOT NULL
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200413_145448_UPDATE_partner_id_forms cannot be reverted.\n";
    }

}

