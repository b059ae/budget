<?
use yii\helpers\Url;
?>
<h4><a href="<?=Url::toRoute(['/accounts/view', 'id' => $model['id']])?>"><?=$model['name']?></a></h4>
<p>Остаток: <?=$model['sum'];?></p>