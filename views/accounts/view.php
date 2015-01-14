<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\Accounts */

$this->title                   = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Accounts'), 'url'   => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-view">
    <div class="clearfix">
        <div class="pull-left">
            <h1><?= Html::encode($this->title) ?> <span class="label label-<?=($model->sum > 0 ? 'success' : 'danger')?>"><?=$model->sum?></span></h1>
        </div>
        <!--<div class="pull-right">
            <?= Yii::$app->formatter->asDatetime($model->date_created); ?>
        </div>-->
    </div>
    <p>
        <?= Html::a(Yii::t('app', 'Добавить операцию'), ['operations/create', 'account_id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Изменить счёт'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ])
        ?>
    </p>

    <?/*=
    DetailView::widget([
        'model'      => $model,
        'attributes' => [
//            'id',
            'name',
            'sum',
//            'user_id',
            'date_created:datetime',
//            'date_updated',
//            'deleted',
        ],
    ])
    */?>

    <!--    <h4>Последние 10 операций</h4>-->
    <?=
    GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query'      => $model->getOperations(),
            'sort'       => ['defaultOrder' => ['date_created' => SORT_DESC]],
            'pagination' => ['pageSize' => 10],
                ]),
        'columns'      => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            'comment',
            [
                'format'    => 'raw',
                'attribute' => 'sum',
                'value'     => function ($model) {
                    return '<span class="label label-' . ($model->sum > 0 ? 'success' : 'danger') . '">' . $model->sum . '</span>';
                }
            ],
            //'account_id',
            //'transaction_id',
            'date_created:datetime',
            // 'date_updated',
            // 'deleted',
            [
                'class'         => 'yii\grid\ActionColumn',
                'template'      => '{update} {delete}',
                'headerOptions' => [
                    'style' => 'width:50px',
                ],
                'urlCreator'    => function($action, $model, $key, $index) {
                    $params    = is_array($key) ? $key : ['id' => (string) $key];
                    $params[0] = 'operations/' . $action;

                    return Url::toRoute($params);
                },
            /* 'update' => function ($url, $model) {
              return Html::a(Yii::t('yii', 'Update'), Url::toRoute(['operations/update', 'id' => $model->id]), [
              'class' => 'btn btn-primary btn-xs',
              ]);
              }, */
            ],
        ],
    ]);
    ?>
</div>
