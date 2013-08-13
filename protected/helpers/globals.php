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
 * Redirect back to last page
 */
function lastUrl()
{
	return Yii::app()->request->urlReferrer;
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

/**
 * Returns the request instance.
 * @return CHttpRequest
 */
function request()
{
    return Yii::app()->getRequest();
}

/*
 * @return $_GET[] result
 */
function get($key, $defaultValue=null) 
{
	return sanitize(Yii::app()->request->getQuery($key, $defaultValue=null));
}

/*
 * @return $_POST[] result
 */
function post($key, $defaultValue=null) 
{
	return sanitize(Yii::app()->request->getPost($key, $defaultValue=null));
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

/**
 * Dumps the given variable using CVarDumper::dumpAsString().
 * @param mixed $var
 * @param int $depth
 * @param bool $highlight
 */
function dump_var($var, $depth = 10, $highlight = true)
{
    echo CVarDumper::dumpAsString($var, $depth, $highlight);
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

/**
 * Create SQL Command
 */ 
function db($sql=null){
    if(is_null($sql)) return false;
    return app()->db->CreateCommand($sql);
}

/**
 * Sets an success userFalsh message
 * @param string $message string to be displayed
 */
function setSuccessMessage($message = 'Saved successfully.') {
    if (!Yii::app()->user->hasFlash('success'))
        Yii::app()->user->setFlash('success', '<strong>Success:</strong> ' . $message);
}

/**
 * Sets an error userFalsh message
 * @param string $message string to be displayed
 */
function setErrorMessage($message = 'An error occurred. Do try again.') {
    if (!Yii::app()->user->hasFlash('error'))
        Yii::app()->user->setFlash('error', ' ' . $message);
}

/**
 * Sets a notice userFalsh message
 * @param string $message string to be displayed
 */
function setNoticeMessage($message = 'Take Notice!!') {
    if (!Yii::app()->user->hasFlash('notice'))
        Yii::app()->user->setFlash('notice', 'Notice!!: ' . $message);
}

/**
 * Returns the current time as a MySQL date.
 * @param integer $timestamp the timestamp.
 * @return string the date.
 */
function sqlDate($timestamp = null)
{
    if ($timestamp === null) {
        $timestamp = time();
    }
    return date('Y-m-d', $timestamp);
}

/**
 * Returns the current time as a MySQL date time.
 * @param integer $timestamp the timestamp.
 * @return string the date time.
 */
function sqlDateTime($timestamp = null)
{
    if ($timestamp === null) {
        $timestamp = time();
    }
    return date('Y-m-d H:i:s', $timestamp);
}

/**
 * Registers the given CSS file.
 * @param $url
 * @param string $media
 */
function css($url, $media = '')
{
    Yii::app()->clientScript->registerCssFile(baseUrl($url), $media);
}

/**
 * Registers the given JavaScript file.
 * @param $url
 * @param null $position
 */
function js($url, $position = null)
{
    Yii::app()->clientScript->registerScriptFile(baseUrl($url), $position);
}

/**
 * Escapes the given string using CHtml::encode().
 * @param $text
 * @return string
 */
function e($text)
{
    return CHtml::encode($text);
}

/**
 * Returns the escaped value of a model attribute.
 * @param $model
 * @param $attribute
 * @param null $defaultValue
 * @return string
 */
function v($model, $attribute, $defaultValue = null)
{
    return CHtml::encode(CHtml::value($model, $attribute, $defaultValue));
}

/**
 * Purifies the given HTML.
 * @param $text
 * @return string
 */
function purify($text)
{
    static $purifier;
    if (!isset($purifier)) {
        $purifier = new CHtmlPurifier;
    }
    return $purifier->purify($text);
}

/**
 * Returns the given markdown text as purified HTML.
 * @param $text
 * @return string
 */
function markdown($text)
{
    static $parser;
    if (!isset($parser)) {
        $parser = new MarkdownParser;
    }
    return $parser->safeTransform($text);
}

/**
 * Encodes the given object using json_encode().
 * @param mixed $value
 * @param integer $options
 * @return string
 */
function jsonEncode($value, $options = 0)
{
    return json_encode($value, $options);
}

/**
 * Decodes the given JSON string using json_decode().
 * @param $string
 * @param boolean $assoc
 * @param integer $depth
 * @param integer $options
 * @return mixed
 */
function jsonDecode($string, $assoc = true, $depth = 512, $options = 0)
{
    return json_decode($string, $assoc, $depth, $options);
}