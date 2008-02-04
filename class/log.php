<?php
/**
* Classes responsible for managing SmartTask log objects
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

class SmarttaskLog extends SmartObject {

    function SmarttaskLog(&$handler) {
    	$this->SmartObject($handler);

        $this->quickInitVar('log_logid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('log_itemid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('log_date', XOBJ_DTYPE_STIME);
        $this->quickInitVar('log_uid', XOBJ_DTYPE_TXTBOX, true);
        $this->quickInitVar('log_message', XOBJ_DTYPE_TXTAREA);

		$this->setControl('log_itemid', array(
											'itemHandler' => 'item',
                                          	'method' => 'getList',
                                          	'module' => 'smarttask'
                                          ));
		$this->setControl('log_uid', 'user');
    }

    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array('log_itemid', 'log_uid'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

    function log_itemid() {
		$smart_registry = SmartObjectsRegistry::getInstance();
    	$ret = $this->getVar('log_itemid', 'e');
		$obj = $smart_registry->getSingleObject('item', $ret, 'smarttask');

    	if (!$obj->isNew()) {
    		if (defined('XOOPS_CPFUNC_LOADED')) {
    			$ret = $obj->getAdminViewItemLink();
    		} else {
    			$ret = $obj->getItemLink();
    		}
    	}
    	return $ret;
    }

    function log_uid() {
        return smart_getLinkedUnameFromId($this->getVar('log_uid', 'e'), false, false, false);
    }
}
class SmarttaskLogHandler extends SmartPersistableObjectHandler {

    function SmarttaskLogHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'log', 'log_logid', 'log_date', '', 'smarttask');
    }

    function deleteAllLogsFromItem($item_itemid) {
    	$criteria = new CriteriaCompo();
    	$criteria->add(new Criteria('log_itemid', $item_itemid));
    	return $this->deleteAll($criteria);
    }

	function deleteAllLogsFromItems($itemsArray) {
		foreach($itemsArray as $k=>$v) {
			$this->deleteAllLogsFromItem($k);
		}
	}
}
?>