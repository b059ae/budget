<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Operations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operations-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?=
        Html::a(Yii::t('app', 'Create {modelClass}', [
                    'modelClass' => 'Operations',
                ]), ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',

            [
                'attribute' => 'account_id',
                'value'     => function($model) {
                    return $model->account->name;
                },
            ],
            'comment',
            [
                'format'    => 'raw',
                'attribute' => 'sum',
                'value'     => function ($model) {
                    return '<span class="label label-' . ($model->sum > 0 ? 'success' : 'danger') . '">' . $model->sum . '</span>';
                }
            ],
            //'transaction_id',
            // 'date_created',
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
            ],
        ],
    ]);
    ?>

</div>
