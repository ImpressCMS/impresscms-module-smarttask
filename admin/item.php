<?php

/**
* Item, add, edit and delete item objects
*
* @copyright	The SmartFactory http://www.smartfactory.ca
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @package		SmartTask
* @author		marcan <marcan@smartfactory.ca>
* @version		$Id$
*/

function edititem($showmenu = false, $item_itemid = 0, $parentid =0)
{
	global $smarttask_item_handler;

	$itemObj = $smarttask_item_handler->get($item_itemid);

	$item_listid = isset($_GET['item_listid']) ? intval($_GET['item_listid']) : 0;
	$itemObj->setVar('item_listid', $item_listid);

	if (!$itemObj->isNew()){

		if ($showmenu) {
			smart_adminMenu(1, _AM_STASK_ITEMS . " > " . _CO_SOBJECT_EDITING);
		}
		smart_collapsableBar('itemedit', _AM_STASK_ITEM_EDIT, _AM_STASK_ITEM_EDIT_INFO);

		$sform = $itemObj->getForm(_AM_STASK_ITEM_EDIT, 'additem');
		$sform->display();
		smart_close_collapsable('itemedit');
	} else {
		if ($showmenu) {
			smart_adminMenu(1, _AM_STASK_ITEMS . " > " . _CO_SOBJECT_CREATINGNEW);
		}
		smart_collapsableBar('itemcreate', _AM_STASK_ITEM_CREATE, _AM_STASK_ITEM_CREATE_INFO);
		$sform = $itemObj->getForm(_AM_STASK_ITEM_CREATE, 'additem');
		$sform->display();
		smart_close_collapsable('itemcreate');
	}
}

include_once("admin_header.php");
include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";

$smarttask_item_handler = xoops_getModuleHandler('item');
$smarttask_log_handler= xoops_getModuleHandler('log');

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

$item_itemid = isset($_GET['item_itemid']) ? intval($_GET['item_itemid']) : 0 ;

switch ($op) {
	case "mod":
	case "changedField":

		smart_xoops_cp_header();

		edititem(true, $item_itemid);
		break;
	case "additem":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smarttask_item_handler);
		$controller->storeFromDefaultForm(_AM_STASK_ITEM_CREATED, _AM_STASK_ITEM_MODIFIED);

		break;

	case "del":
	    include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smarttask_item_handler);
		$controller->handleObjectDeletion();

		break;

	case "view" :
		$itemObj = $smarttask_item_handler->get($item_itemid);

		smart_xoops_cp_header();
		smart_adminMenu(1, _AM_STASK_ITEM_VIEW . ' > ' . $itemObj->getVar('item_title'));

		smart_collapsableBar('itemview', $itemObj->getVar('item_title') . $itemObj->getEditItemLink(), _AM_STASK_ITEM_VIEW_DSC);

		$itemObj->displaySingleObject();

		smart_close_collapsable('itemview');

		smart_collapsableBar('itemview_logs', _AM_STASK_LOGS, _AM_STASK_LOGS_IN_ITEM_DSC);

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('log_itemid', $item_itemid));

		$objectTable = new SmartObjectTable($smarttask_log_handler, $criteria);
		$objectTable->addColumn(new SmartObjectColumn('log_date', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('log_message'));
		$objectTable->addColumn(new SmartObjectColumn('log_uid', 'left', 150));

		$objectTable->addIntroButton('addlog', 'log.php?op=mod&log_itemid=' . $item_itemid, _AM_STASK_LOG_CREATE);

		$objectTable->render();

		smart_close_collapsable('itemview_logs');

		break;

	default:

		smart_xoops_cp_header();

		smart_adminMenu(1, _AM_STASK_ITEMS);

		smart_collapsableBar('createditems', _AM_STASK_ITEMS, _AM_STASK_ITEMS_DSC);

		include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
		$objectTable = new SmartObjectTable($smarttask_item_handler);
		$objectTable->addColumn(new SmartObjectColumn('item_title', 'left', 150));
		$objectTable->addColumn(new SmartObjectColumn('item_listid', 'left', false, 'getAdminViewItemLink'));
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

		$objectTable->addIntroButton('additem', 'item.php?op=mod', _AM_STASK_ITEM_CREATE);

		$objectTable->addQuickSearch(array('item_title', 'item_description'));

		$objectTable->render();

		smart_close_collapsable('createditems');

		break;
}

smart_modFooter();
xoops_cp_footer();

?>