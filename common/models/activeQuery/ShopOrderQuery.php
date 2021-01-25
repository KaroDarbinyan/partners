<?php

namespace common\models\activeQuery;

/**
 * This is the ActiveQuery class for [[\common\models\ShopOrder]].
 *
 * @see \common\models\ShopOrder
 */
class ShopOrderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\ShopOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ShopOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
