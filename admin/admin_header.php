<?php

/**
* $Id$
* Module: SmartTask
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

if (!defined("SMARTTASK_NOCPFUNC")) {
	include_once '../../../include/cp_header.php';
}

include_once XOOPS_ROOT_PATH . "/class/xoopsmodule.php";
include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
include_once XOOPS_ROOT_PATH . '/class/template.php';

include_once XOOPS_ROOT_PATH.'/modules/smarttask/include/common.php';

if( !defined("SMARTTASK_ADMIN_URL") ){
	define('SMARTTASK_ADMIN_URL', SMARTTASK_URL . "admin/");
}

smart_loadCommonLanguageFile();

?>