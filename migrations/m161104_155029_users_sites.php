<?php

use yii\db\Migration;

class m161104_155029_users_sites extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users_sites', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(20)->notNull(),
            'domain' => $this->string(255)->unique()->notNull(),
            'ip_address' => $this->string(255)->notNull(),
            'is_active' => $this->smallInteger(2)->defaultValue(1),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);

        $this->addForeignKey('fk-users_sites_users', 'users_sites', 'user_id', 'users', 'id', 'CASCADE');
    }

    public function down()
    {
        echo "m161104_155029_users_sites cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
