<?php

use common\models\News;
use yii\db\Migration;

/**
 * Class m190926_114246_add_columns_news
 */
class m190926_114246_add_columns_news extends Migration
{


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn(News::tableName(), 'show_img', $this->integer()->defaultValue(1));
    }

    public function down()
    {
        echo "m190926_114246_add_columns_news cannot be reverted.\n";

        return false;
    }

}
