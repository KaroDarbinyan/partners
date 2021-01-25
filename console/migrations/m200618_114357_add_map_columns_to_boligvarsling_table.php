<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%boligvarsling}}`.
 */
class m200618_114357_add_map_columns_to_boligvarsling_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%boligvarsling}}', 'map_lat', $this->float()->null());
        $this->addColumn('{{%boligvarsling}}', 'map_lng', $this->float()->null());
        $this->addColumn('{{%boligvarsling}}', 'map_radius', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%boligvarsling}}', 'map_lat');
        $this->dropColumn('{{%boligvarsling}}', 'map_lng');
        $this->dropColumn('{{%boligvarsling}}', 'map_radius');
    }
}
