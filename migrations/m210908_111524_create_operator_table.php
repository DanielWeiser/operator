<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%operator}}`.
 */
class m210908_111524_create_operator_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%operator}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'start_service_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%operator}}');
    }
}
