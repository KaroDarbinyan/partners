<?php

use yii\db\Migration;

/**
 * Class m200210_084423_IMPORT_tables_for_partners_databases
 */
class m200210_084423_IMPORT_tables_for_partners_databases extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function up(){
        $db = Yii::$app->db;
        /** @var \console\components\MultyConnection $db */
        $sql = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR .'sqls'. DIRECTORY_SEPARATOR .'involve_structure.sql');
        foreach (array_keys($db->multyConnections) as $k) {
            $db->setActiveConnection($k);
            if($this->db->getTableSchema('user', true)){
                continue;// data already imported
            };
            $command = $db->createCommand($sql);
            /** @var \yii\db\Command $command */
            $command->execute();
        }
        $db->setActiveConnection('main');

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m200210_084423_IMPORT_tables_for_partners_databases migration cannot be reverted";
    }

}
