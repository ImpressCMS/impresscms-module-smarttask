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

$xoopsTpl->assign("smarttask_adminpage", smart_getModuleAdminLink());
$xoopsTpl->assign("isAdmin", $smarttask_isAdmin);
$xoopsTpl->assign('smarttask_url', SMARTTASK_URL);
$xoopsTpl->assign('smarttask_images_url', SMARTTASK_IMAGES_URL);

$xoTheme->addStylesheet(SMARTTASK_URL . 'module.css');

$xoopsTpl->assign("ref_smartfactory", "SmartTask is developed by The SmartFactory (http://smartfactory.ca), a division of INBOX International (http://inboxinternational.com)");

include_once(XOOPS_ROOT_PATH . '/footer.php');

?>