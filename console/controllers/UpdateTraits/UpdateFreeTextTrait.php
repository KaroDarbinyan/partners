<?php
namespace console\controllers\UpdateTraits;

use common\models\FreeText;
use common\models\PropertyDetails;

trait UpdateFreeTextTrait{

    /**
     * @param array $jsonProp
     * @param PropertyDetails $newPropD
     * @param int $pCount
     * @param bool $isShort
     */
    private static function updatePropertyFreeText($jsonProp, $newPropD, $pCount = 0, $isShort = false)
    {
        if (
            !isset($jsonProp['fritekster']) ||
            !isset($jsonProp['fritekster'][0]) ||
            !isset($jsonProp['fritekster'][0]['fritekst'])
        ) {
            FreeText::deleteAll(['propertyDetailId' => $jsonProp['id'],]);
            return;
        }
        self::updatePropertyAttachment(
            'common\models\FreeText',
            'compositeTextId',
            'filterFreeText',
            'propertyDetailId',
            $jsonProp['fritekster'][0]['fritekst'],
            $jsonProp, $newPropD, $pCount, $isShort
        );
    }

    /**
     * @param array $jsonObj
     * @return array
     */
    private static function filterFreeText($jsonObj){
        // Unset tekst field in special cases and when htmlteks is empty or consist only html tags and spaces
        if (
            !isset($jsonObj['htmltekst']) && isset($jsonObj['tekst'])
            || 'Finn.no: Lokalområde' == $jsonObj['overskrift']
            || !strlen(strip_tags(preg_replace('/\s+/', '', $jsonObj['htmltekst'])))
        ) {
            $jsonObj['htmltekst']= $jsonObj['tekst'];
        }
        return $jsonObj;
    }

}

