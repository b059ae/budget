<?php

namespace app\models;

use Yii;
use app\helpers\StringHelper;

class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    public $authKey;
    public $accessToken;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'users';
    }

    public static function primaryKey() {
        return array('id');
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return $this->hashPassword($password, $this->username) === $this->hash;
    }

    protected function hashPassword($password, $username) {
        return md5($password.Yii::$app->params['salt']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'name', 'email'], 'required'],
            [['date_created', 'date_updated'], 'safe'],
            [['deleted'], 'integer'],
            [['username', 'password', 'name', 'email'], 'string', 'max' => 255]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Пользователь'),
            'password' => Yii::t('app', 'Пароль'),
            'name' => Yii::t('app', 'Имя'),
            'email' => Yii::t('app', 'Email'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(Accounts::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountsUsers()
    {
        return $this->hasMany(AccountsUsers::className(), ['user_id' => 'id']);
    }

}
