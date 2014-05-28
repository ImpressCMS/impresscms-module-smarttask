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

/* filter the user input */
if (!empty($_GET)) {
	$clean_GET = icms_core_DataFilter::checkVarArray($_GET, $filter_get, FALSE);
	extract($clean_GET);
}
if (!empty($_POST)) {
	$clean_POST = icms_core_DataFilter::checkVarArray($_POST, $filter_post, FALSE);
	extract($clean_POST);
}
