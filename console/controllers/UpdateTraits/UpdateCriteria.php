<?php
namespace console\controllers\UpdateTraits;

use common\models\Criterias;
use common\models\Docs;
use common\models\PropertyDetails;

trait UpdateCriteria{

    /**
     * Isert or update  all Criterias for Property
     * @param array $jsonProp property which belongs douments
     * @param PropertyDetails $newPropD
     * @param int $pCount number of current property
     * @param bool $isShort
     */
    private static function updateCriterias($jsonProp, $newPropD, $pCount = 0, $isShort = false){
        if (
            !isset($jsonProp['finnmatchekriterier']) ||
            !isset($jsonProp['finnmatchekriterier'][0]) ||
            !isset($jsonProp['finnmatchekriterier'][0]['matchekriterie'])
        ) {
            return;
        }
        $jsonObjs = $jsonProp['finnmatchekriterier'][0]['matchekriterie'];
        if (!count($jsonObjs)){
            Criterias::deleteAll(['property_web_id' => $jsonProp['id'],]);
            return;
        }
        
        self::updatePropertyAttachment(
            Criterias::class,
            'id_typer',
            false,
            'property_web_id',
            $jsonObjs,
            $jsonProp, $newPropD, $pCount, $isShort
        );
    }

}

