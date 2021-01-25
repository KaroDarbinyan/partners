<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "post_number".
 *
 * @property int $id
 * @property string $index
 * @property Department[] $departments
 * @property int $department_id
 *
 */
class PostNumber extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_number';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['index', 'department_id'], 'required'],
            [['department_id'], 'integer'],
            [['index'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'index' => 'Index',
            'department_id' => 'Department ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function getDepartments()
    {
        return $this->hasMany(Department::class, ['web_id' => 'department_id'])
            ->viaTable('tbl_department_post_number', ['post_number' => 'id']);

    }

    public function getRealPostNumber()
    {
        return $this->hasOne(AllPostNumber::class, ['post_number' => 'index']);
    }
}
