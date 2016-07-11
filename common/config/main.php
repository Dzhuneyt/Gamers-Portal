<?php
return [
    'name'=>'Latest games',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'imageUploader' => [
            'class' => 'common\components\ImageUploader',
            'mashapeKey'=>'',
            'imgurClientId'=>'XXXXXX', // don't prefix with "Client-ID "
        ]
    ],
];
