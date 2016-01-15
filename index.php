<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../YiiRoot/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
$globals = dirname(__FILE__) . '/protected/globals.php';
$pdf_lib = dirname(__FILE__) . '/protected/utilities/fpdf17/fpdf.php';
$pdf_util = dirname(__FILE__) . '/protected/utilities/fpdf17/util.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

// include some shortcuts and 'global' functions
require($globals);
require($pdf_lib);
require($pdf_util);

require_once($yii);
Yii::createWebApplication($config)->run();
