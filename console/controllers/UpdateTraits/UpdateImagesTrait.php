<?php
namespace console\controllers\UpdateTraits;


use common\models\Image;
use yii\db\Exception;

trait UpdateImagesTrait{
    /**
     * Isert or update  all documents with specific key
     * @param array $jsonProp property which belongs douments
     * @param Property $newProp parent property
     * @param PropertyDetails $newPropD
     * @param int $pCount number of current property
     * @param bool $isShort
     * @return void
     */
    private static function updatePropertyImages($jsonProp, $newProp, $newPropD, $pCount = 0, $isShort = false){

        //TODO: complete function
        $keyName = 'bilder';
        if (
            !isset($jsonProp[$keyName]) ||
            !isset($jsonProp[$keyName][0]) ||
            !isset($jsonProp[$keyName][0]['bilde']) ||
            !count($jsonProp[$keyName][0]['bilde'])
        ) {
            Image::deleteAll(['propertyDetailId' => $jsonProp['id'],]);
            return;
        }

        self::updatePropertyAttachment(
            'common\models\Image',
            'web_id',
            'filterImages',
            'propertyDetailId',
            $jsonProp[$keyName][0]['bilde'],
            $jsonProp, $newProp, $newPropD, $pCount, $isShort
        );
    }

    /**
     * @param array $jsonObj
     * @return array
     */
    private static function filterImages($jsonObj){
        $jsonObj['web_id'] = $jsonObj['id'];// rename id to avoid conflicts in db
        unset($jsonObj['id']);
        return $jsonObj;
    }
}

