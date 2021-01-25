<?php

namespace console\controllers;

use common\components\WebmeglerApiHelper;
use common\models\Forms;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\Console;
use yii\helpers\Json;

class WebmeglerController extends Controller
{
    /**
     * Traits
     */
    use UpdateTraits\CoreActions;

    // use UpdateTraits\UpdateVisitsTrait;

    public function actionPushLeads()
    {
        if (\Yii::$app->params['blockWebmeglerPush'] ?? false) {
            Console::error('The command is disabled in the system settings [blockWebmeglerPush = true].');

            return ExitCode::UNAVAILABLE;
        }

        $query = (new Query)
            ->from('forms f')
            ->leftJoin('property_details p', 'f.target_id = p.id')
            ->where([
                'f.type' => ['book_visning', 'visningliste', 'budvarsel', 'salgsoppgave'],
                'f.pushed_to_webmegler' => false
            ])
            ->andWhere(['<', 'f.push_attempts', 5])
            ->andWhere([
                'p.solgt' => 0
            ]);

        $total = (clone $query)->count();
        $done = 0;

        Console::startProgress($done, $total);

        $webmegler = new WebmeglerApiHelper;

        foreach ($query->batch(50) as $leads) {
            foreach ($leads as $lead) {
                $webmegler->registerInteressent($lead);

                if ($lead['download_sales_report'] ?? false) {
                    $data = new \ArrayObject($lead);
                    $data['type'] = 'salgsoppgave';

                    $webmegler->registerInteressent($data->getArrayCopy());
                }

                Console::updateProgress(++ $done, $total);
            }
        }

        Console::endProgress();

        return ExitCode::OK;
    }
}
