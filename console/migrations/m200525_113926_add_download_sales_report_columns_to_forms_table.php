<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%forms}}`.
 */
class m200525_113926_add_download_sales_report_columns_to_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%forms}}', 'download_sales_report', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%forms}}', 'download_sales_report');
    }
}
