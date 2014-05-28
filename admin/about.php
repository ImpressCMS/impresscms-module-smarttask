<?php

/**
* About page of the module
*
* @copyright	The SmartFactory http://www.smartfactory.ca
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @package		SmartTask
* @author		marcan <marcan@smartfactory.ca>
* @version		$Id: about.php 23265 2012-01-25 07:50:44Z sato-san $
*/

include_once "admin_header.php";
$aboutObj = new icms_ipf_About();
$aboutObj->render();