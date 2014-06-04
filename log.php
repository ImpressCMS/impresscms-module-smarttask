<?php

/* set get and post filters before including admin_header, if not strings */
$filter_get = array(
		'op' => 'str',
		'list_logid' => 'int',
);

$filter_post = array(
		'op' => 'str',
		'list_logid' => 'int',
);

/* set default values for variables */
$op = '';
$log_logid = 0;

include_once 'header.php';


function editlog($log_logid = 0) {
	global $smarttask_log_handler, $icmsTpl, $icmsUser;

	if (!is_object($icmsUser)) {
		redirect_header('index.php', 3, _NOPERM);
	}

	$logObj = $smarttask_log_handler->get($log_logid);
	$logObj->setVar('log_uid', $icmsUser->uid());
	$logObj->setVar('log_date', time());
	$logObj->hideFieldFromForm(array('log_uid', 'log_date'));

	$logObj->makeFieldReadOnly('log_itemid');

	if (!$logObj->isNew()){
		$sform = $logObj->getForm(_MD_STASK_LOG_EDIT, 'addlog');
		$sform->assign($icmsTpl, 'smarttask_log');
		$icmsTpl->assign('categoryPath', _MD_STASK_LOG_EDIT);
	} else {
		$smarttask_item_handler = icms_getModuleHandler('item', basename(dirname(dirname(__FILE__))), "smarttask");
		$itemObj = $smarttask_item_handler->get($log_itemid);
		if ($itemObj->isNew()) {
			redirect_header('index.php', 3, _NOPERM);
		}
		$logObj->setVar('log_itemid', $log_itemid);
		$sform = $logObj->getForm(_MD_STASK_LOG_CREATE, 'addlog');
		$sform->assign($icmsTpl, 'smarttask_log');
		$icmsTpl->assign('categoryPath', _MD_STASK_LOG_CREATE);
	}
}

if (!$op && $log_logid > 0) {
	$op = 'view';
}

$xoopsOption['template_main'] = 'smarttask_log.html';
include_once ICMS_ROOT_PATH . "/header.php";

$smarttask_log_handler = icms_getModuleHandler('log');
$smarttask_item_handler = icms_getModuleHandler('item');

switch ($op) {
	case "mod":
	case "changedField":

		smarttask_checkPermission('log_add', 'list.php', _CO_SMARTTASK_LOG_ADD_NOPERM);
		editlog($log_logid);
		$icmsTpl->assign('module_home', $smarttaskModuleName);
		break;

	case "addlog":
        include_once ICMS_ROOT_PATH . '/kernel/icmspersistablecontroller.php';
        $controller = new IcmsPersistableController($smarttask_log_handler);
		$controller->storeFromDefaultForm(_MD_STASK_LOG_CREATED, _MD_STASK_LOG_MODIFIED);

		break;

	case "del":
		smarttask_checkPermission('log_delete', 'list.php', _CO_SMARTTASK_LOG_DELETE_NOPERM);
	    include_once ICMS_ROOT_PATH . '/kernel/icmspersistablecontroller.php';
        $controller = new IcmsPersistableController($smarttask_log_handler);
		$controller->handleObjectDeletionFromUserSide();
		$icmsTpl->assign('module_home', $smarttaskModuleName);
		$icmsTpl->assign('categoryPath', _MD_STASK_LOG_DELETE);
		break;

	case "view" :
		$logObj = $smarttask_log_handler->get($log_logid);

		$view_actions_col = array();
		if (smarttask_checkPermission('log_add')) {
			$view_actions_col[] = 'edit';
		}
		if (smarttask_checkPermission('log_delete')) {
			$view_actions_col[] = 'delete';
		}

		$icmsTpl->assign('smarttask_log_view', $logObj->displaySingleObject(true, true, $view_actions_col, false));

		$icmsTpl->assign('module_home', $smarttaskModuleName);

		$icmsTpl->assign('categoryPath', $logObj->getVar('log_itemid'));

		break;

	default:
		redirect_header(SMARTTASK_URL, 3, _NOPERM);
		break;
}

include_once("footer.php");
