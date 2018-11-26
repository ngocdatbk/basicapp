<?php
return [
    'request' => [
        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
        'cookieValidationKey' => 'XyW3bLr9k1gc3B4uhKzj3SDa-72S-gf8',
    ],
    'cache' => [
        'class' => 'yii\caching\FileCache',
    ],
    'settings' => [
        'class' => 'app\modules\setting\components\Settings',
    ],
    'authManager' => [
        'class' => 'yii\rbac\DbManager',
        // uncomment if you want to cache RBAC items hierarchy
        // 'cache' => 'cache',
    ],
    'user' => [
        'class' => 'app\modules\user\components\User',
        'loginUrl' => '/user/auth/login',
    ],
    'authClientCollection' => [
        'class' => 'yii\authclient\Collection',
        'clients' => [
            'google' => [
                'class' => 'yii\authclient\clients\Google',
                'clientId' => '101413593506-ssu4i3fil1m58c9d11g3p9rd5ggp49rc.apps.googleusercontent.com',
                'clientSecret' => 'vmB1p95Zbu0i6yigNo69FEfh',
                'returnUrl' => 'http://saotruc.com/user/auth/login-google?authclient=google'
            ],
        ],
    ],
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],
    'mailer_marketing' => [
        'class' => 'yii\swiftmailer\Mailer',
        'messageConfig' => [
            'charset' => 'UTF-8',
            'from' => ['noreply@site.com' => 'Saotruc.vn'],
        ],
        'useFileTransport' => false,
//        'transport' => [
//            'class' => 'Swift_SmtpTransport',
//            'host' => 'smtp.mailtrap.io',
//            'username' => 'ed03c14b61ab3b',
//            'password' => '3170b21bdd591e',
//            'port' => '2525',
//            'encryption' => '',
//        ],
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.gmail.com',
            'username' => 'donaldclintonbjj@gmail.com',
            'password' => 'dat@06101989',
            'port' => '465',
            'encryption' => 'ssl',
        ],
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
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['error', 'warning'],
            ],
        ],
    ],
    'db' => require(__DIR__ . '/db.php'),

    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules' => [
        ],
    ],
    'i18n' => [
        'translations' => [
            'app.*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@app/messages',
                'sourceLanguage' => 'en_US',
            ]
        ],
    ],
    'formatter' => [
        'dateFormat' => 'dd.MM.yyyy',
        'decimalSeparator' => '.',
        'thousandSeparator' => ',',
        'currencyCode' => 'VND',
        'numberFormatterOptions' => [
            NumberFormatter::MIN_FRACTION_DIGITS => 0,
            NumberFormatter::MAX_FRACTION_DIGITS => 2,
        ],
    ],
];
