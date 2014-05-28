<?php
/**
* Log, add, edit and delete log objects
*
* @copyright	The SmartFactory http://www.smartfactory.ca
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @package		SmartTask
* @author		marcan <marcan@smartfactory.ca>
* @version		$Id: log.php 23265 2012-01-25 07:50:44Z sato-san $
*/

function editlog($showmenu = false, $log_logid = 0, $parentid =0)
{
	global $smarttask_log_handler;

	$logObj = $smarttask_log_handler->get($log_logid);

	$log_itemid = isset($_GET['log_itemid']) ? intval($_GET['log_itemid']) : 0;
	$logObj->setVar('log_itemid', $log_itemid);

	if (!$logObj->isNew()){

		if ($showmenu) {
			icms_adminMenu(2, _AM_STASK_LOGS . " > " . _CO_SOBJECT_EDITING);
		}
		icms_collapsableBar('logedit', _AM_STASK_LOG_EDIT, _AM_STASK_LOG_EDIT_INFO);

		$sform = $logObj->getForm(_AM_STASK_LOG_EDIT, 'addlog');
		$sform->display();
		icms_close_collapsable('logedit');
	} else {
		if ($showmenu) {
			icms_adminMenu(2, _AM_STASK_LOGS );
		}
		icms_collapsableBar('logcreate', _AM_STASK_LOG_CREATE, _AM_STASK_LOG_CREATE_INFO);
		$sform = $logObj->getForm(_AM_STASK_LOG_CREATE, 'addlog');
		$sform->display();
		icms_close_collapsable('logcreate');
	}
}

include_once("admin_header.php");

$smarttask_log_handler = icms_getModuleHandler('log', basename(dirname(dirname(__FILE__))), "smarttask");

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

$log_logid = isset($_GET['log_logid']) ? intval($_GET['log_logid']) : 0 ;

switch ($op) {
	case "mod":
	case "changedField":

		icms_cp_header();

		editlog(true, $log_logid);
		break;
	case "addlog":
        include_once ICMS_ROOT_PATH . '/kernel/icmspersistablecontroller.php';
        $controller = new IcmsPersistableController($smarttask_log_handler);
		$controller->storeFromDefaultForm(_AM_STASK_LOG_CREATED, _AM_STASK_LOG_MODIFIED);

		break;

	case "del":
	    include_once ICMS_ROOT_PATH . '/kernel/icmspersistablecontroller.php';
        $controller = new IcmsPersistableController($smarttask_log_handler);
		$controller->handleObjectDeletion();

		break;

	case "view" :
		$logObj = $smarttask_log_handler->get($log_logid);

		icms_cp_header();

		icms_adminMenu(2, _AM_STASK_LOG_VIEW . ' > ' . $logObj->getVar('log_title'));

		icms_collapsableBar('logview', $logObj->getVar('log_title') . $logObj->getEditItemLink(), _AM_STASK_LOG_VIEW_DSC);

		$logObj->displaySingleObject();

		echo "<br />";
		icms_close_collapsable('logview');
		echo "<br>";

		break;

	default:

		icms_cp_header();
		icms_adminMenu(2, _AM_STASK_LOGS);

		icms_collapsableBar('createdlogs', _AM_STASK_LOGS, _AM_STASK_LOGS_DSC);

		include_once ICMS_ROOT_PATH."/kernel/icmspersistabletable.php";
		
		$objectTable = new IcmsPersistableTable($smarttask_log_handler);
		$objectTable->addColumn(new IcmsPersistableColumn('log_date', 'left', 150));
		$objectTable->addColumn(new IcmsPersistableColumn('log_itemid'));
		$objectTable->addColumn(new IcmsPersistableColumn('log_uid', 'left', 150));

		$objectTable->addIntroButton('addlog', 'log.php?op=mod', _AM_STASK_LOG_CREATE);

		$objectTable->addQuickSearch(array('log_message'));

		$objectTable->render();

		icms_close_collapsable('createdlogs');

		break;
}


icms_cp_footer();

?>