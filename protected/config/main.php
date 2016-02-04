<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Inventory Status and Quick Quotes',
	
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',	// URL:  localhost/iq2/index.php/gii
			'password'=>'yiigii',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class' => 'WebUser',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			// 'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		// connect to MySQL (users and roles tables)
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=iq2',
			'emulatePrepare' => true,
			'username' => 'iq2',
			'password' => 'iq2',
			'charset' => 'utf8',
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
					'levels'=>'error, warning, info',
					'categories' => 'MyDebug',
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		'host'=>$_SERVER['HTTP_HOST'],  
		'adminEmail'=>'ldalberti@rocelec.com',
		'email_host' => '192.168.1.15',
		'ldap_domain' => 'rei',
		'ldap_server' => '192.168.1.4',  
		'ldap_port' => '389',
		'profile_sig' => 'images/Signatures',
		'max_upload_size' => 1000000,
		'attachments' => 'attachments',
		'current_invoices' => '/data/current_invoices',
		'older_invoices'   => '/data/older_invoices',
		'app_title'   =>  'InvestaQ²',
		'DEBUG'  => true,
		'TRACE'  => true,
		'DISTRIBUTOR_PRICE_FLOOR' => .75                
	),
);



