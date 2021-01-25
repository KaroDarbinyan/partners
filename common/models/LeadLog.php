<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "lead_log".
 */
class LeadLog extends LeadLogMockup
{
    const TYPE_SEED = '1006';

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * Child classes may override this method to specify the behaviors they want to behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * This method is invoked after deleting a record.
     *
     * The default implementation raises the [[EVENT_AFTER_DELETE]] event.
     *
     * @return void
     *
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function afterDelete()
    {
        if ($this->getOldAttribute('type') === '1014') {
            /** @var Forms $previousLog */
            $previousLog = static::find()
                ->where(['not in', 'type', ['1006', '1012']])
                ->andWhere(['lead_id' => $this->lead_id])
                ->orderBy(['created_at' => SORT_DESC])
                ->one();

            if ($previousLog) {
                $this->form->status = $this->form->handle_type = $previousLog->type;
                $this->form->update(false);
            }
        }
    }
}
