<?php

use common\models\Forms;
use common\models\LeadLog;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%forms}}`.
 */
class m200520_140711_add_notify_columns_to_forms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%forms}}', 'notify_note', $this->string()->null());
        $this->addColumn('{{%forms}}', 'notify_at', $this->integer()->null());

        $logs = LeadLog::find()
            ->with('form')
            ->where(['not', ['notify_at' => null]])
            ->groupBy(['lead_id'])
            ->orderBy(['notify_at' => SORT_DESC]);

        foreach ($logs->batch(25) as $logs) {
            foreach ($logs as $log) {
                /** @var Forms $form */
                if ($form = $log->form) {
                    $form->updateAttributes([
                       'notify_note' => $log->message,
                       'notify_at' => $log->notify_at
                    ]);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%forms}}', 'notify_note');
        $this->dropColumn('{{%forms}}', 'notify_at');
    }
}
