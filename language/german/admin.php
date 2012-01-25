<?php
/**
* English language constants used in admin section of the module
*
* @copyright	The SmartFactory http://www.smartfactory.ca
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @package		SmartTask
* @author		marcan <marcan@smartfactory.ca>
* @version		$Id: admin.php 796 2008-02-04 22:01:02Z malanciault $
*/

if (!defined("XOOPS_ROOT_PATH")) {
 	die("ImpressCMS Root Pfad nicht definiert");
}

// general
define("_AM_STASK_INDEX", "Index");
define("_AM_STASK_LISTS", "Projekte");
define("_AM_STASK_ITEMS", "Aufgaben");
define("_AM_STASK_LOGS", "Protokoll");
define("_AM_STASK_FIRST_USE", "Dies ist der erste Zugriff auf das Modul. Das Modul aktualisiert sich selbstständig und erstellt dynamisch das Datenbankschema an.");

// List
define("_AM_STASK_LISTS_DSC", "Alle Projekte");
define("_AM_STASK_LIST_CREATE", "Neues Projekt");
define("_AM_STASK_LIST", "Projekte");
define("_AM_STASK_LIST_CREATE_INFO", "Zum Erstellen eines Projektes das Formular ausfüllen.");
define("_AM_STASK_LIST_EDIT", "Projekt bearbeiten");
define("_AM_STASK_LIST_EDIT_INFO", "Zum Bearbeiten dieses Projektes das Formular ausfüllen.");
define("_AM_STASK_LIST_MODIFIED", "Das Projekt wurde erfolgreich geändert.");
define("_AM_STASK_LIST_CREATED", "Projekt wurde erstellt.");
define("_AM_STASK_LIST_VIEW", "Projektinfo");
define("_AM_STASK_LIST_VIEW_DSC", "Info zu diesem Projekt.");

// Item
define("_AM_STASK_ITEMS_DSC", "Alle Aufgaben");
define("_AM_STASK_ITEMS_IN_LIST_DSC", "Alle Aufgaben zu diesem Projekt.");
define("_AM_STASK_ITEM_CREATE", "Aufgabe hinzufügen");
define("_AM_STASK_ITEM", "Aufgabe");
define("_AM_STASK_ITEM_CREATE_INFO", "Zum Erstellen einer Aufgabe das Formular ausfüllen.");
define("_AM_STASK_ITEM_EDIT", "Aufgabe bearbeiten");
define("_AM_STASK_ITEM_EDIT_INFO", "Zum Bearbeiten dieser Aufgabe das Formular ausfüllen.");
define("_AM_STASK_ITEM_MODIFIED", "Die Aufgabe wurde erfolgreich geändert.");
define("_AM_STASK_ITEM_CREATED", "Die Aufgabe wurde erstellt.");
define("_AM_STASK_ITEM_VIEW", "Aufgaben Info");
define("_AM_STASK_ITEM_VIEW_DSC", "Info über diesen Aufgabe.");

// Log
define("_AM_STASK_LOGS_DSC", "Alle Protokolle aus dem Modul");
define("_AM_STASK_LOGS_IN_ITEM_DSC", "Log messages related to this item");
define("_AM_STASK_LOG_CREATE", "Protokoll hinzufügen");
define("_AM_STASK_LOG", "Protokoll");
define("_AM_STASK_LOG_CREATE_INFO", "Zum Erstellen eines Protkolls das Formular ausfüllen.");
define("_AM_STASK_LOG_EDIT", "Protokoll bearbeiten");
define("_AM_STASK_LOG_EDIT_INFO", "Zum Bearbeiten des Protkolls das Formular ausfüllen.");
define("_AM_STASK_LOG_MODIFIED", "Das Protokoll wurde erfolgreich geändert.");
define("_AM_STASK_LOG_CREATED", "Das Protokoll wurde erstellt.");
define("_AM_STASK_LOG_VIEW", "Protokoll Info");
define("_AM_STASK_LOG_VIEW_DSC", "Info über das Protokoll.");
?>