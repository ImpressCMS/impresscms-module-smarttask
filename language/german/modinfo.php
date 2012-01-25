<?php

/**
* $Id: modinfo.php 837 2008-02-10 02:31:40Z malanciault $
* Module: SmartTask
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

/**  not edited by RJB on 3/10/07 */

if (!defined("XOOPS_ROOT_PATH")) {
 	die("ImpressCMS Root Pfad nicht definiert");
}

// Module Info
// The name of this module

global $xoopsModule;
define("_MI_STASK_MD_NAME", "Aufgaben");
define("_MI_STASK_MD_DESC", "Einfachen Verwaltung einer TODO-Listen in Ihrer Webseite");

define("_MI_STASK_INDEX", "Index");
define("_MI_STASK_LISTS", "Projekte");
define("_MI_STASK_ITEMS", "Aufgaben");
define("_MI_STASK_LOGS", "Protokoll");

define("_MI_STASK_TEAM_GR", "Gruppen");
define("_MI_STASK_TEAM_GRDSC", "Auswählen, welche Gruppe(n) Zugriff auf das Modul erhalten dürfen. Die Mitglieder dieser Gruppe dürfen Projekte und Aufgaben erstellen, bearbeiten und löschen in der Webseite.");

// 1.1 alpha changes
define('_MI_STASK_ACTION_GR', 'Action groups');
define('_MI_STASK_ACTION_GRDSC', 'From what groups users can do anything?');

// Added in 1.1RC
define("_MI_STASK_TEMPLATES", "Templates");