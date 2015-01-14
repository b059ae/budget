<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\behaviors\ModelAttributeBehavior;
use yii\db\Expression;
use app\models\AccountsUsers;

/**
 * This is the model class for table "operations".
 *
 * @property integer $id
 * @property string $comment
 * @property integer $sum
 * @property integer $account_id
 * @property integer $transaction_id
 * @property string $date_created
 * @property string $date_updated
 * @property integer $deleted
 *
 * @property Accounts $account
 */
class Operations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'operations';
    }

    public static function find() {
        return parent::find()->onCondition(self::tableName() . '.deleted = 0 AND ' . self::tableName() . '.account_id IN (SELECT account_id FROM ' . AccountsUsers::tableName() . ' au WHERE au.deleted=0 AND au.active=1 AND au.user_id=' . Yii::$app->user->id . ')')/* ->addOrderBy('id asc') */;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sum', 'account_id', 'transaction_id', 'deleted'], 'integer'],
            [['account_id'], 'required'],
            [['date_created', 'date_updated'], 'safe'],
            [['comment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'comment' => Yii::t('app', 'Комментарий'),
            'sum' => Yii::t('app', 'Сумма'),
            'account_id' => Yii::t('app', 'Счёт'),
            'transaction_id' => Yii::t('app', 'Transaction ID'),
            'date_created' => Yii::t('app', 'Дата'),
            'date_updated' => Yii::t('app', 'Date Updated'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Accounts::className(), ['id' => 'account_id']);
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
            'accounts' => [
                'class'      => ModelAttributeBehavior::className(),
                'model'      => function () {
                    return Accounts::findOne($this->account_id);
                },
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_INSERT => ['sum'],
                    ActiveRecord::EVENT_AFTER_UPDATE => ['sum'],
                ],
                'value'      => function ($event) {
                    return [
                        'sum' => Operations::find()->where(['account_id'=>$this->account_id])->sum('sum'),
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
