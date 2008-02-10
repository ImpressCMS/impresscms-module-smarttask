<?php

function edititem($item_itemid = 0)
{
	global $smarttask_item_handler, $smarttask_list_handler, $xoopsTpl;

	$itemObj = $smarttask_item_handler->get($item_itemid);

	if (!$itemObj->isNew()){
		$sform = $itemObj->getForm(_MD_STASK_ITEM_EDIT, 'additem');
		$sform->assign($xoopsTpl, 'smarttask_item');
		$xoopsTpl->assign('categoryPath', _MD_STASK_ITEM_EDIT);
	} else {
		$item_listid = isset($_GET['item_listid']) ? intval($_GET['item_listid']) : 0;
		$listObj = $smarttask_list_handler->get($item_listid);

		$itemObj->setVar('item_listid', $item_listid);

		$sform = $itemObj->getForm(_MD_STASK_ITEM_CREATE, 'additem');
		$sform->assign($xoopsTpl, 'smarttask_item');
		$xoopsTpl->assign('categoryPath', _MD_STASK_ITEM_CREATE);
	}
}

include_once('header.php');

$xoopsOption['template_main'] = 'smarttask_item.html';
include_once(XOOPS_ROOT_PATH . "/header.php");
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

$smarttask_item_handler = xoops_getModuleHandler('item');
$smarttask_log_handler = xoops_getModuleHandler('log');
$smarttask_list_handler = xoops_getModuleHandler('list');

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

$item_itemid = isset($_GET['item_itemid']) ? intval($_GET['item_itemid']) : 0 ;

if (!$op && $item_itemid > 0) {
	$op = 'view';
}

switch ($op) {
	case "mod":
	case "changedField":

		smarttask_checkPermission('item_add', 'list.php', _CO_SMARTTASK_ITEM_ADD_NOPERM);
		edititem($item_itemid);
		$xoopsTpl->assign('module_home', smart_getModuleName(true, true));
		break;

	case "additem":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smarttask_item_handler);
		$controller->storeFromDefaultForm(_MD_STASK_ITEM_CREATED, _MD_STASK_ITEM_MODIFIED);

		break;

	case "del":
		smarttask_checkPermission('item_delete', 'list.php', _CO_SMARTTASK_ITEM_DELETE_NOPERM);
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smarttask_item_handler);
		$controller->handleObjectDeletionFromUserSide();
		$xoopsTpl->assign('module_home', smart_getModuleName(true, true));
		$xoopsTpl->assign('categoryPath', _MD_STASK_ITEM_DELETE);
		break;

	case "view" :
		$itemObj = $smarttask_item_handler->get($item_itemid);

		$view_actions_col = array();
		if (smarttask_checkPermission('item_add')) {
			$view_actions_col[] = 'edit';
		}
		if (smarttask_checkPermission('item_delete')) {
			$view_actions_col[] = 'delete';
		}
		$xoopsTpl->assign('smarttask_item_view', $itemObj->displaySingleObject(true, true, $view_actions_col));

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('log_itemid', $item_itemid));

		$table_actions_col = array();
		if (smarttask_checkPermission('log_add')) {
			$table_actions_col[] = 'edit';
		}
		if (smarttask_checkPermission('log_delete')) {
			$table_actions_col[] = 'delete';
		}

		$objectTable = new SmartObjectTable($smarttask_log_handler, $criteria, $table_actions_col);
		$objectTable->isForUserSide();

		$objectTable->addColumn(new SmartObjectColumn('log_date', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('log_message'));
		$objectTable->addColumn(new SmartObjectColumn('log_uid', 'left', 150));

		if (smarttask_checkPermission('log_add')) {
			$objectTable->addIntroButton('addlog', 'log.php?op=mod&log_itemid=' . $item_itemid, _MD_STASK_LOG_CREATE);
		}

		$xoopsTpl->assign('smarttask_item_logs', $objectTable->fetch());

		$xoopsTpl->assign('module_home', smart_getModuleName(true, true));

		$xoopsTpl->assign('categoryPath', $itemObj->getVar('item_listid') . ' > ' . $itemObj->getVar('item_title'));

		break;

	default:
		redirect_header(SMARTTASK_URL, 3, _NOPERM);
		break;
}

include_once("footer.php");
?>