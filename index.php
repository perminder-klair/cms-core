<?php
date_default_timezone_set('UTC');
//ini_set("memory_limit","128M");

$extension = pathinfo($_SERVER['SERVER_NAME'], PATHINFO_EXTENSION);

// change the following paths if necessary
if(($extension == "dev") || (!$extension)) {
	$yii=dirname(__FILE__).'/../../yii/framework/yii.php';
	$config=dirname(__FILE__).'/protected/config/dev.php';
	defined('YII_DEBUG') or define('YII_DEBUG',true);
} else {
	$yii=dirname(__FILE__).'/../../../yii/framework/yii.php';
	$config=dirname(__FILE__).'/protected/config/web.php';
}

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();