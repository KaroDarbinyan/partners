<?php

use common\models\Theme;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%theme}}`.
 */
class m200320_082859_create_theme_table extends Migration
{

    private $tableName = "{{%theme}}";
    private $userTableName = "{{%user}}";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableSchema = $this->db->getTableSchema($this->tableName, true);
        if($tableSchema){
            echo 'table already exist';return;// table already exist
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'color' => $this->string()->notNull(),
            'hex' => $this->string()->notNull(),
            'filename' => $this->string()->notNull()
        ]);

        $this->insert($this->tableName, ["title" => "Blå", "color" => "darkblue", "hex" => "#00008b", "filename" => "dark-blue.css"]);
        $this->insert($this->tableName, ["title" => "Grønn", "color" => "darkgreen", "hex" => "#013220", "filename" => "dark-green.css"]);

        $userTable = $this->db->getTableSchema($this->userTableName, true);
        if(!$userTable){
            echo $this->userTableName . 'table not exist';return;// table already exist
        }
        if (!isset($userTable->columns["theme_id"])) {
            $theme_id = Theme::find()->select(["id"])->one();
            $this->addColumn($this->userTableName, "theme_id", $this->integer()->defaultValue($theme_id->id));
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tableSchema = $this->db->getTableSchema($this->tableName, true);
        if(!$tableSchema){
            echo 'table not exist';return;// table not exist
        }
        $this->dropTable($this->tableName);

        $userTable = $this->db->getTableSchema($this->userTableName, true);
        if(!$userTable){
            echo $this->userTableName . 'table not exist';return;// table not exist
        }
        if (isset($userTable->columns["theme_id"])) $this->dropColumn($this->userTableName, "theme_id");


    }
}
