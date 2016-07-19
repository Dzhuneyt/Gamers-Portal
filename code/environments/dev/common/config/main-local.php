<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=db;dbname=myapp',
            'username' => 'dev',
            'password' => '123456',
            'charset' => 'utf8',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],

        'log' => [
            'targets' => [
                'loggly' => [
                    'class' => 'spacedealer\loggly\Target',
                    'customerToken' => '13db8856-6111-4091-811e-cb17d0a738ce',
                    'levels' => ['error', 'warning', 'info', 'trace'],
                    //'tags' => ['console', 'staging'],
                    'enableIp' => false,
                    'enableTrail' => true,
                ],
            ],
        ],


    ],
];
