<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "lead_log".
 *
 * @property int $id
 * @property int $lead_id
 * @property string $type
 * @property string $message
 * @property int $created_at
 * @property int $updated_at
 * @property int $notify_at
 * @property int $inform_in_advance
 * @property Forms $form
 * @property int $user_id
 * @property User $user
 */
class LeadLogMockup extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lead_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lead_id', 'type', 'created_at', 'updated_at'], 'required'],
            [['lead_id', 'created_at', 'updated_at', 'status', 'user_id'], 'integer'],
            [['type', 'message', 'notify_at', 'inform_in_advance'], 'string', 'max' => 255],
            [['message'], 'default', 'value' => null],
            [['lead_id'], 'exist', 'skipOnError' => true, 'targetClass' => Forms::className(), 'targetAttribute' => ['lead_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lead_id' => 'Lead ID',
            'type' => 'Type',
            'message' => 'Message',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'notify_at' => 'Notify At',
            'inform_in_advance' => 'Inform in advance',
        ];
    }

    /**
     *  This method is overridden so that attributes and related objects can be accessed like properties.
     *
     * @param string $name
     *
     * @return mixed|string
     */
    public function __get($name)
    {
        if (in_array($name, ['type'])) {
            return \Yii::t('lead_log', $this->getAttribute($name));
        }

        return parent::__get($name);
    }

    function beforeSave($insert)
    {
        if ($insert && isset(Yii::$app->user) && isset(Yii::$app->user->identity)) {
            $this->user_id = Yii::$app->user->identity->web_id;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['web_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Forms::class, ['id' => 'lead_id']);
    }
}
