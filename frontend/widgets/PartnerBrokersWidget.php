<?php

namespace frontend\widgets;

use common\models\Partner;
use common\models\User;
use yii\base\Widget;
use yii\db\ActiveQuery;
use yii\db\Expression;

class PartnerBrokersWidget extends Widget
{
    public $id = null;
    public $textHeader;
    public $except = [];

    public function run()
    {

        /** @var Partner $partner */
        $partner = Partner::find()
            ->joinWith(['users' => function (ActiveQuery $query) {
                $query->andWhere(['user.inaktiv_status' => -1])
                    ->orderBy(new Expression('rand()'))
                    ->andWhere(['<>', 'user.web_id', User::TEST_BROKER_ID]);
            }])->andWhere(['partner.id' => $this->id])->one();

        if (!$partner) {
            return '';
        }

        return $this->render('brokers', [
            'title' => $this->textHeader,
            'users' => $partner->users
        ]);
    }
}
