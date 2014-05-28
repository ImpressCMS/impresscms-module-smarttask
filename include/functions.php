<?php
/**
* $Id: functions.php 20145 2010-09-15 13:06:09Z mekdrop $
* Module: SmartTask
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("ICMS_ROOT_PATH")) {
	die("ICMS root path not defined");
}

function smarttask_checkPermission($permission, $redirectUrl = FALSE, $redirectMsg = FALSE) {
	global $icmsModuleConfig, $smart_previous_page;

	if (is_object(icms::$user)) {
		$user_groups = icms::$user->getGroups();
	} else {
		$user_groups = array(ICMS_GROUP_ANONYMOUS);
	}

	$smarttask_team_groups = $icmsModuleConfig['team_groups'];
	switch ($permission) {
		case 'list_add':
		case 'list_delete':
		case 'item_add':
		case 'item_delete':
		case 'log_add':
		case 'log_delete':
			if (count(array_intersect($smarttask_team_groups, $user_groups)) > 0) {
				return TRUE;
			} else {
				if ($redirectUrl) {
					redirect_header($redirectUrl, 3, $redirectMsg);
				}
			}
		break;
	}
	return FALSE;
}
