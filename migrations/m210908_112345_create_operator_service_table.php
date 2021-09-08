<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%operator_service}}`.
 */
class m210908_112345_create_operator_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%operator_service}}', [
            'id' => $this->primaryKey(),
            'operator_id' => $this->integer()->notNull(),
            'service_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-operator_service-operator_id-operator-id',
            'operator_service',
            'operator_id',
            'operator',
            'id',
            'CASCADE',
        );

        $this->addForeignKey(
            'fk-operator_service-service_id-service-id',
            'operator_service',
            'service_id',
            'service',
            'id',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%operator_service}}');
    }
}
