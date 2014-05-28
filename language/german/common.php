<?php
/**
* English language constants commonly used in the module
*
* @copyright	The SmartFactory http://www.smartfactory.ca
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @package		SmartTask
* @author		marcan <marcan@smartfactory.ca>
* @version		$Id: common.php 837 2008-02-10 02:31:40Z malanciault $
*/

/**  Text edited by RJB on 3/10/07 */
if (!defined("XOOPS_ROOT_PATH")) {
 	die("ImpressCMS Root Pfad nicht definiert");
}

// general
define("_CO_SMARTTASK_IS_COMPLETED", "Vollständig");
define("_CO_SMARTTASK_NOT_COMPLETED", "Nicht Vollständig");

// list
define("_CO_SMARTTASK_LIST_LIST_TITLE", "Name des Projektes");
define("_CO_SMARTTASK_LIST_LIST_TITLE_DSC", "");
define("_CO_SMARTTASK_LIST_LIST_DESCRIPTION", "Beschreibung");
define("_CO_SMARTTASK_LIST_LIST_DESCRIPTION_DSC", "");
define("_CO_SMARTTASK_LIST_LIST_DEADLINE", "Stichtag");
define("_CO_SMARTTASK_LIST_LIST_DEADLINE_DSC", "Wann sollte die Aufgabe erledigt sein?");
define("_CO_SMARTTASK_LIST_LIST_COMPLETED", "Vollständig");
define("_CO_SMARTTASK_LIST_LIST_COMPLETED_DSC", "Wurde die Aufgabe vollständig erledigt?");

define("_CO_SMARTTASK_LIST_ADD_NOPERM", "Sie haben nicht die erfoderliche Berechtigung.");
define("_CO_SMARTTASK_LIST_DELETE_NOPERM", "Sie haben nicht die erfoderliche Berechtigung.");

define("_CO_SMARTTASK_LIST_FILTER_COMPLETED", "Vollständig");
define("_CO_SMARTTASK_LIST_FILTER_NOT_COMPLETED", "Nicht Vollständig");

// item
define("_CO_SMARTTASK_ITEM_ITEM_TITLE", "Titel");
define("_CO_SMARTTASK_ITEM_ITEM_TITLE_DSC", "");
define("_CO_SMARTTASK_ITEM_ITEM_LISTID", "Projekt");
define("_CO_SMARTTASK_ITEM_ITEM_LISTID_DSC", "Aufgabe zu einem Projekt zuordnen");
define("_CO_SMARTTASK_ITEM_ITEM_DESCRIPTION", "Beschreibung");
define("_CO_SMARTTASK_ITEM_ITEM_DESCRIPTION_DSC", "");
define("_CO_SMARTTASK_ITEM_ITEM_RELATED_LINK", "zugehöriger Weblink");
define("_CO_SMARTTASK_ITEM_ITEM_RELATED_LINK_DSC", "");
define("_CO_SMARTTASK_ITEM_ITEM_OWNER_UID", "Eigentümer");
define("_CO_SMARTTASK_ITEM_ITEM_OWNER_UID_DSC", "");
define("_CO_SMARTTASK_ITEM_ITEM_DEADLINE", "Stichtag");
define("_CO_SMARTTASK_ITEM_ITEM_DEADLINE_DSC", "");
define("_CO_SMARTTASK_ITEM_ITEM_COMPLETED", "Vollständig");
define("_CO_SMARTTASK_ITEM_ITEM_COMPLETED_DSC", "");

define("_CO_SMARTTASK_ITEM_ADD_NOPERM", "Sie haben nicht die erfoderliche Berechtigung.");
define("_CO_SMARTTASK_ITEM_DELETE_NOPERM", "Sie haben nicht die erfoderliche Berechtigung.");

// log
define("_CO_SMARTTASK_LOG_LOG_ITEMID", "Aufgabe");
define("_CO_SMARTTASK_LOG_LOG_ITEMID_DSC", "Protokoll einer Aufgabe zuordnen");
define("_CO_SMARTTASK_LOG_LOG_DATE", "Datum");
define("_CO_SMARTTASK_LOG_LOG_DATE_DSC", "");
define("_CO_SMARTTASK_LOG_LOG_UID", "Mitglied");
define("_CO_SMARTTASK_LOG_LOG_UID_DSC", "");
define("_CO_SMARTTASK_LOG_LOG_MESSAGE", "Nachricht");
define("_CO_SMARTTASK_LOG_LOG_MESSAGE_DSC", "");

define("_CO_SMARTTASK_LOG_ADD_NOPERM", "Sie haben nicht die erfoderliche Berechtigung.");
define("_CO_SMARTTASK_LOG_DELETE_NOPERM", "Sie haben nicht die erfoderliche Berechtigung.");

// 1.1 alpha changes
define('_CO_SMARTTASK_LIST_FILTER_ANY', '(Alle)');
define('_CO_SMARTTASK_LIST_FILTER_MYSELF', 'Meine');
define('_CO_SOBJECT_EDITING', 'Edit');