<?php

use yii\db\Migration;

/**
 * Class m181119_165927_create_table_setting_section
 */
class m181119_165927_create_table_setting_section extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('setting_section', [
            'id' => $this->integer(11)->unsigned() . ' AUTO_INCREMENT PRIMARY KEY',
            'name' => $this->string(50)->notNull(),
            'description' => $this->string(255)->null(),
        ],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('setting_section');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181119_165927_create_table_setting_section cannot be reverted.\n";

        return false;
    }
    */
}
