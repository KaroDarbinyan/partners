<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post_number}}`.
 */
class m190422_080029_create_post_number_table extends Migration
{
    private $tableName = '{{%post_number}}';
    private $officeTableName = '{{%offices}}';
    private $fileName = 'frontend/web/requests/office.json';
    private $data = [];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'index' => $this->string()->notNull(),
            'offices_id' => $this->integer()->notNull(),
        ]);


        $this->data = json_decode(
            file_get_contents($this->fileName),
            true)["office"];
        foreach ($this->data as $dataRow) {
            $this->insert($this->officeTableName, ["name" => $dataRow["address"]]);
            $office_id = $this->getDb()->getLastInsertID();
            $post_nummers = explode(",", $dataRow["post_nummer"]);
            foreach ($post_nummers as $post_nummer) {
                $this->insert($this->tableName, [
                    "index" => $post_nummer,
                    "offices_id" => $office_id,
                ]);
            }
        }

        $this->addForeignKey(
            "offices_to_post_number",
            "post_number",
            "offices_id",
            "offices",
            "id"
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if ($this->db->getTableSchema('forms', true) !== null) {
            $this->execute("SET foreign_key_checks = 0;");
            $this->dropTable('{{%post_number}}');
        }

    }
}
