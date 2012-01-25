<?php

/**
* $Id$
* Module: SmartTask
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("ICMS_ROOT_PATH")) {
 	die("ICMS root path not defined");
}

if( !defined("SMARTTASK_DIRNAME") ){
	define("SMARTTASK_DIRNAME", 'smarttask');
}

if( !defined("SMARTTASK_URL") ){
	define("SMARTTASK_URL", ICMS_URL.'/modules/'.SMARTTASK_DIRNAME.'/');
}
if( !defined("SMARTTASK_ROOT_PATH") ){
	define("SMARTTASK_ROOT_PATH", ICMS_ROOT_PATH.'/modules/'.SMARTTASK_DIRNAME.'/');
}

if( !defined("SMARTTASK_IMAGES_URL") ){
	define("SMARTTASK_IMAGES_URL", ICMS_URL . '/images/crystal/' );
}

if( !defined("SMARTTASK_ADMIN_URL") ){
	define("SMARTTASK_ADMIN_URL", SMARTTASK_URL.'admin/');
}

if( !defined("SMARTTASK_ADMIN_PATH") ){
	define("SMARTTASK_ADMIN_PATH", SMARTTASK_ROOT_PATH.'admin/');
}

/** Include SmartObject framework **/
include_once ICMS_ROOT_PATH . '/kernel/icmspersistableseoobject.php';

/*
 * Including the common language file of the module
 */
 icms_loadLanguageFile(SMARTTASK_DIRNAME, 'common');

 if (isset($fileName) && !empty($fileName)) include_once($fileName);

include_once(SMARTTASK_ROOT_PATH . "include/functions.php");

// Creating the SmartModule object
$module_handler = &xoops_getHandler('module');
$smarttaskModule =&$module_handler->getByDirname(SMARTTASK_DIRNAME);

//get module name
$smarttaskModuleName = $smarttaskModule->getVar('name');

// Find if the user is admin of the module
$smarttask_isAdmin = is_object($icmsUser)?$icmsUser->isAdmin(1):false;

$myts = MyTextSanitizer::getInstance();
if(is_object($smarttaskModule)){
	$smarttask_moduleName = $smarttaskModule->getVar('name');
}

// Creating the SmartModule config Object
$icmsConfigHandler = &xoops_getHandler('config');
$smarttaskConfig =&$icmsConfigHandler->getConfigsByCat(0, $smarttaskModule->getVar('mid'));

// check of this is the first use of the module
if (is_object($icmsModule) && $icmsModule->dirname() == SMARTTASK_DIRNAME) {
	// We are in the module
	if (defined('ICMS_CPFUNC_LOADED') && !defined('SMARTTASK_FIRST_USE_PAGE')) {
		// We are in the admin side of the module
		if (!smart_getMeta('version')) {
			redirect_header(ICMS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=smarttask', 4, _AM_STASK_FIRST_USE);
			exit;
		}
	}
}

?>