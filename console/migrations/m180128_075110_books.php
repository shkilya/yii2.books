<?php

use yii\db\Migration;

/**
 * Class m180128_075110_books
 */
class m180128_075110_books extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%books}}', [
            'id'          => $this->primaryKey()->unsigned(),
            'name'        => $this->string(),
            'date_create' => $this->integer()->unsigned()->notNull(),
            'date_update' => $this->integer()->unsigned()->notNull(),
            'date'        => $this->integer()->unsigned()->notNull(),
            'preview'     => $this->string()->null(),
            'author_id'   => $this->integer()->unsigned()->notNull(),

        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%books}}');
    }
}
