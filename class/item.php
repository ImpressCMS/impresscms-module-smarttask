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

if (!defined("ICMS_ROOT_PATH")) {
    die("ICMS root path not defined");
}

class SmarttaskItem extends icms_ipf_Object {

    function __construct(&$handler) {
    	$this->IcmsPersistableObject($handler);

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
		$this->setControl('item_owner_uid', array(
											'object' => $this,
											'method' => 'getPossibleUsers'
											/*'itemHandler' => 'item',
                                          	'method' => 'getPossibleUsers',
                                          	'module' => 'smarttask'*/
                                          ));
		$this->setControl('item_completed', 'yesno');


    }

    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array('item_listid', 'item_owner_uid', 'item_completed', 'item_deadline'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

	public function getPossibleUsers() {
		//static $users = null;
		//if ($users === null) {
			// Creating the SmartModule object
			$module_handler = &xoops_getHandler('module');
			$smarttaskModule =&$module_handler->getByDirname(SMARTTASK_DIRNAME);
			// Creating the SmartModule config Object
			$icmsConfigHandler = &xoops_getHandler('config');
			$smarttaskConfig =&$icmsConfigHandler->getConfigsByCat(0, $smarttaskModule->getVar('mid'));
			// getting action user groups
			$member_handler = &xoops_getHandler('member');
			$tusers = &$member_handler->getUsersByGroupLink($smarttaskConfig['action_groups'], null, true);
			$users = array();
			foreach ($tusers as $user) {
				$users[$user->getVar('uid')] = $user->getVar('uname');
			}
			$owner_id = intval($this->getVar('item_owner_uid', 'e'));
			if ($owner_id > 0) {
				if (!isset($users[$owner_id])) {
					$users[$owner_id] = $this->item_owner_uid();
				}
			}
		//}
		return $users;
	}

	function item_deadline() {
		$time = intval($this->getVar('item_deadline', 'e'));
		return ($time>0)?formatTimestamp($time):'-';
	}

    function item_completed() {
    	$completed = $this->getVar('item_completed', 'e');
    	$img = $completed ? 'button_ok.png': 'button_cancel.png';
    	$alt = $completed ? _CO_SMARTTASK_IS_COMPLETED : _CO_SMARTTASK_NOT_COMPLETED;
    	return '<img src="' . ICMS_IMAGES_SET_URL . '/actions/' . $img . '" alt="' . $alt . '" title="' . $alt . '" style="vertical-align: middle;" />';
    }

    function item_listid() {
		require_once ICMS_ROOT_PATH . '/kernel/icmspersistableregistry.php';
		$smart_registry = IcmsPersistableRegistry::getInstance();
    	$ret = $this->getVar('item_listid', 'e');
		$obj = $smart_registry->getSingleObject('list', $ret, 'smarttask');

    	if (!$obj->isNew()) {
    		if (defined('ICMS_CPFUNC_LOADED')) {
    			$ret = $obj->getAdminViewItemLink();
    		} else {
    			$ret = $obj->getItemLink();
    		}
    	}
    	return $ret;
    }

    function item_owner_uid() {
		$uid = intval($this->getVar('item_owner_uid', 'e'));
		if ($uid === 0) return '-';
		$user_handler = &xoops_getHandler('user');
		$user = &$user_handler->get($uid);
        return is_object($user)?$user->getVar('uname'):'???';
    }
}
class SmarttaskItemHandler extends IcmsPersistableObjectHandler {

    function SmarttaskItemHandler($db) {
        $this->IcmsPersistableObjectHandler($db, 'item', 'item_itemid', 'item_title', '', 'smarttask');
    }

    function getOwner_uids() {
		$member_handler = xoops_getHandler('member');

		$sql = 'SELECT DISTINCT item_owner_uid AS uid FROM ' . $this->table;
		$ret = $this->db->query($sql);
		while($uid = $this->db->fetchArray($ret)) {
			$owner_uidsArray[] = $uid['uid'];
		}

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('uid', '(' . implode(', ', $owner_uidsArray) . ')', 'IN'));

		$usersArray = $member_handler->getUserList($criteria);
		$ret = array();
		$ret['default'] = _CO_SMARTTASK_LIST_FILTER_ANY;
		foreach($usersArray as $k=>$v) {
			$ret[$k] = $v;
		}
		return $ret;
    }

    function afterDelete(&$obj) {
		$smarttask_log_handler = icms_getModuleHandler('log', 'smarttask');
		$item_itemid = $obj->getVar('item_itemid', 'e');
		return $smarttask_log_handler->deleteAllLogsFromItem($item_itemid);
    }

    function deleteAllItemsFromList($list_listid) {
    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('item_listid', $list_listid));

    	// delete all logs related to any items that we are about to delete
		$smarttask_log_handler = icms_getModuleHandler('log', 'smarttask');
		$smarttask_log_handler->deleteAllLogsFromItems($this->getList($criteria));

    	return $this->deleteAll($criteria);
    }

}
?>