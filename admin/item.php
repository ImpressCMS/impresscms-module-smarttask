<?php

/**
* Item, add, edit and delete item objects
*
* @copyright	The SmartFactory http://www.smartfactory.ca
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @package		SmartTask
* @author		marcan <marcan@smartfactory.ca>
* @version		$Id: item.php 23265 2012-01-25 07:50:44Z sato-san $
*/

function edititem($showmenu = false, $item_itemid = 0, $parentid =0)
{
	global $smarttask_item_handler;

	$itemObj = $smarttask_item_handler->get($item_itemid);

	$item_listid = isset($_GET['item_listid']) ? intval($_GET['item_listid']) : 0;
	$itemObj->setVar('item_listid', $item_listid);

	if (!$itemObj->isNew()){

		if ($showmenu) {
			icms_adminMenu(1, _AM_STASK_ITEMS . " > " . _CO_SOBJECT_EDITING);
		}
		icms_collapsableBar('itemedit', _AM_STASK_ITEM_EDIT, _AM_STASK_ITEM_EDIT_INFO);

		$sform = $itemObj->getForm(_AM_STASK_ITEM_EDIT, 'additem');
		$sform->display();
		icms_close_collapsable('itemedit');
	} else {
		if ($showmenu) {
			icms_adminMenu(1, _AM_STASK_ITEMS );
		}
		icms_collapsableBar('itemcreate', _AM_STASK_ITEM_CREATE, _AM_STASK_ITEM_CREATE_INFO);
		$sform = $itemObj->getForm(_AM_STASK_ITEM_CREATE, 'additem');
		$sform->display();
		icms_close_collapsable('itemcreate');
	}
}

include_once("admin_header.php");

$smarttask_item_handler = icms_getModuleHandler('item', basename(dirname(dirname(__FILE__))), "smarttask");
$smarttask_log_handler= icms_getModuleHandler('log', basename(dirname(dirname(__FILE__))), "smarttask");

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

$item_itemid = isset($_GET['item_itemid']) ? intval($_GET['item_itemid']) : 0 ;

switch ($op) {
	case "mod":
	case "changedField":

		icms_cp_header();

		edititem(true, $item_itemid);
		break;
	case "additem":
        include_once ICMS_ROOT_PATH . '/kernel/icmspersistablecontroller.php';
        $controller = new IcmsPersistableController($smarttask_item_handler);
		$controller->storeFromDefaultForm(_AM_STASK_ITEM_CREATED, _AM_STASK_ITEM_MODIFIED);

		break;

	case "del":
	    include_once ICMS_ROOT_PATH . '/kernel/icmspersistablecontroller.php';
        $controller = new IcmsPersistableController($smarttask_item_handler);
		$controller->handleObjectDeletion();

		break;

	case "view" :
		$itemObj = $smarttask_item_handler->get($item_itemid);

		icms_cp_header();
		icms_adminMenu(1, _AM_STASK_ITEM_VIEW . ' > ' . $itemObj->getVar('item_title'));

		icms_collapsableBar('itemview', $itemObj->getVar('item_title') . $itemObj->getEditItemLink(), _AM_STASK_ITEM_VIEW_DSC);

		$itemObj->displaySingleObject();

		icms_close_collapsable('itemview');

		icms_collapsableBar('itemview_logs', _AM_STASK_LOGS, _AM_STASK_LOGS_IN_ITEM_DSC);

		include_once ICMS_ROOT_PATH."/kernel/icmspersistabletable.php";

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('log_itemid', $item_itemid));

		$objectTable = new IcmsPersistableTable($smarttask_log_handler, $criteria);
		$objectTable->addColumn(new IcmsPersistableColumn('log_date', 'left', 150));
		$objectTable->addColumn(new IcmsPersistableColumn('log_message'));
		$objectTable->addColumn(new IcmsPersistableColumn('log_uid', 'left', 150));

		$objectTable->addIntroButton('addlog', 'log.php?op=mod&log_itemid=' . $item_itemid, _AM_STASK_LOG_CREATE);

		$objectTable->render();

		icms_close_collapsable('itemview_logs');

		break;

	default:

		icms_cp_header();

		icms_adminMenu(1, _AM_STASK_ITEMS);

		icms_collapsableBar('createditems', _AM_STASK_ITEMS, _AM_STASK_ITEMS_DSC);

		include_once ICMS_ROOT_PATH."/kernel/icmspersistabletable.php";

		$objectTable = new IcmsPersistableTable($smarttask_item_handler);
		$objectTable->addColumn(new IcmsPersistableColumn('item_deadline', 'left', 150 ));
		$objectTable->addColumn(new IcmsPersistableColumn('item_title', 'left', false, 'getAdminViewItemLink'));
		$objectTable->addColumn(new IcmsPersistableColumn('item_listid', 'left', 150 ));
		$objectTable->addColumn(new IcmsPersistableColumn('item_owner_uid', 'left', 150));
		$objectTable->addColumn(new IcmsPersistableColumn('item_completed', 'center', 100));

		$objectTable->setDefaultSort('item_deadline');
		$objectTable->setDefaultOrder('ASC');

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

		icms_close_collapsable('createditems');

		break;
}


icms_cp_footer();

?>