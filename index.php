<?php

function get_domain($url)
{
    $pieces = parse_url($url);
    $domain = isset($pieces['host']) ? $pieces['host'] : '';
    if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
    }
    return false;
}
$domainName = get_domain('http://'.$_SERVER['HTTP_HOST']);

date_default_timezone_set('UTC');
//ini_set("memory_limit","128M");

$extension = pathinfo($_SERVER['SERVER_NAME'], PATHINFO_EXTENSION);

$yii=dirname(__FILE__).'/vendor/yiisoft/yii/framework/yii.php';

// change the following paths if necessary
if(($extension == "dev") || (!$extension)) {

    $config=dirname(__FILE__).'/protected/config/dev.php';
    defined('YII_DEBUG') or define('YII_DEBUG',true);

} elseif(($domainName == "frbit.net")) {

    $config=dirname(__FILE__).'/protected/config/beta.php';

} else {

    $config=dirname(__FILE__).'/protected/config/web.php';

}

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();