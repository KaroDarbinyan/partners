<?php

use yii\db\Migration;

/**
 * Class m200121_120614_DB_OPTIMISATION
 */
class m200121_120614_DB_OPTIMISATION extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema('all_post_number', true);
        if (!$table) {
            echo "Table all_post_number does not exist \n";
        }else{
            if(isset($table->columns['index'])) {
                $this->renameColumn('all_post_number','index', 'post_number');
            }
        }

        $table = $this->db->getTableSchema('client', true);
        if (!$table) {
            echo "Table client does not exist \n";
        }else{
            if(isset($table->columns['bloked'])) {
                $this->renameColumn('client','bloked', 'blocked');
                $this->alterColumn('client','blocked', $this->boolean());
            }
        }

        $table = $this->db->getTableSchema('dwelling_forms', true);
        if (!$table) {
            echo "Table dwelling_forms does not exist \n";
        }else{
            $this->renameTable('dwelling_forms','boligvarsling');
        }

        $table = $this->db->getTableSchema('filter_notification', true);
        if (!$table) {
            echo "Table filter_notification does not exist \n";
        }else{
            $this->dropTable('filter_notification');
        }

        $table = $this->db->getTableSchema('forms', true);
        if (!$table) {
            echo "Table forms does not exist \n";
        }else{
            if(isset($table->columns['surname'])) {
                $this->dropColumn('forms','surname');
            }
            if(isset($table->columns['advice_to_email'])) {
                $this->dropColumn('forms','advice_to_email');
            }

            if(isset($table->columns['employee_web_id'])) {
                $this->dropColumn('forms','employee_web_id');
            }
            if(isset($table->columns['employee_phone'])) {
                $this->dropColumn('forms','employee_phone');
            }

            if(isset($table->columns['area_range'])) {
                $this->dropColumn('forms','area_range');
            }
        }

        $table = $this->db->getTableSchema('image', true);
        if (!$table) {
            echo "Table image does not exist \n";
        }else{
            if(isset($table->columns['storthumbnailfil'])) {
                $this->dropColumn('image','storthumbnailfil');
            }
            if(isset($table->columns['originalbildefil'])) {
                $this->dropColumn('image','originalbildefil');
            }

            if(isset($table->columns['height'])) {
                $this->alterColumn('image','height', $this->integer(5));
            }
            if(isset($table->columns['width'])) {
                $this->alterColumn('image','width', $this->integer(5));
            }
            if(isset($table->columns['urlstorthumbnail'])) {
                $this->alterColumn('image','urlstorthumbnail', $this->text());
            }
            if(isset($table->columns['urloriginalbilde'])) {
                $this->alterColumn('image','urloriginalbilde', $this->text());
            }
        }

        $table = $this->db->getTableSchema('news', true);
        if (!$table) {
            echo "Table news does not exist \n";
        }else{
            if(isset($table->columns['show_img'])) {
                $this->alterColumn('news','show_img', $this->boolean());
            }
        }

        $table = $this->db->getTableSchema('percent_text', true);
        if (!$table) {
            echo "Table percent_text does not exist \n";
        }else{
            if(isset($table->columns['number'])) {
                $this->alterColumn('percent_text','number', $this->integer(3));
            }
        }

        $table = $this->db->getTableSchema('properties_events', true);
        if (!$table) {
            echo "Table properties_events does not exist \n";
        }else{
            if(isset($table->columns['event_id'])) {
                $this->alterColumn('properties_events','event_id', $this->integer(3));
            }
        }

        $table = $this->db->getTableSchema('property_details', true);
        if (!$table) {
            echo "Table property_details does not exist \n";
        }else{
            if(isset($table->columns['statusdato'])) {
                $this->dropColumn('property_details','statusdato');
            }

            if(isset($table->columns['arkivert'])) {
                $this->alterColumn('property_details','arkivert', $this->integer(1));
            }

            if(isset($table->columns['markedsforingsdato'])) {
                $this->alterColumn('property_details','markedsforingsdato', $this->integer(10)->unsigned());
            }

            if(isset($table->columns['trukket'])) {
                $this->alterColumn('property_details','trukket', $this->integer(1));
            }
        }

        $table = $this->db->getTableSchema('user', true);
        if (!$table) {
            echo "Table 'user' does not exist \n";
        }else{
            if(isset($table->columns['standardbildefil'])) {
                $this->dropColumn('user','standardbildefil');
            }
            if(isset($table->columns['allowed_deprtment'])) {
                $this->dropColumn('user','allowed_deprtment');
            }
            if(isset($table->columns['allowed_deprtment_title'])) {
                $this->dropColumn('user','allowed_deprtment_title');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = $this->db->getTableSchema('all_post_number', true);
        if (!$table) {
            echo "Table all_post_number does not exist \n";
        }else{
            if(isset($table->columns['post_number'])) {
                $this->renameColumn('all_post_number','post_number', 'index');
            }
        }

        $table = $this->db->getTableSchema('client', true);
        if (!$table) {
            echo "Table client does not exist \n";
        }else{
            if(isset($table->columns['blocked'])) {
                $this->renameColumn('client','blocked', 'bloked');
                $this->alterColumn('client','bloked', $this->tinyInteger(1));
            }
        }

        $table = $this->db->getTableSchema('boligvarsling', true);
        if (!$table) {
            echo "Table 'boligvarsling' does not exist \n";
        }else{
            $this->renameTable('boligvarsling','dwelling_forms');
        }

        $table = $this->db->getTableSchema('filter_notification', true);
        if (!$table) {
            echo "Table filter_notification does not exist \n";
        }else{
            echo "Cant create table filter_notification you must create it manually";
        }

        $table = $this->db->getTableSchema('forms', true);
        if (!$table) {
            echo "Table forms does not exist \n";
        }else{
            if(!isset($table->columns['surname'])) {
                $this->addColumn('forms','surname', $this->string());
            }
            if(!isset($table->columns['advice_to_email'])) {
                $this->addColumn('forms','advice_to_email', $this->boolean());
            }

            if(!isset($table->columns['employee_web_id'])) {
                $this->addColumn('forms','employee_web_id', $this->string());
            }
            if(!isset($table->columns['employee_phone'])) {
                $this->addColumn('forms','employee_phone', $this->string());
            }
            if(!isset($table->columns['area_range'])) {
                $this->addColumn('forms','area_range', $this->string());
            }


        }

        $table = $this->db->getTableSchema('image', true);
        if (!$table) {
            echo "Table image does not exist \n";
        }else{
            if(!isset($table->columns['storthumbnailfil'])) {
                $this->addColumn('image','storthumbnailfil', $this->string());
            }
            if(!isset($table->columns['originalbildefil'])) {
                $this->addColumn('image','originalbildefil', $this->string());
            }

            if(isset($table->columns['height'])) {
                $this->alterColumn('image','height', $this->string());
            }
            if(isset($table->columns['width'])) {
                $this->alterColumn('image','width', $this->string());
            }
            if(isset($table->columns['urlstorthumbnail'])) {
                $this->alterColumn('image','urlstorthumbnail', $this->string());
            }
            if(isset($table->columns['urloriginalbilde'])) {
                $this->alterColumn('image','urloriginalbilde', $this->string());
            }
        }

        $table = $this->db->getTableSchema('news', true);
        if (!$table) {
            echo "Table 'news' does not exist \n";
        }else{
            if(isset($table->columns['show_img'])) {
                $this->alterColumn('news','show_img', $this->integer(11));
            }
        }

        $table = $this->db->getTableSchema('percent_text', true);
        if (!$table) {
            echo "Table percent_text does not exist \n";
        }else{
            if(isset($table->columns['number'])) {
                $this->alterColumn('percent_text','number', $this->integer(11));
            }
        }

        $table = $this->db->getTableSchema('properties_events', true);
        if (!$table) {
            echo "Table properties_events does not exist \n";
        }else{
            if(isset($table->columns['event_id'])) {
                $this->alterColumn('properties_events','event_id', $this->integer(11));
            }
        }

        $table = $this->db->getTableSchema('property_details', true);
        if (!$table) {
            echo "Table property_details does not exist \n";
        }else{
            if(!isset($table->columns['statusdato'])) {
                $this->addColumn('property_details','statusdato', $this->string());
            }

            if(!isset($table->columns['arkivert'])) {
                $this->addColumn('property_details','arkivert', $this->integer(4));
            }

            if(!isset($table->columns['markedsforingsdato'])) {
                $this->addColumn('property_details','markedsforingsdato', $this->integer(11));
            }

            if(!isset($table->columns['trukket'])) {
                $this->addColumn('property_details','trukket', $this->integer(4));
            }
        }


        $table = $this->db->getTableSchema('user', true);
        if (!$table) {
            echo "Table user does not exist \n";
        }else{
            if(!isset($table->columns['standardbildefil'])) {
                $this->addColumn('user','standardbildefil', $this->string());
            }
            if(!isset($table->columns['allowed_deprtment'])) {
                $this->addColumn('user','allowed_deprtment', $this->string());
            }
            if(!isset($table->columns['allowed_deprtment_title'])) {
                $this->addColumn('user','allowed_deprtment_title', $this->string());
            }
        }

    }//


}
