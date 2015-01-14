<?

use yii\helpers\Url;
?>


<div class = "panel panel-default">
    <a href="<?= Url::toRoute(['/accounts/view', 'id' => $model['id']]) ?>">
        <h1><?= $model['sum']; ?></h1>
        <h5><?= $model['name'] ?></h5>
    </a>
</div>
