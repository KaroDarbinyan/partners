<?php

use yii\db\Migration;

/**
 * Class m200124_062347_ADD_department_to_postnummer_table
 */
class m200124_062347_ADD_department_to_postnummer_table extends Migration
{
    private $tableName = '{{%tbl_department_post_number}}';

    /**
     * {@inheritdoc}
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable( $this->tableName, [
            'id' => $this->primaryKey(11)->notNull(),
            'post_number' => $this->integer(11)->notNull(),
            'department_id' => $this->integer(11)->notNull(),
        ],$tableOptions);

        $this->createIndex('unique_combination',
            $this->tableName,
            ['post_number', 'department_id'],
            true
        );

        $postNumbersSql = (new \yii\db\Query())
            ->select(['index', 'department_id'])
            ->from('post_number')
            ->where(['not', ['department_id'=>null]])
            ->createCommand()
            ->getRawSql()
        ;

        Yii::$app->db
            ->createCommand("
                INSERT INTO {$this->tableName} (post_number,department_id)  
                {$postNumbersSql}
            ")
            ->execute()
        ;

        $sql = Yii::$app->db->queryBuilder->batchInsert(
            $this->tableName,
            ['post_number', 'department_id'],
            [
                ['post_number'=>'0581','department_id'=>'3000006'],
                ['post_number'=>'0581','department_id'=>'3000010'],
                ['post_number'=>'654','department_id'=>'3000007'],
                ['post_number'=>'654','department_id'=>'3000010'],
                ['post_number'=>'655','department_id'=>'3000007'],
                ['post_number'=>'655','department_id'=>'3000010'],
                ['post_number'=>'0562','department_id'=>'3000007'],
                ['post_number'=>'0562','department_id'=>'3000010'],
                ['post_number'=>'0664','department_id'=>'3000007'],
                ['post_number'=>'0664','department_id'=>'3000010'],
                ['post_number'=>'0665','department_id'=>'3000007'],
                ['post_number'=>'0665','department_id'=>'3000010'],
                ['post_number'=>'0666','department_id'=>'3000007'],
                ['post_number'=>'0666','department_id'=>'3000010'],
                ['post_number'=>'0484','department_id'=>'3000005'],
                ['post_number'=>'0484','department_id'=>'3000008'],
                ['post_number'=>'0485','department_id'=>'3000005'],
                ['post_number'=>'0485','department_id'=>'3000008'],
                ['post_number'=>'0555','department_id'=>'3000005'],
                ['post_number'=>'0555','department_id'=>'3000011'],
                ['post_number'=>'0587','department_id'=>'3000010'],
                ['post_number'=>'0587','department_id'=>'3000005'],            ]
        );
        $sql = str_replace("INSERT INTO ","REPLACE INTO ",$sql);
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema($this->tableName, true) !== null) {
            $this->dropTable($this->tableName);
        }
    }
}
