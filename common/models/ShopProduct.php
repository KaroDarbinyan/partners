<?php

namespace common\models;

use common\components\ShopHelper;
use common\models\activeQuery\ShopProductQuery;
use Throwable;
use Yii;
use yii\base\ErrorException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "shop_product".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $description
 * @property double $price
 * @property int $active
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ShopCategory $category
 * @property ShopImage[] $images
 * @property ShopImage $mainImage
 */
class ShopProduct extends ActiveRecord
{

    public $pictures;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_product';
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ]
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'active', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['category_id', 'name'], 'required'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            [['name'], 'string', 'max' => 255],
            [['pictures'], 'file', 'maxFiles' => 10, 'extensions' => ['png', 'jpg', 'jpeg'], 'maxSize' => 1024 * 1024 * 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Kategori',
            'name' => 'Navn',
            'description' => 'Beskrivelse',
            'price' => 'Pris',
            'active' => 'Aktiv',
            'created_at' => 'Laget',
            'updated_at' => 'Oppdatert',
        ];
    }


    public function beforeValidate()
    {
        $this->pictures = UploadedFile::getInstances($this, 'pictures');
        return parent::beforeValidate();
    }


    public function afterSave($insert, $changedAttributes)
    {
        if ($this->pictures) {
            $directory = ShopHelper::productDir($this);
            if (!is_dir($directory)) {
                FileHelper::createDirectory($directory);
            }
            foreach ($this->pictures as $pictures) {
                $image_name = sprintf("%s.%s", uniqid(time()), $pictures->extension);
                if ($pictures->saveAs("{$directory}{$image_name}")) {
                    $shopImage = new ShopImage();
                    $shopImage->name = $image_name;
                    $shopImage->product_id = $this->id;
                    $shopImage->save();
                }
            }
            if ($insert) Yii::$app->db->createCommand(
                "UPDATE " . ShopImage::tableName() . " SET main = 1 WHERE product_id = '{$this->id}' LIMIT 1"
            )->execute();
        }
        parent::afterSave($insert, $changedAttributes);
    }


    /**
     * @return bool|false|int
     * @throws Throwable
     * @throws ErrorException
     * @throws StaleObjectException
     */
    public function delete()
    {
        ShopImage::deleteAll(['product_id' => $this->id]);
        ShopBasket::deleteAll(['product_id' => $this->id]);
        if (is_dir(ShopHelper::productDir($this)))
            FileHelper::removeDirectory(ShopHelper::productDir($this));
        return parent::delete();
    }

    /**
     * {@inheritdoc}
     * @return ShopProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShopProductQuery(get_called_class());
    }


    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(ShopCategory::class, ['id' => 'category_id']);
    }


    /**
     * @return ActiveQuery
     */
    public function getImages(): ActiveQuery
    {
        return $this->hasMany(ShopImage::class, ['product_id' => 'id']);
    }


    /**
     * @return ActiveQuery
     */
    public function getOrder(): ActiveQuery
    {
        return $this->hasOne(ShopOrder::class, ['product_id' => 'id']);
    }


    /**
     * @return ActiveQuery
     */
    public function getMainImage(): ActiveQuery
    {
        return $this->hasOne(ShopImage::class, ['product_id' => 'id'])
            ->andWhere(['shop_image.main' => 1]);
    }
}
