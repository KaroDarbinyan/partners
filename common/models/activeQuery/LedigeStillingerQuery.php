<?php

namespace common\models\activeQuery;

/**
 * This is the ActiveQuery class for [[\common\models\LedigeStillinger]].
 *
 * @see \common\models\LedigeStillinger
 */
class LedigeStillingerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\LedigeStillinger[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\LedigeStillinger|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return LedigeStillingerQuery
     */
    public function isActive() {
        return $this->where(['status' => 1]);
    }
}
