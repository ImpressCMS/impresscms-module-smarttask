<?php
/**
* Classes responsible for managing SmartTask list objects
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

class SmarttaskList extends SmartObject {

    function SmarttaskList(&$handler) {
    	$this->SmartObject($handler);

        $this->quickInitVar('list_listid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('list_title', XOBJ_DTYPE_TXTBOX, true);
        $this->quickInitVar('list_deadline', XOBJ_DTYPE_LTIME, true);
        $this->quickInitVar('list_description', XOBJ_DTYPE_TXTAREA);
        $this->quickInitVar('list_completed', XOBJ_DTYPE_INT, false, '', '', false);

        $this->setControl('list_completed', 'yesno');
    }

    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array('list_completed'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

    function list_completed() {
    	$completed = $this->getVar('list_completed', 'e');
    	$img = $completed ? 'button_ok.png': 'button_cancel.png';
    	$alt = $completed ? _CO_SMARTTASK_IS_COMPLETED : _CO_SMARTTASK_NOT_COMPLETED;
    	return '<img src="' . SMARTOBJECT_IMAGES_URL . 'actions/' . $img . '" alt="' . $alt . '" title="' . $alt . '" style="vertical-align: middle;" />';
    }

}

class SmarttaskListHandler extends SmartPersistableObjectHandler {

    function SmarttaskListHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'list', 'list_listid', 'list_title', '', 'smarttask');
    }

    function afterDelete(&$obj) {
		$smarttask_item_handler = xoops_getModuleHandler('item', 'smarttask');
		$list_listid = $obj->getVar('list_listid', 'e');
		return $smarttask_item_handler->deleteAllItemsFromList($list_listid);
    }
}
?>