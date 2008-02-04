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

$i = -1;

$i++;
$adminmenu[$i]['title'] = _MI_STASK_LISTS;
$adminmenu[$i]['link'] = "admin/list.php";

$i++;
$adminmenu[$i]['title'] = _MI_STASK_ITEMS;
$adminmenu[$i]['link'] = "admin/item.php";

$i++;
$adminmenu[$i]['title'] = _MI_STASK_LOGS;
$adminmenu[$i]['link'] = "admin/log.php";

if (isset($xoopsModule)) {

	$i = -1;

	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid');

	$i++;
	$headermenu[$i]['title'] = _CO_SOBJECT_GOTOMODULE;
	$headermenu[$i]['link'] = SMARTTASK_URL;

	$i++;
	$headermenu[$i]['title'] = _CO_SOBJECT_UPDATE_MODULE;
	$headermenu[$i]['link'] = XOOPS_URL . "/modules/system/admin.php?fct=modulesadmin&op=update&module=" . $xoopsModule->getVar('dirname');

	$i++;
	$headermenu[$i]['title'] = _AM_SOBJECT_ABOUT;
	$headermenu[$i]['link'] = SMARTTASK_URL . "admin/about.php";
}
?>
