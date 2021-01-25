<?php

use yii\db\Migration;

/**
 * Class m190402_144600_add_columns_to_property_details
 */
class m190402_144600_add_columns_to_property_details extends Migration
{
    private $tableName = '{{%property_details}}';
    private $fileName = 'frontend/web/requests/properties_eiendommer.json';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $q = new \yii\db\Query();
        $properties = $q->select(['*'])
            ->from('{{%webmegler_properties}}')
            ->limit(1)
            ->all();

        $exceptions = [
            'id',
            'id__',
            'avdeling_besoksadresse',
            'prissamletsum',
            'type_eiendomstyper',
            'bruttoareal',
            'fritekster',
        ];

        $table = $this->db->getTableSchema($this->tableName);
        foreach ($properties[0] as $columnName => $v) {
            if ( in_array($columnName, $exceptions) || isset($table->columns[$columnName]) ){
                continue;
            }

            $this->addColumn($this->tableName, $columnName, $this->text());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $q = new \yii\db\Query();
        $properties = $q->select(['*'])
            ->from('{{%webmegler_properties}}')
            ->limit(1)
            ->all();

        $exceptions = [
            'id',
            'id__',
            'avdeling_besoksadresse',
            'prissamletsum',
            'type_eiendomstyper',
            'bruttoareal',
            'fritekster',
        ];

        foreach ($properties[0] as $columnName => $v) {
            if (in_array($columnName, $exceptions)){continue;}


            $this->dropColumn($this->tableName, $columnName);
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190402_144600_add_columns_to_property_details cannot be reverted.\n";

        return false;
    }
    */
}
