<?php

use yii\db\Migration;

/**
 * Handles the creation of table `services`.
 */
class m161104_161315_create_services_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('services', [
            'id' => $this->primaryKey(),
            'type' => $this->string(250)->unique()->notNull(),
            'worth' => $this->double(2)->defaultValue(0),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('services');
    }
}
