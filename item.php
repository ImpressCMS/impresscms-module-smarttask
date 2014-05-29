<?php

function edititem($item_itemid = 0)
{
	global $smarttask_item_handler, $smarttask_list_handler, $icmsTpl;

	$itemObj = $smarttask_item_handler->get($item_itemid);

	if (!$itemObj->isNew()){
		$sform = $itemObj->getForm(_MD_STASK_ITEM_EDIT, 'additem');
		$sform->assign($icmsTpl, 'smarttask_item');
		$icmsTpl->assign('categoryPath', _MD_STASK_ITEM_EDIT);
	} else {
		$item_listid = isset($_GET['item_listid']) ? intval($_GET['item_listid']) : 0;
		$listObj = $smarttask_list_handler->get($item_listid);

		$itemObj->setVar('item_listid', $item_listid);

		$sform = $itemObj->getForm(_MD_STASK_ITEM_CREATE, 'additem');
		$sform->assign($icmsTpl, 'smarttask_item');
		$icmsTpl->assign('categoryPath', _MD_STASK_ITEM_CREATE);
	}
}
/* set get and post filters before including admin_header, if not strings */
$filter_get = array(
		'op' => 'str',
		'item_itemid' => 'int',
);

$filter_post = array(
		'op' => 'str',
		'item_itemid' => 'int',
);

/* set default values for variables */
$op = '';
$item_itemid = 0;

include_once('header.php');

if (!$op && $item_itemid > 0) {
	$op = 'view';
}

$xoopsOption['template_main'] = 'smarttask_item.html';
include_once(ICMS_ROOT_PATH . "/header.php");


$smarttask_item_handler = icms_getModuleHandler('item');
$smarttask_log_handler = icms_getModuleHandler('log');
$smarttask_list_handler = icms_getModuleHandler('list');

switch ($op) {
	case "mod":
	case "changedField":

		smarttask_checkPermission('item_add', 'list.php', _CO_SMARTTASK_ITEM_ADD_NOPERM);
		edititem($item_itemid);
		$icmsTpl->assign('module_home', $smarttaskModuleName);
		break;

	case "additem":
        include_once ICMS_ROOT_PATH . '/kernel/icmspersistablecontroller.php';
        $controller = new IcmsPersistableController($smarttask_item_handler);
		$controller->storeFromDefaultForm(_MD_STASK_ITEM_CREATED, _MD_STASK_ITEM_MODIFIED);

		break;

	case "del":
		smarttask_checkPermission('item_delete', 'list.php', _CO_SMARTTASK_ITEM_DELETE_NOPERM);
	    include_once ICMS_ROOT_PATH . '/kernel/icmspersistablecontroller.php';
        $controller = new IcmsPersistableController($smarttask_item_handler);
		$controller->handleObjectDeletionFromUserSide();
		$icmsTpl->assign('module_home', $smarttaskModuleName);
		$icmsTpl->assign('categoryPath', _MD_STASK_ITEM_DELETE);
		break;

	case "view" :
		$itemObj = $smarttask_item_handler->get($item_itemid);

		$view_actions_col = array();
		if (smarttask_checkPermission('item_add')) {
			$view_actions_col[] = 'edit';
		}
		/*if (smarttask_checkPermission('item_delete')) {
			$view_actions_col[] = 'delete';
		}*/
		$icmsTpl->assign('smarttask_item_view', $itemObj->displaySingleObject(true, true, $view_actions_col, false));

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('log_itemid', $item_itemid));

		$table_actions_col = array();
		if (smarttask_checkPermission('log_add')) {
			$table_actions_col[] = 'edit';
		}
		/*if (smarttask_checkPermission('log_delete')) {
			$table_actions_col[] = 'delete';
		}*/

		include_once ICMS_ROOT_PATH."/kernel/icmspersistabletable.php";

		$objectTable = new IcmsPersistableTable($smarttask_log_handler, $criteria, $table_actions_col);
		$objectTable->isForUserSide();

		$objectTable->addColumn(new IcmsPersistableColumn('log_date', 'left', 150));
		$objectTable->addColumn(new IcmsPersistableColumn('log_message'));
		$objectTable->addColumn(new IcmsPersistableColumn('log_uid', 'left', 150));

		$objectTable->setDefaultSort('log_date');
		$objectTable->setDefaultOrder('DESC');

		if (smarttask_checkPermission('log_add')) {
			$objectTable->addIntroButton('addlog', 'log.php?op=mod&log_itemid=' . $item_itemid, _MD_STASK_LOG_CREATE);
		}

		$icmsTpl->assign('smarttask_item_logs', $objectTable->fetch());

		$icmsTpl->assign('module_home', $smarttaskModuleName);

		$icmsTpl->assign('categoryPath', $itemObj->getVar('item_listid') . ' > ' . $itemObj->getVar('item_title'));

		break;

	default:
		redirect_header(SMARTTASK_URL, 3, _NOPERM);
		break;
}

include_once("footer.php");
