<?php

use yii\db\Migration;

/**
 * Class m181119_080349_create_table_order
 */
class m181119_080349_create_table_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id' => $this->integer(11)->unsigned() . ' AUTO_INCREMENT PRIMARY KEY',
            'user_order_name' => $this->string(50)->notNull(),
            'user_order_phone' => $this->char(20)->notNull(),
            'user_order_email' => $this->string(50)->null(),
            'user_receive_name' => $this->string(50)->null(),
            'user_receive_phone' => $this->char(20)->null(),
            'user_receive_email' => $this->string(50)->null(),
            'user_receive_address' => $this->string(255)->notNull(),
            'order_time' => $this->integer(11)->notNull(),
            'user_note' => $this->string(255)->null(),
            'total' => $this->integer(11)->notNull(),
            'status' => $this->tinyInteger(3)->defaultValue(0)->notNull(),
            'admin_note' => $this->string(255)->null(),
            'deleted_f' => $this->tinyInteger(1)->defaultValue(0)->notNull(),
        ],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181119_080349_create_table_order cannot be reverted.\n";

        return false;
    }
    */
}
