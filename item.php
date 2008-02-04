<?php

function edititem($item_itemid = 0)
{
	global $smarttask_item_handler, $smarttask_list_handler, $xoopsTpl;

	$item_listid = isset($_GET['item_listid']) ? intval($_GET['item_listid']) : 0;

	$itemObj = $smarttask_item_handler->get($item_itemid);

	$listObj = $smarttask_list_handler->get($itemObj->getVar('item_listid', 'e'));
	if ($listObj->isNew()) {
		redirect_header('index.php', 3, _NOPERM);
	}

	$itemObj->setVar('item_listid', $item_listid);

	$itemObj->makeFieldReadOnly('item_listid');

	if (!$itemObj->isNew()){
		$sform = $itemObj->getForm(_MD_STASK_ITEM_EDIT, 'additem');
		$sform->assign($xoopsTpl, 'smarttask_item');
		$xoopsTpl->assign('categoryPath', _MD_STASK_ITEM_EDIT);
	} else {
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

		edititem($item_itemid);
		$xoopsTpl->assign('module_home', smart_getModuleName(true, true));
		break;

	case "additem":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smarttask_item_handler);
		$controller->storeFromDefaultForm(_MD_STASK_ITEM_CREATED, _MD_STASK_ITEM_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smarttask_item_handler);
		$controller->handleObjectDeletionFromUserSide();
		$xoopsTpl->assign('module_home', smart_getModuleName(true, true));
		$xoopsTpl->assign('categoryPath', _MD_STASK_ITEM_DELETE);
		break;

	case "view" :
		$itemObj = $smarttask_item_handler->get($item_itemid);

		$xoopsTpl->assign('smarttask_item_view', $itemObj->displaySingleObject(true, true));

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('log_itemid', $item_itemid));

		$objectTable = new SmartObjectTable($smarttask_log_handler, $criteria);
		$objectTable->isForUserSide();

		$objectTable->addColumn(new SmartObjectColumn('log_date', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('log_message'));
		$objectTable->addColumn(new SmartObjectColumn('log_uid', 'left', 150));

		$objectTable->addIntroButton('addlog', 'log.php?op=mod&log_itemid=' . $item_itemid, _MD_STASK_LOG_CREATE);

		$xoopsTpl->assign('smarttask_item_logs', $objectTable->fetch());

		$xoopsTpl->assign('module_home', smart_getModuleName(true, true));

		$xoopsTpl->assign('categoryPath', $itemObj->getVar('item_listid') . ' > ' . $itemObj->getVar('item_title'));

		break;

	default:
		$objectTable = new SmartObjectTable($smarttask_item_handler, $criteria);
		$objectTable->isForUserSide();

		$objectTable->addColumn(new SmartObjectColumn('item_deadline', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('item_title', 'left'));
		$objectTable->addColumn(new SmartObjectColumn('item_completed', 'center', 100));

		$objectTable->addIntroButton('additem', 'item.php?op=mod', _MD_STASK_ITEM_CREATE);

		$objectTable->addQuickSearch(array('item_title', 'item_description'));

		$criteria_completed = new CriteriaCompo();
		$criteria_completed->add(new Criteria('item_completed', 1));
		$objectTable->addFilter(_CO_SMARTTASK_ITEM_FILTER_COMPLETED, array(
									'key' => 'item_completed',
									'criteria' => $criteria_completed
		));
		$criteria_not_completed = new CriteriaCompo();
		$criteria_not_completed->add(new Criteria('item_completed', 0));
		$objectTable->addFilter(_CO_SMARTTASK_ITEM_FILTER_NOT_COMPLETED, array(
									'key' => 'item_completed',
									'criteria' => $criteria_not_completed
		));

		$xoopsTpl->assign('smarttask_items', $objectTable->fetch());
		$xoopsTpl->assign('module_home', smart_getModuleName(false, true));

		break;
}

include_once("footer.php");
?>