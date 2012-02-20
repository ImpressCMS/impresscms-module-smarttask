<?php
/**
* English language constants commonly used in the module
*
* @copyright	The SmartFactory http://www.smartfactory.ca
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @package		SmartTask
* @author		marcan <marcan@smartfactory.ca>
* @version		$Id$
*/

/**  Text edited by RJB on 3/10/07 */
if (!defined("ICMS_ROOT_PATH")) {
 	die("ICMS root path not defined");
}

// general
define("_CO_SMARTTASK_IS_COMPLETED", "Completed");
define("_CO_SMARTTASK_NOT_COMPLETED", "Not completed");

// list
define("_CO_SMARTTASK_LIST_LIST_TITLE", "Title");
define("_CO_SMARTTASK_LIST_LIST_TITLE_DSC", "");
define("_CO_SMARTTASK_LIST_LIST_DESCRIPTION", "Description");
define("_CO_SMARTTASK_LIST_LIST_DESCRIPTION_DSC", "");
define("_CO_SMARTTASK_LIST_LIST_DEADLINE", "Deadline");
define("_CO_SMARTTASK_LIST_LIST_DEADLINE_DSC", "");
define("_CO_SMARTTASK_LIST_LIST_COMPLETED", "Completed");
define("_CO_SMARTTASK_LIST_LIST_COMPLETED_DSC", "");

define("_CO_SMARTTASK_LIST_ADD_NOPERM", "You do not have permission to add or edit a list.");
define("_CO_SMARTTASK_LIST_DELETE_NOPERM", "You do not have permission to delete this list.");

define("_CO_SMARTTASK_LIST_FILTER_COMPLETED", "Completed");
define("_CO_SMARTTASK_LIST_FILTER_NOT_COMPLETED", "Not completed");

// item
define("_CO_SMARTTASK_ITEM_ITEM_TITLE", "Title");
define("_CO_SMARTTASK_ITEM_ITEM_TITLE_DSC", "");
define("_CO_SMARTTASK_ITEM_ITEM_LISTID", "List");
define("_CO_SMARTTASK_ITEM_ITEM_LISTID_DSC", "");
define("_CO_SMARTTASK_ITEM_ITEM_DESCRIPTION", "Description");
define("_CO_SMARTTASK_ITEM_ITEM_DESCRIPTION_DSC", "");
define("_CO_SMARTTASK_ITEM_ITEM_RELATED_LINK", "Related link");
define("_CO_SMARTTASK_ITEM_ITEM_RELATED_LINK_DSC", "");
define("_CO_SMARTTASK_ITEM_ITEM_OWNER_UID", "Owner");
define("_CO_SMARTTASK_ITEM_ITEM_OWNER_UID_DSC", "");
define("_CO_SMARTTASK_ITEM_ITEM_DEADLINE", "Deadline");
define("_CO_SMARTTASK_ITEM_ITEM_DEADLINE_DSC", "");
define("_CO_SMARTTASK_ITEM_ITEM_COMPLETED", "Completed");
define("_CO_SMARTTASK_ITEM_ITEM_COMPLETED_DSC", "");

define("_CO_SMARTTASK_ITEM_ADD_NOPERM", "You do not have permission to add or edit an item.");
define("_CO_SMARTTASK_ITEM_DELETE_NOPERM", "You do not have permission to delete this item.");

// log
define("_CO_SMARTTASK_LOG_LOG_ITEMID", "Item");
define("_CO_SMARTTASK_LOG_LOG_ITEMID_DSC", "");
define("_CO_SMARTTASK_LOG_LOG_DATE", "Date");
define("_CO_SMARTTASK_LOG_LOG_DATE_DSC", "");
define("_CO_SMARTTASK_LOG_LOG_UID", "User");
define("_CO_SMARTTASK_LOG_LOG_UID_DSC", "");
define("_CO_SMARTTASK_LOG_LOG_MESSAGE", "Message");
define("_CO_SMARTTASK_LOG_LOG_MESSAGE_DSC", "");

define("_CO_SMARTTASK_LOG_ADD_NOPERM", "You do not have permission to add or edit a log.");
define("_CO_SMARTTASK_LOG_DELETE_NOPERM", "You do not have permission to delete this log.");

// 1.1 alpha changes
define('_CO_SMARTTASK_LIST_FILTER_ANY', '(any)');
define('_CO_SMARTTASK_LIST_FILTER_MYSELF', 'My');
define('_CO_SOBJECT_EDITING', 'Edit');