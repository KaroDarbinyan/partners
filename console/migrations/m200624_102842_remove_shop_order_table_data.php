<?php

use common\models\ShopBasket;
use common\models\ShopOrder;
use yii\db\Migration;

/**
 * Class m200624_102842_remove_shop_order_table_data
 */
class m200624_102842_remove_shop_order_table_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        ShopBasket::deleteAll();
        ShopOrder::deleteAll();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

}
