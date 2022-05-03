<?php
/**
 * Application configuration shared by all test types
 */

use rootlocal\ldap\Ldap;

return [
    'id' => 'image-test',
    'basePath' => dirname(dirname(__DIR__)), // @tests
    'vendorPath' => dirname(dirname(dirname(__DIR__))) . '/vendor',
    'language' => 'en-US',

    'aliases' => [
        '@tests' => dirname(dirname(__DIR__)),
        '@assets' => dirname(dirname(__DIR__)) . '/web/assets',
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
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
            'class' => Ldap::class,
            'hosts' => ['localhost'],
            'username' => 'cn=admin,dc=example,dc=com',
            'password' => 'test',
            'port' => 3389,
            'base_dn' => 'dc=example,dc=com',
        ],
    ],
];
