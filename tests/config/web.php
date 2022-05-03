<?php
return [
    'id' => 'app',
    'name' => 'Site',
    'components' => [

        'urlManager' => [
            'showScriptName' => true,
        ],

        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],

        'request' => [
            'cookieValidationKey' => 'test',
        ],
    ]
];
