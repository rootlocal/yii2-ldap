<?php
/**
 * Application configuration shared by all test types
 */

use rootlocal\ldap\Ldap;
use yii\caching\DummyCache;
use yii\console\controllers\FixtureController;
use yii\log\FileTarget;

return [
    'id' => 'test',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(__DIR__, 3) . '/vendor',
    'language' => 'en-US',

    'aliases' => [
        '@tests' => dirname(__DIR__),
        '@assets' => dirname(__DIR__) . '/web/assets',
        '@runtime' => dirname(__DIR__) . '/runtime',
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],

    'bootstrap' => [
        'log',
    ],

    'modules' => [
    ],

    'controllerMap' => [
        'fixture' => [
            'class' => FixtureController::class,
            'namespace' => '\tests\codeception\fixtures',
        ],
    ],

    'components' => [
        'cache' => [
            'class' => DummyCache::class,
        ],

        'ldap' => [
            'class' => Ldap::class,
            'hosts' => ['localhost'],
            'username' => 'cn=admin,dc=example,dc=com',
            'password' => 'test',
            'port' => 3389,
            'base_dn' => 'dc=example,dc=com',
        ],

        'log' => [
            'traceLevel' => 3,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning', 'info'],
                ],
            ],
        ],
    ],
];