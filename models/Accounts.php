<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use app\behaviors\ModelAttributeBehavior;
use yii\db\Expression;
use app\models\AccountsUsers;

/**
 * This is the model class for table "accounts".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sum
 * @property integer $user_id
 * @property string $date_created
 * @property string $date_updated
 * @property integer $deleted
 *
 * @property Users $user
 * @property AccountsUsers[] $accountsUsers
 * @property Operations[] $operations
 */
class Accounts extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'accounts';
    }

    public static function find() {
        return parent::find()->onCondition(self::tableName() . '.deleted = 0 AND ' . self::tableName() . '.id IN (SELECT account_id FROM ' . AccountsUsers::tableName() . ' au WHERE au.deleted=0 AND au.active=1 AND au.user_id=' . Yii::$app->user->id . ')')/* ->addOrderBy('id asc') */;
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'user_id'], 'required'],
            [['sum', 'user_id', 'deleted'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id'           => Yii::t('app', 'ID'),
            'name'         => Yii::t('app', 'Название'),
            'sum'          => Yii::t('app', 'Остаток'),
            'user_id'      => Yii::t('app', 'User ID'),
            'date_created' => Yii::t('app', 'Дата создания'),
            'date_updated' => Yii::t('app', 'Date Updated'),
            'deleted'      => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountsUsers() {
        return $this->hasMany(AccountsUsers::className(), ['account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperations() {
        return $this->hasMany(Operations::className(), ['account_id' => 'id']);
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class'      => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_created'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_updated']
                ],
                'value'      => new Expression('NOW()'),
            ],
            'user'      => [
                'class'      => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_VALIDATE => ['user_id'],
                ],
                'value'      => function ($event) {
                    return $this->user_id? : Yii::$app->user->id;
                },
            ],
            'accountsUsers' => [
                'class'      => ModelAttributeBehavior::className(),
                'model'      => new AccountsUsers,
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_INSERT => ['account_id', 'user_id', 'active'],
                ],
                'value'      => function ($event) {
                    return [
                        'account_id' => $this->id,
                        'user_id'    => $this->user_id? : Yii::$app->user->id,
                        'active'     => 1,
                    ];
                },
            ],
        ];
    }

    /**
     * Вместо удаления ставим признак deleted=1
     */
    public function delete() {
        $this->deleted = 1;
        $this->save();
    }

}
