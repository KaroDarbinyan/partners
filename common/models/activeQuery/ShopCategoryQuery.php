<?php

namespace common\models\activeQuery;

use common\models\ShopCategory;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\ShopCategory]].
 *
 * @see ShopCategory
 */
class ShopCategoryQuery extends ActiveQuery
{
    public function active()
    {
        return $this->andWhere(["active" => 1]);
    }

    /**
     * {@inheritdoc}
     * @return ShopCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ShopCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
