<?php

namespace common\models;

use common\components\ShopHelper;
use common\models\activeQuery\ShopCategoryQuery;
use Throwable;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "shop_category".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $active
 * @property int $created_at
 * @property int $updated_at
 * @property UploadedFile $picture
 *
 * @property ShopProduct[] $products
 * @property ShopImage $image
 */
class ShopCategory extends ActiveRecord
{


    public $picture;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_category';
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ]
            ]
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['name', 'active'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['picture'], 'file', 'extensions' => ['png', 'jpg', 'jpeg'], 'maxSize' => 1024 * 1024 * 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Navn',
            'description' => 'Beskrivelse',
            'active' => 'Active',
            'picture' => 'Aktiv',
            'created_at' => 'Laget',
            'updated_at' => 'Oppdatert',
        ];
    }

    public function beforeValidate()
    {
        $this->picture = UploadedFile::getInstance($this, 'picture');
        return parent::beforeValidate();
    }


    public function afterSave($insert, $changedAttributes)
    {
        if ($this->picture) {
            $directory = ShopHelper::categoryDir();
            if (!is_dir($directory)) {
                FileHelper::createDirectory($directory);
            }
            $image_name = sprintf("%s.%s", uniqid(time()), $this->picture->extension);
            if ($this->picture->saveAs("{$directory}{$image_name}")) {
                if ($this->id && ($shopImage = $this->image)) {
                    $shopImage->path = ShopHelper::categoryDir() . $shopImage->name;
                    $shopImage->delete();
                }
                $shopImage = new ShopImage();
                $shopImage->name = $image_name;
                $shopImage->category_id = $this->id;
                $shopImage->save();
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return bool|false|int
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function delete()
    {

        if ($this->image) {
            $categoryImage = ShopHelper::categoryDir() . $this->image->name;
            if (file_exists($categoryImage)) {
                FileHelper::unlink($categoryImage);
            }
            ShopImage::deleteAll(['category_id' => $this->id]);
        }

        if ($products = $this->products) {
            foreach ($products as $product) $product->delete();
        }


        return parent::delete();
    }


    /**
     * {@inheritdoc}->andWhere(['shop_image.active' => 1])
     * @return ShopCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShopCategoryQuery(get_called_class());
    }


    /**
     * @return ActiveQuery
     */
    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(ShopProduct::class, ['category_id' => 'id']);
    }


    /**
     * @return ActiveQuery
     */
    public function getImage(): ActiveQuery
    {
        return $this->hasOne(ShopImage::class, ['category_id' => 'id']);
    }
}
