<?php
//base path for links
define('LINK_BASE_PATH','/mobirise/');

//root dir path
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'].LINK_BASE_PATH);

//autoload file
define('AUTO_LOAD', BASE_PATH.'/vendor/autoload.php');

//src path for templates
define('SRC_BASE_PATH',BASE_PATH.'src/');

//public path folders
define('PUBLIC_BASE_PATH', BASE_PATH.'public/');

//public path links
define('PUBLIC_PATH', LINK_BASE_PATH.'public/');

//src path for link
define('SRC_PATH',LINK_BASE_PATH.'src/');