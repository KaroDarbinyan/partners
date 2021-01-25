<?php


namespace common\components;

use common\models\ShopCategory;
use common\models\ShopImage;
use common\models\ShopProduct;
use Yii;

class ShopHelper
{

    private static $default_image = "default_img.png";


    /**
     * @param ShopCategory $category
     * @return string
     */
    public static function categoryImage(ShopCategory $category): string
    {
        return self::shopDir() . ($category->image ? "category/{$category->image->name}" : self::$default_image);
    }


    /**
     * @return string
     */
    public static function categoryDir(): string
    {
        return Yii::getAlias('@frontend') . "/web/img/shop/category/";
    }


    /**
     * @param ShopProduct $product
     * @return string
     */
    public static function productDir(ShopProduct $product): string
    {
        return Yii::getAlias('@frontend') . "/web/img/shop/product/{$product->id}/";
    }


    /**
     * @param ShopProduct $product
     * @return string
     */
    public static function productImagesDir(ShopProduct $product): string
    {
        return self::shopDir() . "/product/{$product->id}/";
    }


    /**
     * @param ShopProduct $product
     * @return array
     * @var ShopImage[] $images
     */
    public static function productImages(ShopProduct $product): array
    {
        if ($product->images) {
            $images = $product->images;
            foreach ($images as $key => $image) {
                $images[$key]['name'] = self::shopDir() . "product/{$product->id}/{$image->name}";
            }
        } else {
            $shopImage = new ShopImage();
            $shopImage->name = self::shopDir() . self::$default_image;
            $shopImage->main = true;
            $images = [$shopImage];
        }

        return $images;
    }

    /**
     * @param ShopProduct $product
     * @return string
     */
    public static function productImage(ShopProduct $product): string
    {
        return self::shopDir() . ($product->mainImage ? "product/{$product->id}/{$product->mainImage->name}" : self::$default_image);

    }


    /**
     * @return string
     */
    private static function shopDir(): string
    {
        return Yii::$app->request->hostInfo . "/img/shop/";
    }

}