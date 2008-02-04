<?php
/**
* Classes responsible for managing SmartTask item objects
*
* @copyright	The SmartFactory http://www.smartfactory.ca
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @package		SmartTask
* @author		marcan <marcan@smartfactory.ca>
* @version		$Id$
*/

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobject.php";

class SmarttaskItem extends SmartObject {

    function SmarttaskItem(&$handler) {
    	$this->SmartObject($handler);

        $this->quickInitVar('item_itemid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('item_listid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('item_title', XOBJ_DTYPE_TXTBOX, true);
        $this->quickInitVar('item_description', XOBJ_DTYPE_TXTAREA);
        $this->quickInitVar('item_related_link', XOBJ_DTYPE_TXTBOX);
		$this->quickInitVar('item_owner_uid', XOBJ_DTYPE_INT);
		$this->quickInitVar('item_deadline', XOBJ_DTYPE_LTIME);
		$this->quickInitVar('item_completed', XOBJ_DTYPE_INT, false, '', '', false);

		$this->setControl('item_listid', array(
											'itemHandler' => 'list',
                                          	'method' => 'getList',
                                          	'module' => 'smarttask'
                                          ));
		$this->setControl('item_owner_uid', 'user');
		$this->setControl('item_completed', 'yesno');

    }

    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array('item_listid', 'item_owner_uid', 'item_completed'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

    function item_completed() {
    	$completed = $this->getVar('item_completed', 'e');
    	$img = $completed ? 'button_ok.png': 'button_cancel.png';
    	$alt = $completed ? _CO_SMARTTASK_IS_COMPLETED : _CO_SMARTTASK_NOT_COMPLETED;
    	return '<img src="' . SMARTOBJECT_IMAGES_URL . 'actions/' . $img . '" alt="' . $alt . '" title="' . $alt . '" style="vertical-align: middle;" />';
    }

    function item_listid() {
		$smart_registry = SmartObjectsRegistry::getInstance();
    	$ret = $this->getVar('item_listid', 'e');
		$obj = $smart_registry->getSingleObject('list', $ret, 'smarttask');

    	if (!$obj->isNew()) {
    		if (defined('XOOPS_CPFUNC_LOADED')) {
    			$ret = $obj->getAdminViewItemLink();
    		} else {
    			$ret = $obj->getItemLink();
    		}
    	}
    	return $ret;
    }

    function item_owner_uid() {
        return smart_getLinkedUnameFromId($this->getVar('item_owner_uid', 'e'), false, false, false);
    }
}
class SmarttaskItemHandler extends SmartPersistableObjectHandler {

    function SmarttaskItemHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'item', 'item_itemid', 'item_title', '', 'smarttask');
    }

    function getOwner_uids() {
		$member_handler = xoops_getHandler('member');

		$sql = 'SELECT DISTINCT item_owner_uid AS uid FROM ' . $this->table;
		$ret = $this->query($sql);
		foreach($ret as $uid) {
			$owner_uidsArray[] = $uid['uid'];
		}

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('uid', '(' . implode(', ', $owner_uidsArray) . ')', 'IN'));

		$usersArray = $member_handler->getUserList($criteria);
		$ret = array();
		$ret['default'] = _CO_SOBJECT_ANY;
		foreach($usersArray as $k=>$v) {
			$ret[$k] = $v;
		}
		return $ret;
    }

    function afterDelete(&$obj) {
		$smarttask_log_handler = xoops_getModuleHandler('log', 'smarttask');
		$item_itemid = $obj->getVar('item_itemid', 'e');
		return $smarttask_log_handler->deleteAllLogsFromItem($item_itemid);
    }

    function deleteAllItemsFromList($list_listid) {
    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('item_listid', $list_listid));

    	// delete all logs related to any items that we are about to delete
		$smarttask_log_handler = xoops_getModuleHandler('log', 'smarttask');
		$smarttask_log_handler->deleteAllLogsFromItems($this->getList($criteria));

    	return $this->deleteAll($criteria);
    }

}
?>