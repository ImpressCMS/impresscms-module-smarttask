<?php

/**
* $Id$
* Module: SmartTask
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once "../../mainfile.php";

if( !defined("SMARTTASK_DIRNAME") ){
	define("SMARTTASK_DIRNAME", 'smarttask');
}

include_once XOOPS_ROOT_PATH.'/modules/' . SMARTTASK_DIRNAME . '/include/common.php';
smart_loadCommonLanguageFile();

include_once SMARTTASK_ROOT_PATH . "include/functions.php";

?>