<?php

use yii\db\Migration;

/**
 * Class m190729_075825_add_type_to_news_table
 */
class m190729_075825_add_type_to_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('news', 'type', $this->string()
            ->defaultValue('nyheter'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('news', 'type');
    }
}
