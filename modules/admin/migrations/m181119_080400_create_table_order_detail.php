<?php

use yii\db\Migration;

/**
 * Class m181119_080400_create_table_order_detail
 */
class m181119_080400_create_table_order_detail extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order_detail', [
            'id' => $this->integer(11)->unsigned() . ' AUTO_INCREMENT PRIMARY KEY',
            'order_id' => $this->integer(11)->notNull(),
            'product_id' => $this->integer(11)->notNull(),
            'quantity' => $this->integer(11)->notNull(),
            'deleted_f' => $this->tinyInteger(1)->defaultValue(0)->null(),
        ],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order_detail');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181119_080400_create_table_order_detail cannot be reverted.\n";

        return false;
    }
    */
}
