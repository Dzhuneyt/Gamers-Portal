<?php
return [
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'loggly' => [
                    'class' => 'spacedealer\loggly\Target',
                    'customerToken' => getenv('LOGGLY_KEY') ? getenv('LOGGLY_KEY') : '13db8856-6111-4091-811e-cb17d0a738ce',
                    'levels' => ['error', 'warning'],
                    'tags' => ['console', 'staging'],
                    'enableIp' => false,
                    'enableTrail' => true,
                    'logVars' => [],
                    'prefix'=>function($message){
                        return 'games_';
                    }
                ]
            ]
        ],
    ],
];
