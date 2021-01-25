<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "digital_marketing".
 *
 * @property int $id
 * @property string $key
 * @property int $start
 * @property int $stop
 * @property string $type
 * @property string $campaign_name
 * @property int $source_object_id
 * @property int $live
 * @property int $completed
 * @property string $creative_a_stats
 * @property string $creative_b_stats
 * @property string $stats
 */
class DigitalMarketing extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'digital_marketing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start', 'stop', 'source_object_id', 'live', 'completed'], 'integer'],
            [['key', 'type', 'campaign_name', 'creative_a_stats', 'creative_b_stats', 'stats'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'start' => 'Start',
            'stop' => 'Stop',
            'type' => 'Type',
            'campaign_name' => 'Campaign Name',
            'source_object_id' => 'Source Object ID',
            'live' => 'Live',
            'completed' => 'Completed',
            'creative_a_stats' => 'Creative A Stats',
            'creative_b_stats' => 'Creative B Stats',
            'stats' => 'Stats',
        ];
    }
}
