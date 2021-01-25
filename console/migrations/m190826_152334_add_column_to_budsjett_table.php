<?php

use common\models\User;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%budsjett}}`.
 */
class m190826_152334_add_column_to_budsjett_table extends Migration
{

    private $tableName = '{{%budsjett}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if (!isset($table->columns['avdeling_id'])) {
            $this->addColumn($this->tableName, 'avdeling_id', $this->integer());
            $users = User::find()->where(['inaktiv_status' => 1])->all();
            foreach ($users as $user){
                Yii::$app->db->createCommand()->update($this->tableName,['avdeling_id' => $user->id_avdelinger], ['user_id' => $user->id])->execute();
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema($this->tableName, true);

        if (isset($table->columns['avdeling_id']))
            $this->dropColumn($this->tableName, 'avdeling_id');

        return true;
    }
}
