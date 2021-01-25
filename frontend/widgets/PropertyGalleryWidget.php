<?php

namespace frontend\widgets;

use common\models\PropertyDetails;
use yii\base\Widget;

class PropertyGalleryWidget extends Widget
{
    /** @var PropertyDetails */
    public $property = null;

    public function run()
    {
        if (!$this->property) {
            return '';
        }

        return $this->render('property_gallery', [
            'property' => $this->property,
            'images' => $this->property->getGalleryImages(),
            'isSolgt' => $this->property->solgt == -1,
        ]);
    }
}
