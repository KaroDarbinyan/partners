<?php

use yii\db\Migration;

/**
 * Class m191009_092641_drop_column_status
 */
class m191009_092641_drop_column_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->dropColumn(\common\models\LeadLogMockup::tableName(), 'status');
    }

    public function down()
    {
        echo "m191009_092641_drop_column_status cannot be reverted.\n";

        return false;
    }
}
