<?php

use common\models\PropertyVisits;
use common\models\UserAktiviteter;
use yii\db\Migration;
use yii\helpers\ArrayHelper;

/**
 * Class m191014_133934_update_user_aktiviteter_table
 */
class m191014_133934_update_user_aktiviteter_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (!$this->db->getTableSchema('{{%user_aktiviteter}}', true)) {
            echo "The table does not exist: user_aktiviteter.\n";
            return false;
        }

        UserAktiviteter::deleteAll();

        $property_visits = PropertyVisits::find()
            ->joinWith(['user'])
            ->asArray()
            ->all();

        foreach ($property_visits as $visit) {
            if (isset($visit['user'])) {
                $user_id = $visit['user']['id'];
                $year = date('Y', $visit['fra']);
                $month = date('n', $visit['fra']);
                $day = date('j', $visit['fra']);
                $user_aktiviteter = UserAktiviteter::findOne([
                    'user_id' => $user_id,
                    'year' => $year,
                    'month' => $month
                ]);
                if ($user_aktiviteter) {
                    $data = json_decode($user_aktiviteter->data, true);
                    $data[$day] += 1;
                } else {
                    $user_aktiviteter = new UserAktiviteter();
                    $user_aktiviteter->user_id = $user_id;
                    $user_aktiviteter->year = $year;
                    $user_aktiviteter->month = $month;
                    $data = array_fill(1, cal_days_in_month(CAL_GREGORIAN, $month, $year), 0);
                    $data[$day] = 1;
                }
                $user_aktiviteter->data = json_encode($data);
                $user_aktiviteter->save(false);
                echo '<pre>';
                print_r(ArrayHelper::toArray($user_aktiviteter));
                echo '</pre>';
            }
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if (!$this->db->getTableSchema('{{%user_aktiviteter}}', true)) {
            echo "The table does not exist: user_aktiviteter.\n";
            return false;
        }

        UserAktiviteter::deleteAll();

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191014_133934_update_user_aktiviteter_table cannot be reverted.\n";

        return false;
    }
    */
}
