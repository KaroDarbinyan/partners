<?php
namespace console\controllers\UpdateTraits;


use common\models\Docs;

trait UpdateVisitsTrait{
    /**
     * Isert or update  all documents with specific key
     * @param array $jsonProp property which belongs douments
     * @param PropertyDetails $newPropD
     * @param int $pCount number of current property
     * @param bool $isShort
     * @throws \yii\db\Exception
     */
    private static function updateVisits($jsonProp, $newPropD, $pCount = 0, $isShort = false){
        //TODO: complete function
        $keyName = 'visninger';
        if (
            !isset($jsonProp[$keyName]) ||
            !isset($jsonProp[$keyName][0]) ||
            !isset($jsonProp[$keyName][0]['visning']) ||
            !count($jsonProp[$keyName][0]['visning'])
        ) {
            Docs::deleteAll(['property_web_id' => $jsonProp['id'],]);
            return false;
        }

        if (!count($jsonObjs)){
            return;
        }
        self::updatePropertyAttachment(
            'common\models\Docs',
            'web_id',// renamed to web_id in filterDocs
            'filterDocs',
            'property_web_id',
            $jsonObjs,
            $jsonProp, $newProp, $newPropD, $pCount, $isShort
        );
    }

}

