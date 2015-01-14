<?php

namespace app\controllers;

use Yii;
use app\models\Operations;
use app\models\Accounts;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\AccessControl;

/**
 * OperationsController implements the CRUD actions for Operations model.
 */
class OperationsController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Operations models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Operations::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIncome() {
        $dataProvider = new ActiveDataProvider([
            'query' => Operations::find()->where(['sum>0'])->joinWith('accounts'),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Operations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        /* if (!Accounts::find()->where([ 'id' => $account_id])->exists())
          throw new NotFoundHttpException(Yii::t('app', 'Счет не найден.')); */


        $model             = new Operations();
        $model->account_id = Yii::$app->request->getQueryParam('account_id');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['accounts/view', 'id' => $model->account_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Operations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['accounts/view', 'id' => $model->account_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Operations model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model      = $this->findModel($id);
        $account_id = $model->account_id;
        $model->delete();

        return $this->redirect(['accounts/view', 'id' => $account_id]);
    }

    /**
     * Finds the Operations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Operations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Operations::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
