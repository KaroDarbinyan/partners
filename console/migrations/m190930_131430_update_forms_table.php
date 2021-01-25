<?php

use common\models\Forms;
use yii\db\Migration;
use yii\helpers\ArrayHelper;

/**
 * Class m190930_131430_update_forms_table
 */
class m190930_131430_update_forms_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $forms = Forms::find()
            ->select(['id', 'source'])
            ->where(['not', ['source' => null]])->all();

        foreach ($forms as $form){
            $form->referer_source = $form->source;
            print_r(ArrayHelper::toArray($form));
            $form->save(false);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190930_131430_update_forms_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190930_131430_update_forms_table cannot be reverted.\n";

        return false;
    }
    */
}
