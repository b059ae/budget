<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;

NavBar::begin([
    'brandLabel' => Yii::$app->id,
    'brandUrl'   => Yii::$app->homeUrl,
    'options'    => [
        'class' => 'navbar-inverse navbar-fixed-top',
        'tag'   => 'div',
    ],
]);

if (!Yii::$app->user->isGuest) {
    $typesAdd  = [];
    $typesView = [['label' => 'Все', 'url'   => ['/conts/index']], ['label' => 'Черный список', 'url'   => Url::toRoute(['/conts/index','ContsSearchForm[blacklist]'=>1])], '<li class="divider"></li>'];
    foreach (\app\models\base\Conts::getTypesArray() as $id => $type) {
        $typesAdd[]  = ['label' => $type, 'url'   => Url::toRoute(['/conts/create', 'type_id' => $id])];
        $typesView[] = ['label' => $type, 'url'   => Url::toRoute(['/conts/index', 'ContsSearchForm[type_id]' => $id])];
    }

    $nav = [
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items'   => [
            ['label'  => '<span class="glyphicon glyphicon-plus"></span> Добавить', 'items'  => $typesAdd, 'encode' => false],
            ['label'  => '<span class="glyphicon glyphicon-list-alt"></span> Список', 'items'  => $typesView, 'encode' => false],
        ],
    ];

    $nav['items'][] = ['label'       => 'Выход (' . Yii::$app->user->identity->username . ')',
        'url'         => Url::toRoute('/auth/logout'),
        'linkOptions' => ['data-method' => 'post']];
    echo Nav::widget($nav);
}

NavBar::end();
?>