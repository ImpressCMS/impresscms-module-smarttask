<?php

/**
* $Id$
* Module: SmartTask
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

function smarttask_checkPermission($permission, $redirectUrl=false, $redirectMsg=false) {
	global $xoopsModuleConfig, $xoopsUser, $smart_previous_page;

	$user_groups = $xoopsUser->getGroups();

	$smarttask_team_groups = $xoopsModuleConfig['team_groups'];
	switch ($permission) {
		case 'list_add':
		case 'list_delete':
		case 'item_add':
		case 'item_delete':
		case 'log_add':
		case 'log_delete':
			if (count(array_intersect($smarttask_team_groups, $user_groups)) > 0) {
				return true;
			} else {
				if ($redirectUrl) {
					redirect_header($redirectUrl, 3, $redirectMsg);
				}
			}
		break;
	}
	return false;
}
?>