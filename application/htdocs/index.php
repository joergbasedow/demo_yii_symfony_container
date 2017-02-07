<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

// change the following paths if necessary
$yii = __DIR__.'/../vendor/yiisoft/yii/framework/yii.php';
$config = __DIR__.'/../protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

/** @noinspection PhpIncludeInspection */
require_once($yii);

// add composer auto loading
$loader = require(__DIR__.'/../vendor/autoload.php');
Yii::$classMap = $loader->getClassMap();

$app = Yii::createWebApplication($config);
$container = (new CachedContainerLoader([
    'files' => ['services'],
]))->getContainer();
$app->setComponent('container', $container);
$app->run();
