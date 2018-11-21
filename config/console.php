<?php
$params = require __DIR__ . '/params.php';
$modules = require(__DIR__ . '/modules.php');
$components = require(__DIR__ . '/components.php');
$db = require(__DIR__ . '/db.php');


$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'vi_VN',
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'settings' => [
            'class' => 'app\modules\setting\components\Settings',
        ],
        'mailer_marketing' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['noreply@site.com' => 'Saotruc.vn'],
            ],
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'donaldclintonbjj@gmail.com',
                'password' => 'dat@06101989',
                'port' => '465',
                'encryption' => 'ssl',
            ],
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.mailtrap.io',
//                'username' => 'ed03c14b61ab3b',
//                'password' => '3170b21bdd591e',
//                'port' => '2525',
//                'encryption' => '',
//            ],
        ],
        'mailer_test' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['noreply@site.com' => 'Saotruc.vn'],
            ],
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'tcvremote@gmail.com',
                'password' => 'dat@06101989',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:j M Y',
            'datetimeFormat' => 'php:j M Y H:i',
            'timeFormat' => 'php:H:i',
            'timeZone' => 'Asia/Ho_Chi_Minh',
        ],
//        'errorLog' => [
//            'class' => 'app\modules\errorLog\components\ErrorLog'
//        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl'=> '/',
            'hostInfo' => 'http://saotruc.com'
//            'rules' => [],
        ],
        'i18n' => [
            'translations' => [
                'app.*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en_US',
                ],
            ],
        ],
        'dataRegistry' => [
            'class' => 'app\modules\core\components\DataRegistry',
        ]
    ],
    'params' => $params,
    'modules' => $modules,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
