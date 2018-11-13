<?php
return [
    'request' => [
        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
        'cookieValidationKey' => 'XyW3bLr9k1gc3B4uhKzj3SDa-72S-gf8',
    ],
    'cache' => [
        'class' => 'yii\caching\FileCache',
    ],
    'user' => [
        'identityClass' => 'app\models\User',
        'enableAutoLogin' => true,
    ],
    'errorHandler' => [
        'errorAction' => 'site/error',
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
