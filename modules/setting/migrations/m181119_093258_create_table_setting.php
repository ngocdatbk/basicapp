<?php

use yii\db\Migration;

/**
 * Class m181119_093258_create_table_setting
 */
class m181119_093258_create_table_setting extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('setting', [
            'key' => $this->string(255). ' PRIMARY KEY',
            'value' => $this->text()->notNull(),
            'modified' => $this->integer(11)->notNull(),
        ],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('setting');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181119_093258_create_table_setting cannot be reverted.\n";

        return false;
    }
    */
}
