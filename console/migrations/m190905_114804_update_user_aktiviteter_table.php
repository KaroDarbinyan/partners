<?php

use common\models\PropertyVisits;
use common\models\UserAktiviteter;
use yii\db\Migration;

/**
 * Class m190905_114804_update_user_aktiviteter_table
 */
class m190905_114804_update_user_aktiviteter_table extends Migration
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
        $property_visits = PropertyVisits::find()
            ->select([
                "DATE_FORMAT(FROM_UNIXTIME(property_visits.fra), '%Y-%m-%d') AS date, 
                     SUBSTR(DATE_FORMAT(FROM_UNIXTIME(property_visits.fra), '%Y-%m-%d'), 1, 4) AS year ,
                     SUBSTR(DATE_FORMAT(FROM_UNIXTIME(property_visits.fra), '%Y-%m-%d'), 6, 2) AS month,
                     SUBSTR(DATE_FORMAT(FROM_UNIXTIME(property_visits.fra), '%Y-%m-%d'), 9, 2) AS day,
                     COUNT(property_visits.id) AS count,
                     property_visits.property_web_id"
            ])
            ->joinWith(['user'])
            ->groupBy(['property_visits.property_web_id'])
            ->orderBy(['year' => SORT_ASC])
            ->orderBy(['month' => SORT_ASC])
            ->orderBy(['day' => SORT_ASC])
            ->asArray()
            ->all();

        foreach ($property_visits as $visit) {
            if (isset($visit['user'])) {
                $year = intval($visit['year']);
                $month = intval($visit['month']);
                $day = intval($visit['day']);
                $count = intval($visit['count']);
                $user_aktiviteter = UserAktiviteter::findOne([
                    'user_id' => $visit['user']['id'],
                    'year' => $year,
                    'month' => $month
                ]);
                if ($user_aktiviteter) {
                    $data = json_decode($user_aktiviteter->data, true);
                    $data[$day] += $count;
                } else {
                    $user_aktiviteter = new UserAktiviteter();
                    $user_aktiviteter->user_id = $visit['user']['id'];
                    $user_aktiviteter->year = $year;
                    $user_aktiviteter->month = $month;
                    $data = array_fill(1, cal_days_in_month(CAL_GREGORIAN, $month, $year), 0);
                    $data[$day] = $count;
                }
                $user_aktiviteter->data = json_encode($data);
                $user_aktiviteter->save(false);
            }
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public
    function safeDown()
    {
        echo "m190905_114804_update_user_aktiviteter_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190905_114804_update_user_aktiviteter_table cannot be reverted.\n";

        return false;
    }
    */
}
