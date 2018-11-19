<?php

use yii\db\Migration;

/**
 * Class m181119_080322_create_table_product_image
 */
class m181119_080322_create_table_product_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_image', [
            'id' => $this->integer(11)->unsigned() . ' AUTO_INCREMENT PRIMARY KEY',
            'product_id' => $this->integer(11)->notNull(),
            'image' => $this->char(100)->notNull(),
            'description' => $this->string(255)->null(),
            'is_main' => $this->tinyInteger(1)->defaultValue(0)->null(),
        ],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product_image');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181119_080322_create_table_product_image cannot be reverted.\n";

        return false;
    }
    */
}
