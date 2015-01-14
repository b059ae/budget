<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Operations */

$this->title = Yii::t('app', 'Изменить {modelClass}: ', [
    'modelClass' => 'операцию',
]) . ' ' . $model->comment;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Operations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="operations-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
