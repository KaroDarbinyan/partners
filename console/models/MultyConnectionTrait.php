<?php
namespace console\models;

use console\components\MultyConnection;
use Yii;

trait MultyConnectionTrait{
    public function save($runValidation = true, $attributeNames = null){// TODO:: move to console trait and exted for Forms
        $db = Yii::$app->db;
        $saveIn = ['main', $this->department->partner->slug];

        /** @var MultyConnection $db */
        $oldAttrs = $this->getOldAttributes();
        foreach ($saveIn as $conKey) {
            $db->setActiveConnection($conKey);
            if (!Forms::findOne(['id'=>$this->id])){
                $this->setOldAttributes(null);
            }
            parent::save($runValidation,$attributeNames);
        }
        $db->setActiveConnection('main');
    }

}