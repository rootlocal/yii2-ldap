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
            'class' => 'rootlocal\ldap\Ldap',
            'domain_controllers' => ['localhost'],
            'base_dn' => 'dc=example,dc=com',
            'admin_username' => 'cn=admin,dc=example,dc=com',
            'admin_password' => 'test',
            'port' => 3389,
        ],
    ],
];
