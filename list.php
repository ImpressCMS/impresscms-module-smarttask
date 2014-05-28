<?php

function editlist($list_listid = 0)
{
	global $smarttask_list_handler, $icmsTpl;

	$listObj = $smarttask_list_handler->get($list_listid);
	if (!$listObj->isNew()){
		$sform = $listObj->getForm(_MD_STASK_LIST_EDIT, 'addlist');
		$sform->assign($icmsTpl, 'smarttask_list');
		$icmsTpl->assign('categoryPath', _MD_STASK_LIST_EDIT);
	} else {
		$sform = $listObj->getForm(_MD_STASK_LIST_CREATE, 'addlist');
		$sform->assign($icmsTpl, 'smarttask_list');
		$icmsTpl->assign('categoryPath', _MD_STASK_LIST_CREATE);
	}
}

include_once('header.php');

$xoopsOption['template_main'] = 'smarttask_list.html';
include_once(ICMS_ROOT_PATH . "/header.php");


$smarttask_list_handler = icms_getModuleHandler('list');
$smarttask_item_handler = icms_getModuleHandler('item');

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
		$icmsTpl->assign('module_home', $smarttaskModuleName);
		break;

	case "addlist":
        include_once ICMS_ROOT_PATH . '/kernel/icmspersistablecontroller.php';
        $controller = new IcmsPersistableController($smarttask_list_handler);
		$controller->storeFromDefaultForm(_MD_STASK_LIST_CREATED, _MD_STASK_LIST_MODIFIED);

		break;

	case "del":
	    smarttask_checkPermission('list_delete', 'list.php', _CO_SMARTTASK_LIST_DELETE_NOPERM);

	    include_once ICMS_ROOT_PATH . '/kernel/icmspersistablecontroller.php';
        $controller = new IcmsPersistableController($smarttask_list_handler);
		$controller->handleObjectDeletionFromUserSide();
		$icmsTpl->assign('module_home', $smarttaskModuleName);
		$icmsTpl->assign('categoryPath', _MD_STASK_LIST_DELETE);
		break;

	case "view" :
		$view_actions_col = array();
		if (smarttask_checkPermission('list_add')) {
			$view_actions_col[] = 'edit';
		}
		/*if (smarttask_checkPermission('list_delete')) {
			$view_actions_col[] = 'delete';
		}*/

		$listObj = $smarttask_list_handler->get($list_listid);
		$icmsTpl->assign('smarttask_list_view', $listObj->displaySingleObject(true, true, $view_actions_col, false));

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('item_listid', $list_listid));

		$table_actions_col = array();
		if (smarttask_checkPermission('list_add')) {
			$table_actions_col[] = 'edit';
		}
		/*if (smarttask_checkPermission('list_delete')) {
			$table_actions_col[] = 'delete';
		}*/
		
		require_once ICMS_ROOT_PATH . '/kernel/icmspersistabletable.php';

		$objectTable = new IcmsPersistableTable($smarttask_item_handler, $criteria, $table_actions_col); 
		$objectTable->isForUserSide();
		$objectTable->addColumn(new IcmsPersistableColumn('item_deadline', 'left', 150));
		$objectTable->addColumn(new IcmsPersistableColumn('item_title', 'left'));
		$objectTable->addColumn(new IcmsPersistableColumn('item_owner_uid', 'left', 150));
		$objectTable->addColumn(new IcmsPersistableColumn('item_completed', 'center', 100));

		$criteria_myself = new CriteriaCompo();
		$criteria_myself->add(new Criteria('item_owner_uid', $xoopsUser->getVar('uid')));
		$objectTable->addFilter(_CO_SMARTTASK_LIST_FILTER_MYSELF, array(
									'key' => 'item_owner_uid',
									'criteria' => $criteria_myself
		));		
		
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
		$icmsTpl->assign('smarttask_list_items', $objectTable->fetch());

		$icmsTpl->assign('module_home', $smarttaskModuleName);
		$icmsTpl->assign('categoryPath', $listObj->getVar('list_title'));

		break;

	default:
		$table_actions_col = array();
		if (smarttask_checkPermission('list_add')) {
			$table_actions_col[] = 'edit';
		}
		/*if (smarttask_checkPermission('list_delete')) {
			$table_actions_col[] = 'delete';
		}*/
		
		require_once ICMS_ROOT_PATH . '/kernel/icmspersistabletable.php';

		$objectTable = new IcmsPersistableTable($smarttask_list_handler, false, $table_actions_col);
		$objectTable->isForUserSide();

		$objectTable->addColumn(new IcmsPersistableColumn('list_deadline', 'left', 150));
		$objectTable->addColumn(new IcmsPersistableColumn('list_title', 'left'));
		$objectTable->addColumn(new IcmsPersistableColumn('list_completed', 'center', 100));


		/*if (smarttask_checkPermission('list_add')) {
			$objectTable->addIntroButton('addlist', 'list.php?op=mod', _MD_STASK_LIST_CREATE);
		}*/

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

		$icmsTpl->assign('smarttask_lists', $objectTable->fetch());
		$icmsTpl->assign('module_home', $smarttaskModuleName);

		break;
}

include_once("footer.php");
?>