<?php

namespace common\models;

use common\models\activeQuery\ShopImageQuery;
use Throwable;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "shop_image".
 *
 * @property int $id
 * @property int $product_id
 * @property int $category_id
 * @property string $name
 * @property int $main
 * @property string $path
 */
class ShopImage extends ActiveRecord
{

    public $path;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'category_id', 'main'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'category_id' => 'Category ID',
            'name' => 'name',
            'main' => 'Main',
        ];
    }


    /**
     * @return bool|false|int
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function delete()
    {
        if (file_exists($this->path))
            FileHelper::unlink($this->path);

        return parent::delete();
    }

    /**
     * {@inheritdoc}
     * @return ShopImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShopImageQuery(get_called_class());
    }
}
