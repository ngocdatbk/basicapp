<?php

use yii\db\Migration;

/**
 * Class m181119_080630_create_table_cronjob_log
 */
class m181119_080630_create_table_cronjob_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cronjob_log', [
            'cronjob_id' => $this->char(50)->notNull(),
            'execution_time' => $this->integer(10)->notNull(),
            'status' => $this->string(255)->notNull(),
        ],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cronjob_log');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181119_080630_create_table_cronjob_log cannot be reverted.\n";

        return false;
    }
    */
}
