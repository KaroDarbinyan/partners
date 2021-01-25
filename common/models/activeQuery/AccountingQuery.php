<?php

namespace common\models\activeQuery;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [Accounting].
 *
 */
class AccountingQuery extends ActiveQuery
{

    /**
     * @return AccountingQuery
     */
    public function filter(): AccountingQuery
    {
        return $this->andWhere(["or",
            ["accounting.linjenummer" => 1],
            ["accounting.linjenummer" => 2],
            ["like", "accounting.kommentar", "Delt provisjon%", false],
            ["like", "accounting.kommentar", "Delt tilrettelegging%", false]
        ]);
    }


    /**
     * @param null $db
     * @return array|ActiveRecord[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }


    /**
     * @param null $db
     * @return array|ActiveRecord|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
