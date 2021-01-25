<?php

use yii\db\Migration;

/**
 * Class m191008_113229_add_column_leadLogMoskup
 */
class m191008_113229_add_column_leadLogMoskup extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\LeadLogMockup::tableName(), 'status', $this->integer()->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191008_113229_add_column_leadLogMoskup cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191008_113229_add_column_leadLogMoskup cannot be reverted.\n";

        return false;
    }
    */
}
