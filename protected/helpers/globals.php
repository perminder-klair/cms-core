<?php

/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
defined('DS') or define('DS',DIRECTORY_SEPARATOR);
 
/**
 * This is the shortcut to Yii::app()
 */
function app()
{
    return Yii::app();
}
 
/**
 * This is the shortcut to Yii::app()->setting->getValue()
 */
function gl($define)
{
	return CHtml::encode(Yii::app()->setting->getValue($define));
} 

/**
 * This is the shortcut to Yii::app()->getBaseUrl(true)
 */
function baseUrl()
{
	return Yii::app()->getBaseUrl(true);
} 
 
/**
 * This is the shortcut to Yii::app()->theme->baseUrl
 */
function themeBase()
{
	return Yii::app()->theme->baseUrl;
} 

/**
 * This is the shortcut to Yii::app()->clientScript
 */
function cs()
{
    // You could also call the client script instance via Yii::app()->clientScript
    // But this is faster
    return Yii::app()->getClientScript();
}
 
/**
 * This is the shortcut to Yii::app()->user.
 */
function user() 
{
    return Yii::app()->getUser();
}
 
/**
 * This is the shortcut to Yii::app()->user->id.
 */
function userId() 
{
    return Yii::app()->user->id;
}

/**
 * This is the shortcut to get user details.
 * user it as: userDetails()->email;
 */
function userDetails($column)
{
	return Yii::app()->user->getDetails()->$column;
}
 
/**
 * This is the shortcut to Yii::app()->user->isAdmin().
 */
function isAdmin() 
{
    return Yii::app()->user->isAdmin();
}
  
/**
 * This is the shortcut to Yii::app()->createUrl()
 */
function url($route,$params=array(),$ampersand='')
{ 
    return Yii::app()->createAbsoluteUrl($route,$params,$ampersand);
}
 
/**
 * This is the shortcut to CHtml::encode
 */
function h($text)
{
    return htmlspecialchars($text,ENT_QUOTES,Yii::app()->charset);
}
 
/**
 * This is the shortcut to CHtml::link()
 */
function l($text, $url = '#', $htmlOptions = array()) 
{
    return CHtml::link($text, $url, $htmlOptions);
}
 
/**
 * This is the shortcut to Yii::t() with default category = 'stay'
 */
function t($message, $category = 'stay', $params = array(), $source = null, $language = null) 
{
    return Yii::t($category, $message, $params, $source, $language);
}
 
/**
 * This is the shortcut to Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function bu($url=null) 
{
    static $baseUrl;
    if ($baseUrl===null)
        $baseUrl=Yii::app()->getRequest()->getBaseUrl();
    return $url===null ? $baseUrl : $baseUrl.'/'.ltrim($url,'/');
}
 
/**
 * Returns the named application parameter.
 * This is the shortcut to Yii::app()->params[$name].
 */
function param($name) 
{
    return Yii::app()->params[$name];
}

/**
 * @return string the generated image tag
*/
function i($src, $alt='', $htmlOptions=array()) {
    return CHtml::image($src, $alt, $htmlOptions);
}
 
/**
 * Dump and die - extending dump()
*/
function dd() {
    $args = func_get_args();
    foreach($args as $k => $arg){
        echo '<fieldset class="debug">
        <legend>'.($k+1).'</legend>';
        CVarDumper::dump($arg, 10, true);
        echo '</fieldset>';
    }
    die;
}

/*
 * @return $_GET[] result
 */
function get($key, $defaultValue=null) 
{
	return Yii::app()->request->getQuery($key, $defaultValue=null);	
}

/*
 * @return $_POST[] result
 */
function post($key, $defaultValue=null) 
{
	return Yii::app()->request->getPost($key, $defaultValue=null);
}

/*
 * @return create page link result
 */
function page($pageName) 
{
	return Yii::app()->cms->createUrl($pageName);	
}

/*
 * A useful one that I use in development is the following which dumps the target with syntax highlighting on by default
 */
function dump($target)
{
  return '<pre>'.CVarDumper::dump($target, 10, true).'</pre>';
}

/*
 * Send a cookie
 */
function sendCookie($name,$value,$options=array())
{
	$cookie=new CHttpCookie($name,$value, $options);
	Yii::app()->request->cookies[$name]=$cookie;
}

/*
 * retrieve the cookie with the specified name
 */
function getCookie($name)
{
	$cookie=Yii::app()->request->cookies[$name];
	$value=$cookie->value;
	
	return $value;
}

/*
 * Delete the cookie with the specified name
 */
function deleteCookie($name)
{
	unset(Yii::app()->request->cookies[$name]);
}

/*
 * Session functions
 */
function sess($key = null, $value = null)
{
  if (!empty ($key) && !empty ($value))
  {
    return Yii::app()->session[$key] = $value;
  }
  elseif (!empty ($key))
  {
    return Yii::app()->session[$key];
  }
  else
  {
    return Yii::app()->session;
  }
}
 
function getSessArr()
{
  return sess()->toArray();
}
 
function getSessId()
{
  return sess()->sessionID;
}
 
function regenSessId()
{
  return sess()->regenerateId();
}
 
function printSess()
{
  echo '<pre>';
  foreach (getSessArr() as $key => $value)
  {
    echo '  '.$key .' -> '.$value.'<br/>';
  }
  echo '</pre>';
}
 
function removeSess($key)
{
  return sess()->remove($key);
}
 
function destroySess()
{
  return sess()->destroy();
}
/*
 * Session functions
 */