<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Счета');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?=
        Html::a(Yii::t('app', 'Добавить {modelClass}', [
                    'modelClass' => 'счёт',
                ]), ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>
    <?
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'layout'       => '{items}{pager}',
        'itemView'     => '_item',
        'itemOptions'  => [
            'class' => 'col-lg-3 panel panel-primary',
            'tag'   => 'article'
        ],
        'options'      => [
            'class' => 'row',
        ]
    ]);
    ?>
</div>
