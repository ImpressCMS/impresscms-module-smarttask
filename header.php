<?php

/**
* $Id: header.php 20145 2010-09-15 13:06:09Z mekdrop $
* Module: SmartTask
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once "../../mainfile.php";

if( !defined("SMARTTASK_DIRNAME") ){
	define("SMARTTASK_DIRNAME", 'smarttask');
}

include_once ICMS_ROOT_PATH.'/modules/' . SMARTTASK_DIRNAME . '/include/common.php';
//smart_loadCommonLanguageFile();
icms_loadLanguageFile(SMARTTASK_DIRNAME, 'common');

include_once SMARTTASK_ROOT_PATH . "include/functions.php";

?>