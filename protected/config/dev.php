<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			'db'=>array(
				'connectionString' => 'mysql:host=localhost;dbname=broomecms',
				'emulatePrepare' => true,
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8',
				'enableProfiling'=>true,
				'enableParamLogging'=>true,
			),	
			'assetManager' => array(
				'linkAssets' => true,
			),
			/*'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					array(
						// uncomment the following to show log messages on web pages
						//'class'=>'CWebLogRoute',
						'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
						// Access is restricted by default to the localhost
						'ipFilters'=>array('127.0.0.1','192.168.1.*'),
					),
				),
			),*/
		),
		'modules'=>array(
			'backup',
		),
	)
);
