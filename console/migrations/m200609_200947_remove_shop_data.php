<?php

use common\models\ShopBasket;
use common\models\ShopCategory;
use common\models\ShopImage;
use common\models\ShopOrder;
use common\models\ShopProduct;
use yii\db\Migration;

/**
 * Class m200609_200947_remove_shop_data
 */
class m200609_200947_remove_shop_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        ShopBasket::deleteAll();
        ShopCategory::deleteAll();
        ShopImage::deleteAll();
        ShopOrder::deleteAll();
        ShopProduct::deleteAll();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200609_200947_remove_shop_data cannot be reverted.\n";

        return false;
    }
    */
}
