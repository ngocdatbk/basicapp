<?php

use yii\db\Migration;

/**
 * Class m181119_080612_create_table_cronjob
 */
class m181119_080612_create_table_cronjob extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cronjob', [
            'id' => $this->integer(11)->unsigned() . ' AUTO_INCREMENT PRIMARY KEY',
            'cronjob_id' => $this->char(50)->notNull(),
            'name' => $this->string(100)->notNull(),
            'class' => $this->string(255)->notNull(),
            'module_id' => $this->string(50)->notNull(),
            'run_rules' => "BLOB NOT NULL",
            'last_run' => $this->integer(10)->null(),
            'next_run' => $this->integer(10)->null(),
            'is_active' => $this->tinyInteger(1)->defaultValue(1)->notNull(),
            'logging_f' => $this->tinyInteger(1)->defaultValue(1)->notNull(),
        ],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cronjob');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181119_080612_create_table_cronjob cannot be reverted.\n";

        return false;
    }
    */
}
