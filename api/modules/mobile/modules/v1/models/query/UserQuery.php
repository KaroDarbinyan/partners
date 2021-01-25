<?php

namespace api\modules\mobile\modules\v1\models\query;

use api\modules\mobile\modules\v1\models\User;
use yii\db\ActiveQuery;

class UserQuery extends ActiveQuery
{

    public function active()
    {
        return $this->andWhere(["inaktiv_status" => 1]);
    }

    /**
     * @param null $db
     * @return array|User[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param null $db
     * @return array|null|User
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}