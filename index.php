<?php
date_default_timezone_set('UTC');
//ini_set("memory_limit","128M");

$extension = pathinfo($_SERVER['SERVER_NAME'], PATHINFO_EXTENSION);

// change the following paths if necessary
if(($extension == "dev") || (!$extension))
	$yii=dirname(__FILE__).'/../../yii/framework/yii.php';
else
	$yii=dirname(__FILE__).'/../../../yii/framework/yii.php';

if(($extension == "dev") || (!$extension))
	$config=dirname(__FILE__).'/protected/config/dev.php';
else
	$config=dirname(__FILE__).'/protected/config/web.php';

// remove the following lines when in production mode
if(($extension == "dev") || (!$extension))
	defined('YII_DEBUG') or define('YII_DEBUG',true);

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
