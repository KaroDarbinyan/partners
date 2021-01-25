<?php
namespace console\controllers\UpdateTraits;

use common\models\Docs;
use common\models\PropertyDetails;

trait UpdateDocsTrait{

    /**
     * Isert or update  all documents with specific key
     * @param array $jsonProp property which belongs douments
     * @param PropertyDetails $newPropD
     * @param int $pCount number of current property
     * @param bool $isShort
     * @throws \yii\db\Exception
     */
    private static function updateDocuments($jsonProp, $newPropD, $pCount = 0, $isShort = false){
        //TODO: complete function
        $docsContainers = [
            'dokumenter',
            'alledokumenter',
        ];
        $jsonObjs = [];
        foreach ($docsContainers as $keyName) {
            if (
                !isset($jsonProp[$keyName]) ||
                !isset($jsonProp[$keyName][0]) ||
                !isset($jsonProp[$keyName][0]['dokument'])
            ) {
                continue;
            }
            $jsonObjs = array_merge($jsonObjs,$jsonProp[$keyName][0]['dokument']);
        }
        if (!count($jsonObjs)){
            Docs::deleteAll(['property_web_id' => $jsonProp['id'],]);
            return;
        }
        self::updatePropertyAttachment(
            'common\models\Docs',
            'web_id',// renamed to web_id in filterDocs
            'filterDocs',
            'property_web_id',
            $jsonObjs,
            $jsonProp, $newPropD, $pCount, $isShort
        );
    }

    /**
     * @param array $jsonObj
     * @return array
     */
    private static function filterDocs($jsonObj){
        $jsonObj['web_id'] = $jsonObj['id'];// rename id
        unset($jsonObj['id']);
        return $jsonObj;
    }

}

