<?php

use common\models\Forms;
use common\models\LeadLog;
use yii\db\Migration;

/**
 * Class m191210_072121_RE_CREATE_client_table
 */
class m191210_072121_RE_CREATE_client_table extends Migration
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
        if(!isset($this->db->getTableSchema($this->childTableName, true)->columns['client_id'])) {
            $this->addColumn($this->childTableName,'client_id', $this->integer(11));
        }

        $fields = [
            'id'           => $this->primaryKey(),
            'name'         => $this->char(255),
            'email'        => $this->char(255),
            'phone'        => $this->char(30),
            'status'       => $this->char(32),
            'post_number'  => $this->char(4),
            'last_contact' => $this->integer(11),
            'created_at'   => $this->integer(11),
            'updated_at'   => $this->integer(11),
        ];
        $this->createTable($this->tableName, $fields, $tableOptions);
        $clients = Forms::find()->select([
            'id',
            'MAX(phone) as phone',
            'MAX(name) as name',
            'MAX(email) as email',
            'MAX(handle_type) as handle_type',
            'post_number',
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
                ->orderBy(['created_at'=>SORT_DESC,])
                ->all()
            ;
            $bulkInsertArray[]=[
                'name'=>$client->name,
                'email'=>$client->email,
                'phone'=>$client->phone,
                'post_number'=>$client->post_number,
                'status'=>(is_array($logs) && isset($logs[0])) ? $logs[0]->type : 'in_progress',
                'last_contact'=>$time,
                'created_at'=>$time,
                'updated_at'=>$time,
            ];
        }
        if(count($bulkInsertArray)>0){
            $columnNameArray=array_keys($bulkInsertArray[0]);
            $count = Yii::$app->db->createCommand()
                ->batchInsert($this->tableName, $columnNameArray, $bulkInsertArray)
                ->execute();

            $update = Yii::$app->db->createCommand("
              UPDATE {$this->childTableName} INNER JOIN {$this->tableName} 
              ON {$this->childTableName}.phone = {$this->tableName}.phone
              SET client_id = {$this->tableName}.id
            ");
            $update->execute();
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


}
