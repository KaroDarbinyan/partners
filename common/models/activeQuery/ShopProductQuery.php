<?php

namespace common\models\activeQuery;

/**
 * This is the ActiveQuery class for [[\common\models\ShopProduct]].
 *
 * @see \common\models\ShopProduct
 */
class ShopProductQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(["active" => 1]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ShopProduct[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\ShopProduct|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
