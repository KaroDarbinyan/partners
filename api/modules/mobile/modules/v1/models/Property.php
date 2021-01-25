<?php

namespace api\modules\mobile\modules\v1\models;


use common\models\Docs;
use common\models\PropertyNeighbourhood;
use common\models\PropertyVisits;
use Yii;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "property".
 *
 * @property int $id
 * @property int $web_id
 * @property string $address
 * @property double $price
 * @property string $type
 * @property int $s_meters
 * @property int $employee_id
 * @property PropertyDetails $propertyDetails
 * @property User $user
 * @property Image $propertyImage
 * @property Docs $propertyDoc
 * @property Docs $propertyDocs[]
 * @property PropertyNeighbourhood[] $neighbors
 * @property PropertyVisits[] $visits
 * @property PropertyLinks $salgsoppgaveDownloadLink
 */
class Property extends ActiveRecord
{

    /**
     * @return ActiveQuery
     */
    public function getPropertyDetails()
    {
        return $this->hasOne(PropertyDetails::className(), ['id' => 'web_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['web_id' => 'employee_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPropertyImage()
    {
        return $this->hasOne(Image::className(), ['propertyDetailId' => 'web_id'])->andOnCondition(['nr' => 1]);
    }

    /**
     * @return ActiveQuery
     */
    public function getPropertyDocs()
    {
        return $this->hasMany(Docs::className(), ['property_web_id' => 'web_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPropertyDoc()
    {
        return $this->hasOne(Docs::className(), ['property_web_id' => 'web_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSalgsoppgaveDownloadLink()
    {
        return $this->hasOne(PropertyLinks::className(), ['property_web_id' => 'web_id'])
            ->andOnCondition(['like', 'navn', 'Digitalformat salgsoppgave - ']);
    }

    /**
     * @return ActiveQuery
     */
    public function getNeighbors()
    {
        return $this->hasMany(PropertyNeighbourhood::className(), ['property_web_id' => 'web_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVisits()
    {
        return $this->hasMany(PropertyVisits::className(), ['property_web_id' => 'web_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLinks()
    {
        return $this->hasMany(PropertyLinks::className(), ['property_web_id' => 'web_id']);
    }

    /**
     * Determine if the current property is marked as the sold.
     *
     * @return bool
     */
    public function isSold(): bool
    {
        return $this->propertyDetails->solgt == -1;
    }

    /**
     * Get a string path for the property.
     *
     * @return string
     */
    public function path(): string
    {
        return Url::toRoute([($this->isSold() ? '/eiendom/' : '/annonse/') . $this->web_id]);
    }
}
