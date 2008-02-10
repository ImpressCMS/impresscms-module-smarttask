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

if (!function_exists('smart_getEditors')) {
	include_once(XOOPS_ROOT_PATH. '/modules/smartobject/include/functions.php');
}
smart_loadCommonLanguageFile();

$modversion['name'] = _MI_STASK_MD_NAME;
$modversion['version'] = 1.0;
$modversion['description'] = _MI_STASK_MD_DESC;
$modversion['author'] = "INBOX International";
$modversion['credits'] = "The SmartFactory";
$modversion['help'] = "";
$modversion['license'] = "GNU General Public License (GPL)";
$modversion['official'] = 0;
$modversion['image'] = "images/module_logo.gif";
$modversion['dirname'] = "smarttask";

// Added by marcan for the About page in admin section
$modversion['developer_website_url'] = "http://smartfactory.ca";
$modversion['developer_website_name'] = "The SmartFactory";
$modversion['developer_email'] = "info@smartfactory.ca";
$modversion['status_version'] = "Beta 1";
$modversion['status'] = "Beta";
$modversion['date'] = "unreleased";

$modversion['people']['developers'][] = "[url=http://smartfactory.ca/userinfo.php?uid=1]marcan[/url] (Marc-Andr� Lanciault)";
$modversion['people']['developers'][] = "[url=http://smartfactory.ca/userinfo.php?uid=112]felix[/url] (F�lix Tousignant)";

//$modversion['people']['testers'][] = "Rob Butterworth";

//$modversion['people']['translators'][] = "translator 1";

//$modversion['people']['documenters'][] = "documenter 1";

//$modversion['people']['other'][] = "other 1";

$modversion['warning'] = _CO_SOBJECT_WARNING_BETA;

$modversion['author_word'] = "";

$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

//$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

$modversion['onInstall'] = "include/onupdate.inc.php";
$modversion['onUpdate'] = "include/onupdate.inc.php";

/**
 * SmartObject Hack : defining the items managed by this module
 */
$modversion['object_items'][1] = 'list';
$modversion['object_items'][2] = 'item';
$modversion['object_items'][3] = 'log';

$modversion["tables"] = smart_getTablesArray($modversion['dirname'], $modversion['object_items']);

// Search
$modversion['hasSearch'] = 0;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "smarttask_search";

// Menu
$modversion['hasMain'] = 1;

/*
$modversion['sub'][1]['name'] = _MI_STASK_ECARDS;
$modversion['sub'][1]['url'] = "sendecard.php";

$modversion['sub'][2]['name'] = _MI_STASK_ARCHIVE;
$modversion['sub'][2]['url'] = "message.php";
*/

/*
$modversion['blocks'][1]['file'] = "new_adds.php";
$modversion['blocks'][1]['name'] = _MI_STASK_NEW_ADDS;
$modversion['blocks'][1]['show_func'] = "new_adds_show";
$modversion['blocks'][1]['edit_func'] = "new_adds_edit";
$modversion['blocks'][1]['template'] = "smarttask_new_adds.html";

*/
global $xoopsModule;
// Templates
$i = 0;

$i++;
$modversion['templates'][$i]['file'] = 'smarttask_header.html';
$modversion['templates'][$i]['description'] = 'Header template of all pages';

$i++;
$modversion['templates'][$i]['file'] = 'smarttask_footer.html';
$modversion['templates'][$i]['description'] = 'Footer template of all pages';

$i++;
$modversion['templates'][$i]['file'] = 'smarttask_index.html';
$modversion['templates'][$i]['description'] = 'Display Index page';

$i++;
$modversion['templates'][$i]['file'] = 'smarttask_list.html';
$modversion['templates'][$i]['description'] = 'Display lists page';

$i++;
$modversion['templates'][$i]['file'] = 'smarttask_item.html';
$modversion['templates'][$i]['description'] = 'Display items page';

$i++;
$modversion['templates'][$i]['file'] = 'smarttask_log.html';
$modversion['templates'][$i]['description'] = 'Display logs page';


// Config Settings (only for modules that need config settings generated automatically)
$i = 0;

//common prefs for all module uses

$modversion['config'][$i]['name'] = 'default_editor';
$modversion['config'][$i]['title'] = '_CO_SOBJECT_EDITOR';
$modversion['config'][$i]['description'] = '_CO_SOBJECT_EDITOR_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';

$modversion['config'][$i]['options'] = smart_getEditors();
$modversion['config'][$i]['default'] = 'dhtmltextarea';
$i++;

// Retreive the group user list, because the autpmatic group_multi config formtype does not include Anonymous group :-(
$member_handler =& xoops_gethandler('member');
$groups_array = $member_handler->getGroupList();
foreach($groups_array as $k=>$v) {
	$select_groups_options[$v] = $k;
}
//common prefs for all module uses
$i++;
$modversion['config'][$i]['name'] = 'team_groups';
$modversion['config'][$i]['title'] = '_MI_STASK_TEAM_GR';
$modversion['config'][$i]['description'] = '_MI_STASK_TEAM_GRDSC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['options'] = $select_groups_options;
$modversion['config'][$i]['default'] =  '1';

/*
$i++;
$modversion['config'][$i]['name'] = 'show_subcats';
$modversion['config'][$i]['title'] = '_MI_STASK_SHOW_SUBCATS';
$modversion['config'][$i]['description'] = '_MI_STASK_SHOW_SUBCATS_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'all';
$modversion['config'][$i]['options'] = array(_MI_STASK_SHOW_SUBCATS_NO  => 'no',
                                   		_MI_STASK_SHOW_SUBCATS_NOTEMPTY   => 'nonempty',
                                  		 _MI_STASK_SHOW_SUBCATS_ALL => 'all');
*/

?>