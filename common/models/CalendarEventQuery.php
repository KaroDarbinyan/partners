<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CalendarEvent]].
 *
 * @see CalendarEvent
 */
class CalendarEventQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CalendarEvent[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CalendarEvent|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
