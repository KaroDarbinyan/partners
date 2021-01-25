<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PropertyEvent]].
 *
 * @see PropertyEvent
 */
class PropertyEventQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PropertyEvent[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PropertyEvent|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
