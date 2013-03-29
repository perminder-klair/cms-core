<?php
require(dirname(__FILE__).'/../helpers/globals.php');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	//'name'=>'',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
		'application.modules.cms.models.*',
		'application.modules.cms.CmsModule',
		'application.modules.cms.components.CmsActiveRecord',
		'application.modules.cms.components.CmsUserIdentity',
		'application.extensions.CAdvancedArBehavior',
	),
	
	'aliases' => array(),
    
    /*
     * choose: default or bootstrap
     * for bootstrap docs: http://www.cniska.net/yii-bootstrap/ and http://twitter.github.com/bootstrap/
     */
    'theme'=>'bootstrap',
	
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'cms',
	),

	// application components
	'components'=>array(	
		'bootstrap'=>array(
		    'class'=>'bootstrap.components.Bootstrap',
		),
	
		'user'=>array(
			'class'=>'application.modules.cms.components.CmsWebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'cms'=>array('class'=>'cms.components.Cms'),
	    'setting'=>array('class'=>'cms.components.CmsSetting'),
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'admin'=>'cms/admin',
				'admin/login'=>'cms/admin/login',
				'logout'=>'cms/admin/logout',
				'blog/<id:\d+>/<title:.*?>'=>'cms/blog/view',
				'blog/<tag:.*?>'=>'cms/blog/index',
				'blog'=>'cms/blog/index',
				'<action>'=>'site/<action>',
				'<id:\d+>/<name>'=>'cms/pages/view', // clean URLs for pages
				'cms/<controller:\w+>/<action:\w+>/<id:\d+>'=>'cms/<controller>/<action>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				
				
			),
		),
        
        'image'=>array(
          'class'=>'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver'=>'GD',
            // ImageMagick setup path
            'params'=>array('directory'=>'/opt/local/bin'),
        ),
        
        'request'=>array(
            'enableCsrfValidation'=>true,
            'enableCookieValidation'=>true,
        ),
        
        'assetManager'=>array(
            // change the path on disk
            'basePath'=>dirname(__FILE__).'/../../cache/',
            // change the url
            'baseUrl'=>'/cache/'
        ),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					// uncomment the following to show log messages on web pages
					//'class'=>'CWebLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),

	/* 
	 * application-level parameters that can be accessed
	 * using Yii::app()->params['paramName']
	 * USE THIS INSTED gl('site_name'));
	 */
	/*'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),*/
);