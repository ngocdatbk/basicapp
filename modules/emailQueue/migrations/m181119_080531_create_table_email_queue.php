<?php

use yii\db\Migration;

/**
 * Class m181119_080531_create_table_email_queue
 */
class m181119_080531_create_table_email_queue extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('email_queue', [
            'id' => $this->integer(11)->unsigned() . ' AUTO_INCREMENT PRIMARY KEY',
            'from' => $this->string(255)->notNull(),
            'to' => $this->string(255)->notNull(),
            'subject' => $this->string(255)->notNull(),
            'module_id' => $this->string(255)->null(),
            'content_id' => $this->string(255)->notNull(),
            'extra_data' => 'BLOB',
            'created_date' => $this->integer(11)->notNull(),
            'status' => $this->tinyInteger(1)->defaultValue(0)->null(),
        ],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('email_queue');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181119_080531_create_table_email_queue cannot be reverted.\n";

        return false;
    }
    */
}
