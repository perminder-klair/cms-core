<?php
date_default_timezone_set('UTC');

$extension = pathinfo($_SERVER['SERVER_NAME'], PATHINFO_EXTENSION);

$yii=dirname(__FILE__).'/vendor/yiisoft/yii/framework/yii.php';

// change the following paths if necessary
if(($extension == "dev") || (!$extension)) {

    $config=dirname(__FILE__).'/protected/config/dev.php';
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_ENV') or define('YII_ENV', 'dev');

} else {

    $config=dirname(__FILE__).'/protected/config/web.php';

}

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();