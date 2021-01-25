<?php

use common\models\Salgssnitt;
use yii\db\Migration;
use yii\helpers\ArrayHelper;

/**
 * Handles the creation of table `{{%salgssnitt}}`.
 */
class m190924_073138_create_salgssnitt_table extends Migration
{

    private $tableName = '{{%salgssnitt}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'year' => $this->integer(),
            'month' => $this->integer(),
            'value' => $this->double(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $salgssnitts = file_get_contents(Yii::$app->basePath . '../../' . '/salgssnitt.json');
        $salgssnitts = json_decode($salgssnitts, true);
        foreach ($salgssnitts as $salgssnitt){
            unset($salgssnitt['id']);
            $obj = new Salgssnitt();
            $obj->attributes = $salgssnitt;
            $obj->save();
            print_r(ArrayHelper::toArray($obj));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%salgssnitt}}');
    }
}
