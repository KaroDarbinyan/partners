<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "archive_form".
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int $target_id
 * @property int $broker_id
 * @property int $department_id
 * @property int $source_id
 * @property string $address
 * @property string $post_number
 * @property string $phone
 * @property string $email
 * @property string $dob
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $broker
 * @property Department $department
 * @property PropertyDetails $property
 */
class ArchiveForm extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'archive_form';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['target_id', 'broker_id', 'department_id', 'source_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'address', 'email'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 16],
            [['post_number'], 'string', 'max' => 4],
            [['phone'], 'string', 'max' => 30],
            [['dob'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'target_id' => 'Target ID',
            'broker_id' => 'Broker ID',
            'department_id' => 'Department ID',
            'source_id' => 'Source ID',
            'address' => 'Address',
            'post_number' => 'Post Number',
            'phone' => 'Phone',
            'email' => 'Email',
            'dob' => 'Dob',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * A form belongs to an user.
     *
     * @return ActiveQuery
     */
    public function getBroker()
    {
        return $this->hasOne(User::class, ['id' => 'broker_id']);
    }

    /**
     * A form is assigned a department.
     *
     * @return ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id']);
    }

    /**
     * A form belongs to an property.
     *
     * @return ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(PropertyDetails::class, ['id' => 'target_id']);
    }
}
