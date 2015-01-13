<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class SiteController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','import'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                    [
                        'actions' => ['error'],
                        'allow'   => true,
                    ],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionImport() {
        echo 'disabled web@yugrusiagro.ru';
        /*var_dump(Yii::$app->get('dbcontractor')->createCommand('SELECT * FROM anketa LIMIT 10')->queryAll());
                die();*/
        $m = new \app\models\external\Contractor();
//        $m->truncateContractors();
        $m->importContractors();
    }

}
