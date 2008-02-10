<?php

function editlog($log_logid = 0)
{
	global $smarttask_log_handler, $xoopsTpl, $xoopsUser;

	if (!is_object($xoopsUser)) {
		redirect_header('index.php', 3, _NOPERM);
	}

	$logObj = $smarttask_log_handler->get($log_logid);
	$logObj->setVar('log_uid', $xoopsUser->uid());
	$logObj->setVar('log_date', time());
	$logObj->hideFieldFromForm(array('log_uid', 'log_date'));

	$logObj->makeFieldReadOnly('log_itemid');

	if (!$logObj->isNew()){
		$sform = $logObj->getForm(_MD_STASK_LOG_EDIT, 'addlog');
		$sform->assign($xoopsTpl, 'smarttask_log');
		$xoopsTpl->assign('categoryPath', _MD_STASK_LOG_EDIT);
	} else {
		$log_itemid = isset($_GET['log_itemid']) ? intval($_GET['log_itemid']) : 0;
		$smarttask_item_handler = xoops_getModuleHandler('item');
		$itemObj = $smarttask_item_handler->get($log_itemid);
		if ($itemObj->isNew()) {
			redirect_header('index.php', 3, _NOPERM);
		}
		$logObj->setVar('log_itemid', $log_itemid);
		$sform = $logObj->getForm(_MD_STASK_LOG_CREATE, 'addlog');
		$sform->assign($xoopsTpl, 'smarttask_log');
		$xoopsTpl->assign('categoryPath', _MD_STASK_LOG_CREATE);
	}
}


include_once('header.php');

$xoopsOption['template_main'] = 'smarttask_log.html';
include_once(XOOPS_ROOT_PATH . "/header.php");
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

$smarttask_log_handler = xoops_getModuleHandler('log');
$smarttask_item_handler = xoops_getModuleHandler('item');

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

$log_logid = isset($_GET['log_logid']) ? intval($_GET['log_logid']) : 0 ;

if (!$op && $log_logid > 0) {
	$op = 'view';
}

switch ($op) {
	case "mod":
	case "changedField":

		smarttask_checkPermission('log_add', 'list.php', _CO_SMARTTASK_LOG_ADD_NOPERM);
		editlog($log_logid);
		$xoopsTpl->assign('module_home', smart_getModuleName(true, true));
		break;

	case "addlog":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smarttask_log_handler);
		$controller->storeFromDefaultForm(_MD_STASK_LOG_CREATED, _MD_STASK_LOG_MODIFIED);

		break;

	case "del":
		smarttask_checkPermission('log_delete', 'list.php', _CO_SMARTTASK_LOG_DELETE_NOPERM);
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smarttask_log_handler);
		$controller->handleObjectDeletionFromUserSide();
		$xoopsTpl->assign('module_home', smart_getModuleName(true, true));
		$xoopsTpl->assign('categoryPath', _MD_STASK_LOG_DELETE);
		break;

	case "view" :
		$logObj = $smarttask_log_handler->get($log_logid);
		$xoopsTpl->assign('smarttask_log_view', $logObj->displaySingleObject(true, true));

		$xoopsTpl->assign('module_home', smart_getModuleName(true, true));

		$xoopsTpl->assign('categoryPath', $logObj->getVar('log_itemid'));

		break;

	default:
		redirect_header(SMARTTASK_URL, 3, _NOPERM);
		break;
}

include_once("footer.php");
?>