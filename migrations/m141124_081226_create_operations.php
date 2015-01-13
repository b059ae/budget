<?php

use yii\db\Schema;
use yii\db\Migration;

class m141124_081226_create_operations extends Migration {

    public function safeUp() {
        $this->createTable('operations', [
            'id'             => Schema::TYPE_PK,
            'comment'        => Schema::TYPE_STRING . ' DEFAULT NULL COMMENT "Комментарий операции"',
            'sum'            => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0 COMMENT "Сумма операции, может быть отрицательной"',
            'account_id'     => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "ID счета из таблицы accounts"',
            'transaction_id' => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "ID транзакции, служит для удаления всех операция, выполненных в одной транзакции"',
            'date_created'   => Schema::TYPE_DATETIME . ' DEFAULT NULL COMMENT "Дата создания"',
            'date_updated'   => Schema::TYPE_DATETIME . ' DEFAULT NULL COMMENT "Дата изменения"',
            'deleted'        => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0 COMMENT "Отметка об удалении"',
        ],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        //groups
        $this->createIndex('idx_operations_account_id', 'operations', 'account_id');
        $this->addForeignKey('fk_operations_account_id', 'operations', 'account_id', 'accounts', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown() {
        $this->dropTable('operations');
    }

}
