<?php

use yii\db\Schema;
use yii\db\Migration;

class m141124_081225_create_accounts_users extends Migration {

    public function safeUp() {
        $this->createTable('accounts_users', [
            'id'           => Schema::TYPE_PK,
            'user_id'      => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "ID пользователя из таблицы users"',
            'account_id'     => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "ID группы из таблицы accounts"',
            'date_created' => Schema::TYPE_DATETIME . ' DEFAULT NULL COMMENT "Дата создания"',
            'date_updated' => Schema::TYPE_DATETIME . ' DEFAULT NULL COMMENT "Дата изменения"',
            'active'      => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0 COMMENT "Отметка об активности"',
            'deleted'      => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0 COMMENT "Отметка об удалении"',
        ]);
        //users
        $this->createIndex('idx_accounts_users_user_id', 'accounts_users', 'user_id');
        $this->addForeignKey('fk_accounts_users_user_id', 'accounts_users', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        //accounts
        $this->createIndex('idx_accounts_users_account_id', 'accounts_users', 'account_id');
        $this->addForeignKey('fk_accounts_users_account_id', 'accounts_users', 'account_id', 'accounts', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown() {
        $this->dropTable('accounts_users');
    }

}