<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "department_to_news".
 *
 * @property int $id
 * @property string $partner_id
 * @property string $news_id
 */
class DepartmentToNews extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department_to_news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[/*'partner_id', 'department_web_id',*/ 'news_id'], 'required'],
            [['partner_id', 'department_web_id', 'news_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'partner_id' => 'Partner ID',
            'department_web_id' => 'Department Web ID',
            'news_id' => 'News ID',
        ];
    }


    /**
     * @return ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['web_id' => 'department_web_id']);
    }


    public static function hasAccess($news_id)
    {
        /** @var User $identity */
        $identity = Yii::$app->user->identity;
        return $identity->hasRole("superadmin") ? true : self::find()->where([
            'news_id' => $news_id,
            'partner_id' => $identity->department->partner_id,
            'department_web_id' => $identity->id_avdelinger
        ])->exists();

    }

}
