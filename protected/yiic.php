<?php
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_ENABLE_EXCEPTION_HANDLER') or define('YII_ENABLE_EXCEPTION_HANDLER',true);
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER',true);

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
// change the following paths if necessary
$yiic = '/var/phplibs/yii/yiic.php';
$config=dirname(__FILE__).'/config/console.php';
require_once($yiic);
