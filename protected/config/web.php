<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'cache'=>array(
	            'class'=>'CDbCache',
	        ),
			
			/*
			'db'=>array(
				'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
			),
			*/
			'db'=>array(
				'class'=>'system.db.CDbConnection',
				'schemaCachingDuration'=>3600,
				'connectionString' => 'mysql:host=localhost;dbname=DATABASE NAME HERE',
				'emulatePrepare' => true,
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8',
			),
		),
	)
);
