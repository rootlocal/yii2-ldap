<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

defined('BASE_PATH') or define('BASE_PATH', dirname(dirname(dirname(__DIR__))));

require(BASE_PATH . '/vendor/autoload.php');
require(dirname(dirname(__DIR__)) . '/YiiCommon.php');