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
    $nav = [
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items'   => [
            ['label'  => '<span class="glyphicon glyphicon-list-alt"></span> Счета', 'url'    => Url::toRoute('/accounts'), 'encode' => false],
            ['label'  => '<span class="glyphicon glyphicon-plus"></span> Доходы', 'encode' => false],
            ['label'  => '<span class="glyphicon glyphicon-minus"></span> Расходы', 'encode' => false],
        ],
    ];

    $nav['items'][] = ['label'       => 'Выход (' . Yii::$app->user->identity->username . ')',
        'url'         => Url::toRoute('/auth/logout'),
        'linkOptions' => ['data-method' => 'post']];
    echo Nav::widget($nav);
}

NavBar::end();
?>