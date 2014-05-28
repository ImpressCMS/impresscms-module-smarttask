<?php

/**
* $Id: modinfo.php 23265 2012-01-25 07:50:44Z sato-san $
* Module: SmartTask
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

/**  not edited by RJB on 3/10/07 */

if (!defined("ICMS_ROOT_PATH")) {
 	die("ICMS root path not defined");
}

// Module Info
// The name of this module

global $xoopsModule;
define("_MI_STASK_MD_NAME", "SmartTask");
define("_MI_STASK_MD_DESC", "Easily manage your TODO Lists within your site");

define("_MI_STASK_INDEX", "Index");
define("_MI_STASK_LISTS", "Projects");
define("_MI_STASK_ITEMS", "Tasks");
define("_MI_STASK_LOGS", "Logs");

define("_MI_STASK_TEAM_GR", "Team groups");
define("_MI_STASK_TEAM_GRDSC", "These groups will be considered as the users in your team. These groups will have permissions to create, edit and delete lists and items on the user side.");

// 1.1 alpha changes
define('_MI_STASK_ACTION_GR', 'Action groups');
define('_MI_STASK_ACTION_GRDSC', 'From what groups users can do anything?');

// Added in 1.1RC
define("_MI_STASK_TEMPLATES", "Templates");