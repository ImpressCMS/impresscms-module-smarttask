<?php

/**
* $Id$
* Module: SmartTask
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

if( !defined("SMARTTASK_DIRNAME") ){
	define("SMARTTASK_DIRNAME", 'smarttask');
}

if( !defined("SMARTTASK_URL") ){
	define("SMARTTASK_URL", XOOPS_URL.'/modules/'.SMARTTASK_DIRNAME.'/');
}
if( !defined("SMARTTASK_ROOT_PATH") ){
	define("SMARTTASK_ROOT_PATH", XOOPS_ROOT_PATH.'/modules/'.SMARTTASK_DIRNAME.'/');
}

if( !defined("SMARTTASK_IMAGES_URL") ){
	define("SMARTTASK_IMAGES_URL", SMARTTASK_URL.'images/');
}

if( !defined("SMARTTASK_ADMIN_URL") ){
	define("SMARTTASK_ADMIN_URL", SMARTTASK_URL.'admin/');
}

/** Include SmartObject framework **/
include_once XOOPS_ROOT_PATH.'/modules/smartobject/class/smartloader.php';

/*
 * Including the common language file of the module
 */
$fileName = SMARTTASK_ROOT_PATH . 'language/' . $GLOBALS['xoopsConfig']['language'] . '/common.php';
if (!file_exists($fileName)) {
	$fileName = SMARTTASK_ROOT_PATH . 'language/english/common.php';
}

include_once($fileName);

include_once(SMARTTASK_ROOT_PATH . "include/functions.php");

// Creating the SmartModule object
$smarttaskModule =& smart_getModuleInfo(SMARTTASK_DIRNAME);

// Find if the user is admin of the module
$smarttask_isAdmin = smart_userIsAdmin(SMARTTASK_DIRNAME);

$myts = MyTextSanitizer::getInstance();
if(is_object($smarttaskModule)){
	$smarttask_moduleName = $smarttaskModule->getVar('name');
}

// Creating the SmartModule config Object
$smarttaskConfig =& smart_getModuleConfig(SMARTTASK_DIRNAME);

// check of this is the first use of the module
if (is_object($xoopsModule) && $xoopsModule->dirname() == SMARTTASK_DIRNAME) {
	// We are in the module
	if (defined('XOOPS_CPFUNC_LOADED') && !defined('SMARTTASK_FIRST_USE_PAGE')) {
		// We are in the admin side of the module
		if (!smart_getMeta('version')) {
			redirect_header(XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=smarttask', 4, _AM_STASK_FIRST_USE);
			exit;
		}
	}
}

?>