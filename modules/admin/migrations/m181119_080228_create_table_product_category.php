<?php

use yii\db\Migration;

/**
 * Class m181119_080228_create_table_product_category
 */
class m181119_080228_create_table_product_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_category', [
            'id' => $this->integer(11)->unsigned() . ' AUTO_INCREMENT PRIMARY KEY',
            'name' => $this->string(100)->notNull(),
            'description' => $this->text()->null(),
            'deleted_f' => $this->tinyInteger(1)->defaultValue(0)->null(),
        ],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product_category');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181119_080228_create_table_product_category cannot be reverted.\n";

        return false;
    }
    */
}
