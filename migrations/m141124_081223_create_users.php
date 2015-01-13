<?php

use yii\db\Schema;
use yii\db\Migration;

class m141124_081223_create_users extends Migration {

    public function safeUp() {
        $this->createTable('users', [
            'id'           => Schema::TYPE_PK,
            'username'     => Schema::TYPE_STRING . ' NOT NULL COMMENT "Логин"',
            'password'     => Schema::TYPE_STRING . ' NOT NULL COMMENT "Хэш пароля"',
            'name'         => Schema::TYPE_STRING . ' NOT NULL COMMENT "Имя"',
            'email'        => Schema::TYPE_STRING . ' NOT NULL COMMENT "Email"',
            'date_created' => Schema::TYPE_DATETIME . ' DEFAULT NULL COMMENT "Дата создания"',
            'date_updated' => Schema::TYPE_DATETIME . ' DEFAULT NULL COMMENT "Дата изменения"',
            'deleted'      => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0 COMMENT "Отметка об удалении"',
        ],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->execute("INSERT INTO users (id, username, password, name, email, date_created) VALUES (1, 'shad3', '".md5('123321'.Yii::$app->params['salt'])."', 'Александр', 'b059ae@gmail.com', NOW())");
        $this->execute("INSERT INTO users (id, username, password, name, email, date_created) VALUES (2, 'sweety', '".md5('123321'.Yii::$app->params['salt'])."', 'Света', 'sweety63@rambler.ru', NOW())");
    }

    public function safeDown() {
        $this->dropTable('users');
    }

}