<?php

use common\models\PropertyDetails;
use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table '{{%property_ads}}'.
 */
class m191225_101252_create_property_ads_table extends Migration
{

    private $tableName = '{{%property_ads}}';
    private $propertyTableName = '{{%property_details}}';
    private $columns = [
        'finn_adid',
        'finn_viewings',
        'finn_emails',
        'finn_general_emails',
        'eiendom_viewings',
        'adv_in_fb',
        'adv_in_insta',
        'adv_in_video',
        'adv_in_solgt',
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (!$this->db->getTableSchema($this->tableName, true)) {
            $this->createTable($this->tableName, [
                'id' => $this->primaryKey(),
                'finn_adid' => $this->string(),
                'finn_viewings' => $this->string(),
                'finn_emails' => $this->string(),
                'finn_general_emails' => $this->string(),
                'eiendom_viewings' => $this->integer()->defaultValue(0),
                'adv_in_fb' => $this->boolean()->null()->defaultValue(0),
                'adv_in_insta' => $this->boolean()->null()->defaultValue(0),
                'adv_in_video' => $this->boolean()->null()->defaultValue(0),
                'adv_in_solgt' => $this->boolean()->null()->defaultValue(0),
                'property_id' => $this->integer(),
            ]);
        }

        $item = 0;
        $offset = 0;
        $limit = 500;
        $data = [];
        $count = PropertyDetails::find()->count('id');
        $properties = PropertyDetails::find()
            ->select(array_merge($this->columns, ['id as property_id']))
            ->limit($limit)
            ->offset($offset)
            ->asArray()
            ->all();

        for ($i = 0; $i <= $limit; $i++) {
            ++$item;
            echo "{$count} [\] {$item} \r";
            echo "{$count} [-] {$item} \r";
            echo "{$count} [\] {$item} \r";
            echo "{$count} [-] {$item} \r";
            if ($i === $limit) {
                Yii::$app->db->createCommand()->batchInsert($this->tableName, array_merge($this->columns, ['property_id']), $data)->execute();
                $data = [];
                $offset += $limit;
                $i = 0;

                $properties = PropertyDetails::find()
                    ->select(array_merge($this->columns, ['id as property_id']))
                    ->limit($limit)
                    ->offset($offset)
                    ->asArray()
                    ->all();

                if (!$properties) {
                    break;
                }
                $limit = count($properties);

            }
            $data[] = array_values($properties[$i]);
        }

        if ($table = $this->db->getTableSchema($this->propertyTableName, true)) {
            foreach ($this->columns as $column) {
                if (isset($table->columns[$column]))
                    $this->dropColumn($this->propertyTableName, $column);
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema($this->tableName, true)) {
            $this->dropTable($this->tableName);
        }
    }
}
