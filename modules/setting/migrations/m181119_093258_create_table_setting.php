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
            'id' => $this->integer(11)->unsigned() . ' AUTO_INCREMENT PRIMARY KEY',
            'type' => $this->string(10)->notNull(),
            'section' => $this->string(255)->notNull(),
            'key' => $this->string(255)->notNull(),
            'value' => $this->text()->notNull(),
            'status' => $this->smallInteger(6)->defaultValue(1)->notNull(),
            'description' => $this->string(255)->null(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
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
