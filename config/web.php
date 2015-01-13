<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'Бюджет',
    'language'   => 'ru-RU',
    'charset'    => 'UTF-8',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '<_c:[\w\-]+>/<id:\d+>'              => '<_c>/view',
                '<_c:[\w\-]+>'                       => '<_c>/index',
                '<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_c>/<_a>',
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '5hOsCXbd7ki1zJTRdmGJqd3ftU8UfaOG',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass'   => 'app\models\Users',
            'enableAutoLogin' => false,
            'loginUrl'        => '/auth/login',
        ],
        'authManager'  => [
            'class' => 'yii\rbac\PhpManager',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'formatter'    => [
            'dateFormat'        => 'php:d.m.Y',
            'timeFormat'        => 'php:H:i:s',
            'datetimeFormat'    => 'php:d.m.Y H:i',
            'decimalSeparator'  => '.',
            'thousandSeparator' => '&nbsp;',
            'nullDisplay'       => '',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'i18n'         => array(
            'translations' => array(
                '*' => array(
                    'class'          => 'yii\i18n\PhpMessageSource',
                    'basePath'       => '@app/messages',
                    'sourceLanguage' => 'en_US',
                    'fileMap'        => array(
                        'enum' => 'enum.php',
                    ),
                )
            ),
        ),
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
        'generators' => [
            'model' => [
                'class'     => 'yii\gii\generators\model\Generator',
                'templates' => ['ext_default_scope' => '@app/gii/templates/model/ext_default_scope']
            ]
        ]
    ];
}

return $config;
