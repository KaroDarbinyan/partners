<?php

use common\models\Department;
use yii\db\Expression;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%department}}`.
 */
class m200701_131736_add_user_id_column_to_department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%department}}', 'user_id', $this->integer()->null());

        Department::updateAll([
            'user_id' => new Expression('avdelingsleder')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%department}}', 'user_id');
    }
}
