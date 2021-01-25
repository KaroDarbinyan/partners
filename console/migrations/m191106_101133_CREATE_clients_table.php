<?php

use common\models\Forms;
use common\models\LeadLog;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%clients}}`.
 */
class m191106_101133_CREATE_clients_table extends Migration
{
    private $tableName = '{{%client}}';
    private $childTableName = '{{%forms}}';

    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Drop table if exist
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

        $fields = [
            'id'           => $this->primaryKey(),
            'name'         => $this->char(255),
            'email'        => $this->char(255),
            'phone'        => $this->char(30)->unique(),
            'status'       => $this->char(32),
            'last_contact' => $this->integer(11),
            'created_at'   => $this->integer(11),
            'updated_at'   => $this->integer(11),
        ];
        $this->createTable($this->tableName, $fields, $tableOptions);
        $clients = Forms::find()->select([
            'id',
            'phone',
            'name',
            'email',
            'handle_type',
        ])->groupBy(['phone']);

        $clients = $clients->all();
        $bulkInsertArray = [];
        $time = time();
        $typeArray = [
            "Påminnelse",
            "Vunnet",
            "Tapt",
            "Har tatt kontakt",
            "Får ikke kontakt",
            "Ønsker ikke kontakt",
            "Avtalt befaring",
            "Utført befaring",
        ];
        /** @var Forms[] $clients */
        foreach ($clients as $client) {
            $logs = LeadLog::find()
                ->joinWith(['form'])
                ->where([
                    'forms.phone'=>$client->phone,
                    'lead_log.type'=>$typeArray,
                ])
                ->orderBy([
                    'created_at'=>SORT_DESC,
                ])
                ->all()
            ;
            $bulkInsertArray[]=[
                'phone'=>$client->phone,
                'name'=>$client->name,
                'email'=>$client->email,
                'status'=>(is_array($logs) && isset($logs[0])) ? $logs[0]->type : 'in_progress',
                'last_contact'=>$time,
                'created_at'=>$time,
                'updated_at'=>$time,
            ];
        }
        if(count($bulkInsertArray)>0){
            $columnNameArray=['phone','name', 'email', 'status','last_contact','created_at','updated_at',];
            $count = Yii::$app->db->createCommand()
                ->batchInsert($this->tableName, $columnNameArray, $bulkInsertArray)
                ->execute();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop table if exist
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190429_094021_CREATE_departments_table cannot be reverted.\n";

        return false;
    }
    */
}
