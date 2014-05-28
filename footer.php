<?php

/**
* $Id: footer.php 20145 2010-09-15 13:06:09Z mekdrop $
* Module: SmartTask
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("ICMS_ROOT_PATH")) {
 	die("ICMS root path not defined");
}

//$icmsTpl->assign("smarttask_adminpage", SMARTTASK_ADMIN_URL);
$icmsTpl->assign("isAdmin", $smarttask_isAdmin);
$icmsTpl->assign('smarttask_url', SMARTTASK_URL);
$icmsTpl->assign('smarttask_images_url', SMARTTASK_IMAGES_URL);

$xoTheme->addStylesheet(SMARTTASK_URL . 'module.css');

$icmsTpl->assign("ref_smartfactory", "SmartTask is developed by The SmartFactory (http://smartfactory.ca), a division of INBOX International (http://inboxinternational.com)");

include_once(ICMS_ROOT_PATH . '/footer.php');

?>