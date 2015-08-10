<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'dodo',
    'import'=>array(
		'application.models.*',
		'application.components.*',
                'application.extensions.*',
                'application.modules.*',
	),
    'modules'=>array(
	

        

	),
    'components'=>array(
	'swiftMailer' => array(
    'class' => 'ext.swiftMailer.SwiftMailer',
),
		'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=dc_test',
            'emulatePrepare' => true,
            'username' => 'dc_test',
            'password' => '',
            'charset' => 'utf8',
        ),
		


		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
							),
		),
	),
);
