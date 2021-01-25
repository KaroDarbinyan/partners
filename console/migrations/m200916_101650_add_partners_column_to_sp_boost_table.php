<?php

use common\models\Partner;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sp_boost}}`.
 */
class m200916_101650_add_partners_column_to_sp_boost_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sp_boost}}', 'partner_ids', $this->string());

        $this->update('{{%sp_boost}}', ['partner_ids' => join(",", Partner::find()->select('id')->column())]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sp_boost}}', 'partner_ids');
    }
}
