<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m200609_060002_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'author_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-book-author_id',
            'books',
            'author_id',
            'authors',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'fk-book-author_id',
            'books'
        );

        $this->dropTable('{{%books}}');
    }
}
