<?php

use yii\db\Migration;

/**
 * Class m191014_142916_alter_table_ledige_stillinger
 */
class m191014_142916_alter_table_ledige_stillinger extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->dropColumn(\common\models\LedigeStillinger::tableName(), 'kontor');
        $this->addColumn(\common\models\LedigeStillinger::tableName(), 'kontor', $this->integer()->notNull());
    }

    public function down()
    {
        echo "m191014_142916_alter_table_ledige_stillinger cannot be reverted.\n";

        return false;
    }

}
