<?php

use yii\db\Migration;

/**
 * Class m180128_074443_authors
 */
class m180128_074443_authors extends Migration
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

        $this->createTable('{{%authors}}', [
            'id'        => $this->primaryKey()->unsigned(),
            'firstname' => $this->string(),
            'lastname'  => $this->string(),

        ], $tableOptions);


    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%authors}}');
    }


}
