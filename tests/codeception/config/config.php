<?php
/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'image-test',
    'basePath' => dirname(dirname(__DIR__)), // @tests
    'vendorPath' => dirname(dirname(dirname(__DIR__))) . '/vendor',
    'language' => 'en-US',
    'aliases' => [
    ],
    'modules' => [
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => '\yii\console\controllers\FixtureController',
            'namespace' => '\tests\codeception\fixtures',
        ],
    ],
    'components' => [
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'cache' => [
            'class' => '\yii\caching\DummyCache',
        ],
        'ldap' => [
            'class' => '\rootlocal\Ldap',
        ],
    ],
];
