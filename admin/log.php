<?php
/**
* Log, add, edit and delete log objects
*
* @copyright	The SmartFactory http://www.smartfactory.ca
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @package		SmartTask
* @author		marcan <marcan@smartfactory.ca>
* @version		$Id$
*/

function editlog($showmenu = false, $log_logid = 0, $parentid =0)
{
	global $smarttask_log_handler;

	$logObj = $smarttask_log_handler->get($log_logid);

	$log_itemid = isset($_GET['log_itemid']) ? intval($_GET['log_itemid']) : 0;
	$logObj->setVar('log_itemid', $log_itemid);

	if (!$logObj->isNew()){

		if ($showmenu) {
			smart_adminMenu(2, _AM_STASK_LOGS . " > " . _CO_SOBJECT_EDITING);
		}
		smart_collapsableBar('logedit', _AM_STASK_LOG_EDIT, _AM_STASK_LOG_EDIT_INFO);

		$sform = $logObj->getForm(_AM_STASK_LOG_EDIT, 'addlog');
		$sform->display();
		smart_close_collapsable('logedit');
	} else {
		if ($showmenu) {
			smart_adminMenu(2, _AM_STASK_LOGS . " > " . _CO_SOBJECT_CREATINGNEW);
		}
		smart_collapsableBar('logcreate', _AM_STASK_LOG_CREATE, _AM_STASK_LOG_CREATE_INFO);
		$sform = $logObj->getForm(_AM_STASK_LOG_CREATE, 'addlog');
		$sform->display();
		smart_close_collapsable('logcreate');
	}
}

include_once("admin_header.php");
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

$smarttask_log_handler = xoops_getModuleHandler('log');

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

$log_logid = isset($_GET['log_logid']) ? intval($_GET['log_logid']) : 0 ;

switch ($op) {
	case "mod":
	case "changedField":

		smart_xoops_cp_header();

		editlog(true, $log_logid);
		break;
	case "addlog":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smarttask_log_handler);
		$controller->storeFromDefaultForm(_AM_STASK_LOG_CREATED, _AM_STASK_LOG_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smarttask_log_handler);
		$controller->handleObjectDeletion();

		break;

	case "view" :
		$logObj = $smarttask_log_handler->get($log_logid);

		smart_xoops_cp_header();

		smart_adminMenu(2, _AM_STASK_LOG_VIEW . ' > ' . $logObj->getVar('log_title'));

		smart_collapsableBar('logview', $logObj->getVar('log_title') . $logObj->getEditItemLink(), _AM_STASK_LOG_VIEW_DSC);

		$logObj->displaySingleObject();

		echo "<br />";
		smart_close_collapsable('logview');
		echo "<br>";

		break;

	default:

		smart_xoops_cp_header();
		smart_adminMenu(2, _AM_STASK_LOGS);

		smart_collapsableBar('createdlogs', _AM_STASK_LOGS, _AM_STASK_LOGS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$objectTable = new SmartObjectTable($smarttask_log_handler);
		$objectTable->addColumn(new SmartObjectColumn('log_date', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('log_itemid'));
		$objectTable->addColumn(new SmartObjectColumn('log_uid', 'left', 150));

		$objectTable->addIntroButton('addlog', 'log.php?op=mod', _AM_STASK_LOG_CREATE);

		$objectTable->addQuickSearch(array('log_message'));

		$objectTable->render();

		smart_close_collapsable('createdlogs');

		break;
}

smart_modFooter();
xoops_cp_footer();

?>