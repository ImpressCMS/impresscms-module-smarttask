<?php

/**
* List, add, edit and delete list objects
*
* @copyright	The SmartFactory http://www.smartfactory.ca
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @package		SmartTask
* @author		marcan <marcan@smartfactory.ca>
* @version		$Id$
*/

function editlist($showmenu = false, $list_listid = 0, $parentid =0)
{
	global $smarttask_list_handler;

	$listObj = $smarttask_list_handler->get($list_listid);
	if (!$listObj->isNew()){

		if ($showmenu) {
			smart_adminMenu(0, _AM_STASK_LISTS . " > " . _CO_SOBJECT_EDITING);
		}
		smart_collapsableBar('listedit', _AM_STASK_LIST_EDIT, _AM_STASK_LIST_EDIT_INFO);

		$sform = $listObj->getForm(_AM_STASK_LIST_EDIT, 'addlist');
		$sform->display();
		smart_close_collapsable('listedit');
	} else {
		if ($showmenu) {
			smart_adminMenu(0, _AM_STASK_LISTS . " > " . _CO_SOBJECT_CREATINGNEW);
		}
		smart_collapsableBar('listcreate', _AM_STASK_LIST_CREATE, _AM_STASK_LIST_CREATE_INFO);
		$sform = $listObj->getForm(_AM_STASK_LIST_CREATE, 'addlist');
		$sform->display();
		smart_close_collapsable('listcreate');
	}
}

include_once("admin_header.php");
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

$smarttask_list_handler = xoops_getModuleHandler('list');
$smarttask_item_handler = xoops_getModuleHandler('item');

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

$list_listid = isset($_GET['list_listid']) ? intval($_GET['list_listid']) : 0 ;

switch ($op) {
	case "mod":
	case "changedField":

		smart_xoops_cp_header();

		editlist(true, $list_listid);
		break;
	case "addlist":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smarttask_list_handler);
		$controller->storeFromDefaultForm(_AM_STASK_LIST_CREATED, _AM_STASK_LIST_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smarttask_list_handler);
		$controller->handleObjectDeletion();

		break;

	case "view" :
		$listObj = $smarttask_list_handler->get($list_listid);

		smart_xoops_cp_header();
		smart_adminMenu(0, _AM_STASK_LIST_VIEW . ' > ' . $listObj->getVar('list_title'));

		smart_collapsableBar('listview', $listObj->getVar('list_title') . $listObj->getEditItemLink(), _AM_STASK_LIST_VIEW_DSC);

		$listObj->displaySingleObject();

		smart_close_collapsable('listview');

		smart_collapsableBar('listview_items', _AM_STASK_ITEMS, _AM_STASK_ITEMS_IN_LIST_DSC);

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('item_listid', $list_listid));

		$objectTable = new SmartObjectTable($smarttask_item_handler, $criteria);
		$objectTable->addColumn(new SmartObjectColumn('item_deadline', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('item_title', 'left', false, 'getAdminViewItemLink'));
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

		$objectTable->addIntroButton('additem', 'item.php?op=mod&item_listid=' . $list_listid, _AM_STASK_ITEM_CREATE);

		$objectTable->render();

		smart_close_collapsable('listview_items');

		break;

	default:

		smart_xoops_cp_header();
		smart_adminMenu(0, _AM_STASK_LISTS);

		smart_collapsableBar('createdlists', _AM_STASK_LISTS, _AM_STASK_LISTS_DSC);

		$objectTable = new SmartObjectTable($smarttask_list_handler);
		$objectTable->addColumn(new SmartObjectColumn('list_deadline', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('list_title', 'left', false, 'getAdminViewItemLink'));
		$objectTable->addColumn(new SmartObjectColumn('list_completed', 'center', 100));

		$objectTable->addIntroButton('addlist', 'list.php?op=mod', _AM_STASK_LIST_CREATE);

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


		$objectTable->render();

		smart_close_collapsable('createdlists');

		break;
}

smart_modFooter();
xoops_cp_footer();

?>