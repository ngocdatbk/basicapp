<?php
$params = require __DIR__ . '/params.php';
$modules = require(__DIR__ . '/modules.php');
$components = require(__DIR__ . '/components.php');

$config = [
    'id' => 'Saotruc',
    'name' => 'Saotruc',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'vi_VN',
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'defaultRoute' => 'pub/dashboard',
    'layout' => 'admin_vertical',
    'bootstrap' => ['log'],
    'components' => $components,
    'params' => $params,
    'modules' => $modules,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
