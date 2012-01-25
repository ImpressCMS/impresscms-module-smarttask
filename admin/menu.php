<?php
/**
* Configuring the amdin side menu for the module
*
* @copyright	The SmartFactory http://www.smartfactory.ca
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @package		SmartTask
* @author		marcan <marcan@smartfactory.ca>
* @version		$Id$
*/

global $icmsConfig;

$adminmenu[] = array(
	"title" => _MI_STASK_LISTS,
	"link" => "admin/list.php");
$adminmenu[] = array(
	"title" => _MI_STASK_ITEMS,
	"link" => "admin/item.php");
$adminmenu[] = array(
	"title" => _MI_STASK_LOGS,
	"link" => "admin/log.php");


$module = icms::handler("icms_module")->getByDirname(basename(dirname(dirname(__FILE__))));

$headermenu[] = array(
	"title" => _PREFERENCES,
	"link" => "../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $module->getVar("mid"));
$headermenu[] = array(
	"title" => _CO_ICMS_GOTOMODULE,
	"link" => ICMS_URL . "/modules/smarttask/");
$headermenu[] = array(
	"title" => _CO_ICMS_UPDATE_MODULE,
	"link" => ICMS_URL . "/modules/system/admin.php?fct=modulesadmin&amp;op=update&amp;module=" . basename(dirname(dirname(__FILE__))));
$headermenu[] = array(
	"title" => _MI_STASK_TEMPLATES,
	"link" => '../../system/admin.php?fct=tplsets&amp;op=listtpl&amp;tplset=' . $icmsConfig['template_set'] . '&amp;moddir=' . basename(dirname(dirname(__FILE__))));
$headermenu[] = array(
	"title" => _MODABOUT_ABOUT,
	"link" => ICMS_URL . "/modules/smarttask/admin/about.php");

unset($module_handler);
