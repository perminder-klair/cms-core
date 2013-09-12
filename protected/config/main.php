<?php

require(dirname(__FILE__).'/../modules/cms/helpers/globals.php');
require(dirname(__FILE__).'/../modules/cms/helpers/cms.php');
require(dirname(__FILE__).'/../modules/cms/helpers/CArray.php');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	//'name'=>'',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
        'application.components.*',
		'application.models.*',
        'application.models.forms.*',

        'application.modules.cms.components.*',
        'application.modules.cms.models.*',
        'application.modules.cms.widgets.*',

		'application.extensions.YiiMailer.YiiMailer',
        'application.extensions.easyimage.EasyImage',
        'application.extensions.redactor.ImperaviRedactorWidget',
        //'application.extensions.mobiledetect.Mobile_Detect', //Uncomment to activate
	),
	
	'aliases' => array(
        'bootstrap' => dirname(__FILE__) . '/../extensions/bootstrap',
        'vendor' => dirname(__FILE__) . '/../../vendor',
    ),
    
    /*
     * choose: default or bootstrap
     * for bootstrap docs: http://www.cniska.net/yii-bootstrap/ and http://twitter.github.com/bootstrap/
     */
     'theme'=>'bootstrap',
	
	'modules'=>array(

		'cms' => array(),

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
			'loginUrl'=>array('/cms/admin/login'),
			'returnUrl'=>array('/site/index'),
		),
		
		'cms'=>array('class'=>'cms.components.Cms'),

	    'setting'=>array('class'=>'cms.components.CmsSetting'),
	    
	    'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
            'defaultRoles'=>array('guest', 'user'),
            'behaviors' => array(
            	'class' => 'cms.components.AuthBehavior',
            ),
            //'class'=>'auth.components.CachedDbAuthManager',
            //'cachingDuration'=>3600,
        ),
        
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'admin'=>'cms/admin',
				'admin/login'=>'cms/admin/login',
				'logout'=>'cms/admin/logout',
				'blog/<id:\d+>/<title:.*?>'=>'cms/blog/view',
				'blog/tag/<tag:.*?>'=>'cms/blog/index',
				'blog/category/<category:.*?>'=>'cms/blog/index',
				'blog'=>'cms/blog/index',
				'blog/feed'=>'cms/blog/feed',
				'<action>'=>'site/<action>',
				'<id:\d+>/<name>'=>'cms/pages/view', // clean URLs for pages
				'cms/<controller:\w+>/<action:\w+>/<id:\d+>'=>'cms/<controller>/<action>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

        'easyImage' => array(
            'class' => 'application.extensions.easyimage.EasyImage',
            //'driver' => 'GD',
            //'quality' => 100,
            'cachePath' => '/files/cache/',
            'cacheTime' => 2592000,
            //'retinaSupport' => false,
        ),
        
        'request'=>array(
            //'enableCsrfValidation'=>true,
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
	 */
	'params'=>array(
		'adminMenu'=>array('demo'),
	),
);