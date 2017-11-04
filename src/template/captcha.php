<?php
session_start();
include '../../config/common-url.php';
require_once AUTO_LOAD;

use \App\Modules\Captcha;

/*create class object*/
$phptextObj = new Captcha();	
/*phptext function to genrate image with text*/
$phptextObj->phpcaptcha('#162453','#fff',120,40,10,25);