<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users_sites_services`.
 */
class m161104_161935_create_users_sites_services_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users_sites_services', [
            'users_sites_id' => $this->integer(20)->notNull(),
            'services_id' => $this->integer(20)->notNull(),
        ]);

        $this->createIndex('fk-users_sites', 'users_sites_services', 'users_sites_id');
        $this->addForeignKey(
            'fk-users_sites_services', 'users_sites_services', 'users_sites_id', 'users_sites', 'id', 'CASCADE'
        );

        $this->createIndex('fk-services', 'users_sites_services', 'services_id');
        $this->addForeignKey(
            'fk-services_users_sites', 'users_sites_services', 'services_id', 'services', 'id', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users_sites_services');
    }
}
