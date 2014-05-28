<?php
/**
* Classes responsible for managing SmartTask log objects
*
* @copyright	The SmartFactory http://www.smartfactory.ca
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.ICMS
* @package		SmartTask
* @author		marcan <marcan@smartfactory.ca>
* @version		$Id: log.php 23265 2012-01-25 07:50:44Z sato-san $
*/

if (!defined("ICMS_ROOT_PATH")) {
    die("ICMS root path not defined");
}

class SmarttaskLog extends icms_ipf_Object {

    function __construct(&$handler) {
    	$this->IcmsPersistableObject($handler);

        $this->quickInitVar('log_logid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('log_itemid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('log_date', XOBJ_DTYPE_LTIME);
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
		require_once ICMS_ROOT_PATH . '/kernel/icmspersistableregistry.php';
		$smart_registry = IcmsPersistableRegistry::getInstance();
    	$ret = $this->getVar('log_itemid', 'e');
		$obj = $smart_registry->getSingleObject('item', $ret, 'smarttask');

    	if (!$obj->isNew()) {
    		if (defined('ICMS_CPFUNC_LOADED')) {
    			$ret = $obj->getAdminViewItemLink();
    		} else {
    			$ret = $obj->getItemLink();
    		}
    	}
    	return $ret;
    }

    function log_uid() {
		$uid = intval($this->getVar('log_uid', 'e'));
		if ($uid === 0) return '-';
		$user_handler = &xoops_getHandler('user');
		$user = &$user_handler->get($uid);
        return is_object($user)?$user->getVar('uname'):'???';	       
    }
}
class SmarttaskLogHandler extends IcmsPersistableObjectHandler {

    function SmarttaskLogHandler($db) {
        $this->IcmsPersistableObjectHandler($db, 'log', 'log_logid', 'log_date', '', 'smarttask');
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