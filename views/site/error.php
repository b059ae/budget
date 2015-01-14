<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Если вы считаете, что это ошибка сервера, то, пожалуйста, сообщите о ней на почту <a href="mailto:<?=Yii::$app->params['adminEmail']?>"><?=Yii::$app->params['adminEmail']?></a>
    </p>

</div>
