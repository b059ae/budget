<?php

use yii\db\Schema;
use yii\db\Migration;

class m141124_081224_create_accounts extends Migration {

    public function safeUp() {
        $this->createTable('accounts', [
            'id'           => Schema::TYPE_PK,
            'name'         => Schema::TYPE_STRING . ' NOT NULL COMMENT "Название счета"',
            'sum'          => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0 COMMENT "Текущая сумма на счете. Агрегатор из таблицы operations"',
            'user_id'      => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "ID пользователя из таблицы users, который создал счет"',
            'date_created' => Schema::TYPE_DATETIME . ' DEFAULT NULL COMMENT "Дата создания"',
            'date_updated' => Schema::TYPE_DATETIME . ' DEFAULT NULL COMMENT "Дата изменения"',
            'deleted'      => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0 COMMENT "Отметка об удалении"',
        ]);
        //users
        $this->createIndex('idx_accounts_user_id', 'accounts', 'user_id');
        $this->addForeignKey('fk_accounts_user_id', 'accounts', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown() {
        $this->dropTable('accounts');
    }

}
