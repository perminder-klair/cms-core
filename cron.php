<?php
date_default_timezone_set('UTC');

defined('YII_DEBUG') or define('YII_DEBUG',true);
 
// include Yii
$yii=dirname(__FILE__).'/vendor/yiisoft/yii/framework/yii.php';
require_once($yii);
 
// we'll use a separate config file
$configFile=dirname(__FILE__).'/protected/config/console.php';
 
// creating and running console application
Yii::createConsoleApplication($configFile)->run();