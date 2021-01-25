<?php

use yii\db\Migration;

/**
 * Class m190410_100108_INSERT_into_eser_tables
 */
class m190410_100108_INSERT_into_eser_tables extends Migration
{
    private $tableName = '{{%user}}';
    private $pairTableName = '{{%property}}';
    private $fileName = 'frontend/web/requests/departments_nested.json';
    private $data = [];
    /**
     * {@inheritdoc}
     */
    public function safeUp(){
        $table = $this->db->getTableSchema($this->tableName, true);
        try{
            $this->dropIndex('email', $this->tableName);
        }
        catch(Exception $e){};

        $data = file_get_contents($this->fileName);
        $this->data = json_decode($data, true);
        $this->execute("SET foreign_key_checks = 0;");
        $this->createInsertUser();
        $this->execute("SET foreign_key_checks = 1;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(){
        $this->firstUser();
        $this->createIndex('email', $this->tableName, 'email', $unique = true );
    }

    /**
     * Create property and property_details tables and insert property_details Table
     */
    private function createInsertUser(){
        $tableOptions = '';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->firstUser();

        $departments = $this->data;
        $table = $this->db->getTableSchema($this->pairTableName, true);

        if(!isset($table->columns['employee_id'])) {
            $this->addColumn($this->pairTableName, 'employee_id', $this->integer());
        }

        $table = $this->db->getTableSchema($this->tableName, true);
        if(!isset($table->columns['deprtment_id'])) {
            $this->addColumn($this->tableName, 'deprtment_id', $this->integer());
        }
        if(!isset($table->columns['web_id'])) {
            $this->addColumn($this->tableName, 'web_id', $this->integer());
        }

        $fields = [
            'id' => $this->primaryKey(),
            'email' => $this->char(128),
            'deprtment_id' => $this->integer(),
            'web_id' => $this->integer(),
        ];


        $table = $this->db->getTableSchema($this->tableName, true);

        /**
         * Insert Data in property_details
         */
        foreach ($departments as $i => $department) {

            foreach ($department['employees'] as $i => $employee) {
                $row = [
                    'deprtment_id' => $department['id'],
                ];
                foreach ($employee as $name => $column) {
                    // Update property employee id
                    if ($name == "properties"){
                        foreach ($column as $property) {
                            $this->update(
                                $this->pairTableName,
                                ['employee_id' => $employee['id']],
                                ['web_id' => $property['id'],]
                            );
                        }
                    }
                    if ('id' == $name){
                        $name = 'web_id';
                    }
                    if (!isset($fields[$name])){
                        if(!isset($table->columns[$name])) {
                            $this->addColumn($this->tableName, $name, 'LONGTEXT');
                        }
                        $fields[$name] = 'LONGTEXT';
                    }
                    $row[$name] = is_array($column) ? json_encode($column) : $column;
                }
                $row['email'] = isset($row['email']) ? $row['email'] : '';
                $row['username'] = $row['web_id'];
                $row['password_hash'] = '$2y$13$/9I9i5NQ9Bcw9qBsvhIAb.N56oMCSRS1kwi9M6u3m.vKR3cRu0J/2';
                $row['password_reset_token'] = NULL;
                $row['status'] = 10;
                $row['created_at'] = 1551385378;
                $row['updated_at'] = 1551385378;
                $this->insert ( $this->tableName, $row );
            }
        }
    }

    private function firstUser(){
        try{
            $this->delete($this->tableName, 'true');
        }catch(Exception $e){};
        $this->insert($this->tableName,[
            'username'=>'admin',
            'auth_key'=>'NLJPOXnoyyDGwa-Lo3usOgOb-IoHyCZK',
            'password_hash'=>'$2y$13$/9I9i5NQ9Bcw9qBsvhIAb.N56oMCSRS1kwi9M6u3m.vKR3cRu0J/2',
            'password_reset_token' => NULL,
            'email'=> 'admin@admin.ru',
            'status'=>10,
            'created_at'=>1551385378,
            'updated_at'=>1551385378
        ]);
    }
}
