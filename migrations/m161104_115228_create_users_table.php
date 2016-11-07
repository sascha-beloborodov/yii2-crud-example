<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m161104_115228_create_users_table extends Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string(150)->unique()->notNull(),
            'first_name' => $this->string(150)->notNull(),
            'last_name' => $this->string(150)->notNull(),
            'email' => $this->string(150)->unique()->notNull(),
            'password' => $this->string(150)->notNull(),
            'auth_key' => $this->string(255)->null(),
            'access_token' => $this->string(255)->null(),
            'role' => $this->smallInteger(2),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
