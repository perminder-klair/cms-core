<?php
date_default_timezone_set('UTC');
//ini_set("memory_limit","128M");

// change the following paths if necessary
$yii=dirname(__FILE__).'/../../yii/framework/yii.php';

$extension = pathinfo($_SERVER['SERVER_NAME'], PATHINFO_EXTENSION);

if(($extension == "dev") || (!$extension))
	$config=dirname(__FILE__).'/protected/config/test.php';
else
	$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
if(($extension == "dev") || (!$extension))
	defined('YII_DEBUG') or define('YII_DEBUG',true);

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
