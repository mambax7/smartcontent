<?php

/**
* $Id$
* Module: SmartContent
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

if (!defined("SMARTCONTENT_NOCPFUNC")) {
	include_once '../../../include/cp_header.php';
}

require_once XOOPS_ROOT_PATH.'/kernel/module.php';
include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

include_once XOOPS_ROOT_PATH.'/modules/smartcontent/include/common.php';

if( !defined("SMARTCONTENT_ADMIN_URL") ){
	define('SMARTCONTENT_ADMIN_URL', SMARTCONTENT_URL . "admin");
}

$imagearray = array(
	'editimg' => "<img src='". SMARTCONTENT_IMAGES_URL ."/button_edit.png' alt='" . _AM_SCONTENT_ICO_EDIT . "' align='middle' />",
    'deleteimg' => "<img src='". SMARTCONTENT_IMAGES_URL ."/button_delete.png' alt='" . _AM_SCONTENT_ICO_DELETE . "' align='middle' />",
	);

smart_loadCommonLanguageFile();
?>