<?php
/**
* English language constants used in admin section of the module
*
* @copyright	The SmartFactory http://www.smartfactory.ca
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @package		SmartTask
* @author		marcan <marcan@smartfactory.ca>
* @version		$Id: admin.php 23265 2012-01-25 07:50:44Z sato-san $
*/

if (!defined("ICMS_ROOT_PATH")) {
 	die("ICMS root path not defined");
}

// general
define("_AM_STASK_INDEX", "Index");
define("_AM_STASK_LISTS", "Projects");
define("_AM_STASK_ITEMS", "Tasks");
define("_AM_STASK_LOGS", "Logs");
define("_AM_STASK_FIRST_USE", "This is the first time you access this module. Please update the module in order to dynamically create the database scheme.");

// Project
define("_AM_STASK_LISTS_DSC", "All projects in the module");
define("_AM_STASK_LIST_CREATE", "Add a project");
define("_AM_STASK_LIST", "Project");
define("_AM_STASK_LIST_CREATE_INFO", "Fill-out the following form to create a new project.");
define("_AM_STASK_LIST_EDIT", "Edit this project");
define("_AM_STASK_LIST_EDIT_INFO", "Fill-out the following form in order to edit this project.");
define("_AM_STASK_LIST_MODIFIED", "The project was successfully modified.");
define("_AM_STASK_LIST_CREATED", "The project has been successfully created.");
define("_AM_STASK_LIST_VIEW", "Project info");
define("_AM_STASK_LIST_VIEW_DSC", "Here is the info about this project.");

// Task
define("_AM_STASK_ITEMS_DSC", "All tasks in the module");
define("_AM_STASK_ITEMS_IN_LIST_DSC", "Tasks related to this project.");
define("_AM_STASK_ITEM_CREATE", "Add an task");
define("_AM_STASK_ITEM", "Task");
define("_AM_STASK_ITEM_CREATE_INFO", "Fill-out the following form to create a new task.");
define("_AM_STASK_ITEM_EDIT", "Edit this task");
define("_AM_STASK_ITEM_EDIT_INFO", "Fill-out the following form in order to edit this task.");
define("_AM_STASK_ITEM_MODIFIED", "The task was successfully modified.");
define("_AM_STASK_ITEM_CREATED", "The task has been successfully created.");
define("_AM_STASK_ITEM_VIEW", "Task info");
define("_AM_STASK_ITEM_VIEW_DSC", "Here is the info about this task.");

// Log
define("_AM_STASK_LOGS_DSC", "All logs in the module");
define("_AM_STASK_LOGS_IN_ITEM_DSC", "Log messages related to this task");
define("_AM_STASK_LOG_CREATE", "Add a log");
define("_AM_STASK_LOG", "Log");
define("_AM_STASK_LOG_CREATE_INFO", "Fill-out the following form to create a new log.");
define("_AM_STASK_LOG_EDIT", "Edit this log");
define("_AM_STASK_LOG_EDIT_INFO", "Fill-out the following form in order to edit this log.");
define("_AM_STASK_LOG_MODIFIED", "The log was successfully modified.");
define("_AM_STASK_LOG_CREATED", "The log has been successfully created.");
define("_AM_STASK_LOG_VIEW", "Log info");
define("_AM_STASK_LOG_VIEW_DSC", "Here is the info about this log.");
?>