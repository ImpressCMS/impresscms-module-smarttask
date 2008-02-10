<?php

function editlist($list_listid = 0)
{
	global $smarttask_list_handler, $xoopsTpl;

	$listObj = $smarttask_list_handler->get($list_listid);
	if (!$listObj->isNew()){
		$sform = $listObj->getForm(_MD_STASK_LIST_EDIT, 'addlist');
		$sform->assign($xoopsTpl, 'smarttask_list');
		$xoopsTpl->assign('categoryPath', _MD_STASK_LIST_EDIT);
	} else {
		$sform = $listObj->getForm(_MD_STASK_LIST_CREATE, 'addlist');
		$sform->assign($xoopsTpl, 'smarttask_list');
		$xoopsTpl->assign('categoryPath', _MD_STASK_LIST_CREATE);
	}
}

include_once('header.php');

$xoopsOption['template_main'] = 'smarttask_list.html';
include_once(XOOPS_ROOT_PATH . "/header.php");
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

$smarttask_list_handler = xoops_getModuleHandler('list');
$smarttask_item_handler = xoops_getModuleHandler('item');

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

$list_listid = isset($_GET['list_listid']) ? intval($_GET['list_listid']) : 0 ;

if (!$op && $list_listid > 0) {
	$op = 'view';
}

switch ($op) {
	case "mod":
	case "changedField":
		smarttask_checkPermission('list_add', 'list.php', _CO_SMARTTASK_LIST_ADD_NOPERM);

		editlist($list_listid);
		$xoopsTpl->assign('module_home', smart_getModuleName(true, true));
		break;

	case "addlist":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smarttask_list_handler);
		$controller->storeFromDefaultForm(_MD_STASK_LIST_CREATED, _MD_STASK_LIST_MODIFIED);

		break;

	case "del":
	    smarttask_checkPermission('list_delete', 'list.php', _CO_SMARTTASK_LIST_DELETE_NOPERM);

	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smarttask_list_handler);
		$controller->handleObjectDeletionFromUserSide();
		$xoopsTpl->assign('module_home', smart_getModuleName(true, true));
		$xoopsTpl->assign('categoryPath', _MD_STASK_LIST_DELETE);
		break;

	case "view" :
		$view_actions_col = array();
		if (smarttask_checkPermission('list_add')) {
			$view_actions_col[] = 'edit';
		}
		if (smarttask_checkPermission('list_delete')) {
			$view_actions_col[] = 'delete';
		}

		$listObj = $smarttask_list_handler->get($list_listid);
		$xoopsTpl->assign('smarttask_list_view', $listObj->displaySingleObject(true, true, $view_actions_col, false));

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('item_listid', $list_listid));

		$table_actions_col = array();
		if (smarttask_checkPermission('list_add')) {
			$table_actions_col[] = 'edit';
		}
		if (smarttask_checkPermission('list_delete')) {
			$table_actions_col[] = 'delete';
		}

		$objectTable = new SmartObjectTable($smarttask_item_handler, $criteria, $table_actions_col);
		$objectTable->isForUserSide();
		$objectTable->addColumn(new SmartObjectColumn('item_deadline', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('item_title', 'left'));
		$objectTable->addColumn(new SmartObjectColumn('item_owner_uid', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('item_completed', 'center', 100));

		$criteria_completed = new CriteriaCompo();
		$criteria_completed->add(new Criteria('item_completed', 1));
		$objectTable->addFilter(_CO_SMARTTASK_LIST_FILTER_COMPLETED, array(
									'key' => 'item_completed',
									'criteria' => $criteria_completed
		));
		$criteria_not_completed = new CriteriaCompo();
		$criteria_not_completed->add(new Criteria('item_completed', 0));
		$objectTable->addFilter(_CO_SMARTTASK_LIST_FILTER_NOT_COMPLETED, array(
									'key' => 'item_completed',
									'criteria' => $criteria_not_completed
		));

		$objectTable->addFilter('item_owner_uid', 'getOwner_uids');

		if (smarttask_checkPermission('list_add')) {
			$objectTable->addIntroButton('additem', 'item.php?op=mod&item_listid=' . $list_listid, _MD_STASK_ITEM_CREATE);
		}
		$xoopsTpl->assign('smarttask_list_items', $objectTable->fetch());

		$xoopsTpl->assign('module_home', smart_getModuleName(true, true));
		$xoopsTpl->assign('categoryPath', $listObj->getVar('list_title'));

		break;

	default:
		$table_actions_col = array();
		if (smarttask_checkPermission('list_add')) {
			$table_actions_col[] = 'edit';
		}
		if (smarttask_checkPermission('list_delete')) {
			$table_actions_col[] = 'delete';
		}

		$objectTable = new SmartObjectTable($smarttask_list_handler, false, $table_actions_col);
		$objectTable->isForUserSide();

		$objectTable->addColumn(new SmartObjectColumn('list_deadline', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('list_title', 'left'));
		$objectTable->addColumn(new SmartObjectColumn('list_completed', 'center', 100));


		if (smarttask_checkPermission('list_add')) {
			$objectTable->addIntroButton('addlist', 'list.php?op=mod', _MD_STASK_LIST_CREATE);
		}

		$objectTable->addQuickSearch(array('list_title', 'list_description'));

		$criteria_completed = new CriteriaCompo();
		$criteria_completed->add(new Criteria('list_completed', 1));
		$objectTable->addFilter(_CO_SMARTTASK_LIST_FILTER_COMPLETED, array(
									'key' => 'list_completed',
									'criteria' => $criteria_completed
		));
		$criteria_not_completed = new CriteriaCompo();
		$criteria_not_completed->add(new Criteria('list_completed', 0));
		$objectTable->addFilter(_CO_SMARTTASK_LIST_FILTER_NOT_COMPLETED, array(
									'key' => 'list_completed',
									'criteria' => $criteria_not_completed
		));

		$xoopsTpl->assign('smarttask_lists', $objectTable->fetch());
		$xoopsTpl->assign('module_home', smart_getModuleName(false, true));

		break;
}

include_once("footer.php");
?>