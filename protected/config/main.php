<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Docler Test application',
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.extensions.*',
    ),
    'defaultController' => 'site',
        
    // application components
    'components' => array(
        'swiftMailer' => array(
            'class' => 'ext.swiftMailer.SwiftMailer',
        ),
        
        'user' => array(
            // enable cookie-based authentication
          //  'allowAutoLogin' => true,
            'class' => 'WebUser',
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=dc_test',
            'emulatePrepare' => true,
            'username' => 'dc_test',
            'password' => '',
            'charset' => 'utf8',
        ),
        
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
//				array(
//					'class'=>'CWebLogRoute',
//                                        'levels'=>'error, warning',
//				),
            ),
        ),
    ),
    // using Yii::app()->params['paramName']
    'params' => require(dirname(__FILE__) . '/params.php'),
);
