<?php

use yii\db\Migration;

/**
 * Class m181119_080306_create_table_product
 */
class m181119_080306_create_table_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product', [
            'id' => $this->integer(11)->unsigned() . ' AUTO_INCREMENT PRIMARY KEY',
            'code' => $this->char(20)->notNull(),
            'name' => $this->string(255)->notNull(),
            'info' => $this->text()->null(),
            'price' => $this->integer(11)->defaultValue(0)->null(),
            'image_main' => $this->char(100)->null(),
            'category_id' => $this->integer(11)->notNull(),
            'deleted_f' => $this->tinyInteger(1)->defaultValue(0)->null(),
        ],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181119_080306_create_table_product cannot be reverted.\n";

        return false;
    }
    */
}
