<?php

use yii\web\UrlNormalizer;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser'
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
//            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule','controller'=>'book-api/api'],
                [
                    'pattern' => 'book/view-popup/<id:[\d-]+>',
                    'route' => 'book/view-popup',
                ],
                [
                    'pattern' => 'book/',
                    'route' => 'book/index',
                ],
                [
                    'pattern' => 'book/create',
                    'route' => 'book/create',
                ],
                [
                    'pattern' => 'book/update/<id:[\d-]+>',
                    'route' => 'book/update',
                ],
                [
                    'pattern' => 'book/delete/<id:[\d-]+>',
                    'route' => 'book/delete',
                ],
                'PUT,PATCH book-api/api/<id>' => 'book-api/api/update',
                'DELETE book-api/api/<id>' => 'book-api/api/delete',
                'GET,HEAD book-api/api/<id>' => 'book-api/api/view',
                'POST book-api/api' => 'book-api/api/create',
                'GET,HEAD book-api/api' => 'book-api/api/index',
            ],
        ],

    ],
    'modules'=>[
        'book-api'=>[
            'class'=>'frontend\modules\BookApiModule'
        ]

    ],
    'params' => $params,
];
