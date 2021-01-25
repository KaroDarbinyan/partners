<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Class m190619_141809_add_column_to_department_table
 */
class m190619_141809_add_column_to_department_and_user_table extends Migration
{

    private $department = '{{%department}}';
    private $user = '{{%user}}';
    private $departmentTable;
    private $userTable;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->departmentTable = $this->db->getTableSchema($this->department, true);
        $this->userTable = $this->db->getTableSchema($this->user, true);

        if (!isset($this->departmentTable->columns['short_name'])) {
            $this->addColumn($this->department, 'short_name', $this->string());
        }

        $departments = (new Query())
            ->select(['id', 'navn'])
            ->from($this->department)
            ->all();

        foreach ($departments as $department) {
            $name = str_replace('  ', ' ', $department['navn']);
            $name = str_replace(['Tunsli ', 'Schala ', '& Partners ', 'avd '], '', $name);
            $name = str_replace('/', ' / ', $name);
            $departmentsShortName['short_name'] = $name;
            $this->update($this->department, $departmentsShortName, ['id' => $department['id']]);
        }

        if (!isset($this->userTable->columns['url'])) {
            $this->addColumn($this->user, 'url', $this->string());
        }
        if (!isset($this->userTable->columns['short_name'])) {
            $this->addColumn($this->user, 'short_name', $this->string());
        }

        $users = (new Query())
            ->select(['id', 'navn'])
            ->from($this->user)
            ->where(['not', ['navn' => null]])
            ->all();

        foreach ($users as $user) {
            $name = str_replace([' (Regnskapsfører)', ' (regnskap)', ' (Reeltime)', '.'], '', $user['navn']);
            $name = str_replace('ø', 'o', $name);
            $name = str_replace('ü', 'u', $name);
            $name = str_replace(['å', 'Å'], 'a', $name);
            $name = str_replace('ü', 'u', $name);
            $name = str_replace('æ', 'ae', $name);
            $name = str_replace('é', 'e', $name);
            $name = str_replace('  ', ' ', $name);
            $name = str_replace(['/', ' '], '_', $name);
            $userUrl['url'] = strtolower($name . '_' . $user['id']);
            $this->update($this->user, $userUrl, ['id' => $user['id']]);
        }

        foreach ($users as $user) {
            $name = str_replace([' (Regnskapsfører)', ' (regnskap)', ' (Reeltime)'], '', $user['navn']);
            $userShortName['short_name'] = $name;
            $this->update($this->user, $userShortName, ['id' => $user['id']]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->departmentTable = $this->db->getTableSchema($this->department, true);
        $this->userTable = $this->db->getTableSchema($this->user, true);

        if (isset($this->departmentTable->columns['short_name'])) {
            $this->dropColumn($this->department, 'short_name');
        }
        if (isset($this->userTable->columns['url'])) {
            $this->dropColumn($this->user, 'url');
        }
        if (isset($this->userTable->columns['short_name'])) {
            $this->dropColumn($this->user, 'short_name');
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190610_125443_update_all_department_url cannot be reverted.\n";

        return false;
    }
    */
}
