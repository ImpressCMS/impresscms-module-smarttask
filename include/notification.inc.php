<?php

/**
* $Id$
* Module: SmartPartner
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function smarttask_notify_iteminfo($category, $item_id)
{
	// This must contain the name of the folder in which reside SmartPartner
	if( !defined("SMARTPARTNER_DIRNAME") ){
		define("SMARTPARTNER_DIRNAME", 'smarttask');
	}

	global $icmsModule, $icmsModuleConfig, $icmsConfig;

    if (empty($icmsModule) || $icmsModule->getVar('dirname') != SMARTPARTNER_DIRNAME) {
        $module_handler = &xoops_gethandler('module');
        $module = &$module_handler->getByDirname(SMARTPARTNER_DIRNAME);
        $config_handler = &xoops_gethandler('config');
        $config = &$config_handler->getConfigsByCat(0, $module->getVar('mid'));
    } else {
        $module = &$icmsModule;
        $config = &$icmsModuleConfig;
    }

    if ($category == 'global') {
        $item['name'] = '';
        $item['url'] = '';
        return $item;
    }

    global $icmsDB;

    if ($category == 'item') {
        // Assume we have a valid partner id
        $sql = 'SELECT question FROM ' . $icmsDB->prefix('smarttask_partner') . ' WHERE id = ' . $item_id;
        $result = $icmsDB->query($sql); // TODO: error check
        $result_array = $icmsDB->fetchArray($result);
        $item['name'] = $result_array['title'];
        $item['url'] = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/partner.php?id=' . $item_id;
        return $item;
    }
}

?>