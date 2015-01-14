<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "accounts_users".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $account_id
 * @property string $date_created
 * @property string $date_updated
 * @property integer $active
 * @property integer $deleted
 *
 * @property Accounts $account
 * @property Users $user
 */
class AccountsUsers extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'accounts_users';
    }

    public static function find() {
        return parent::find()->onCondition(self::tableName() . '.deleted = 0')/* ->addOrderBy('id asc') */;
    }
    
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'account_id'], 'required'],
            [['user_id', 'account_id', 'active', 'deleted'], 'integer'],
            [['date_created', 'date_updated'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id'           => Yii::t('app', 'ID'),
            'user_id'      => Yii::t('app', 'User ID'),
            'account_id'   => Yii::t('app', 'Account ID'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
            'active'       => Yii::t('app', 'Active'),
            'deleted'      => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount() {
        return $this->hasOne(Accounts::className(), ['id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
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
