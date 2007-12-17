<?php

/**
* $Id$
* Module: SmartContent
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

global $xoopsModule, $xoopsModuleConfig;

include_once XOOPS_ROOT_PATH . "/modules/smartcontent/include/functions.php";

$uid = ($xoopsUser) ? ($xoopsUser->getVar("uid")) : 0;

$xoopsTpl->assign("smartcontent_adminpage", "<a href='" . XOOPS_URL . "/modules/smartcontent/admin/index.php'>" ._CO_SOBJECT_ADMIN_PAGE . "</a>");
$xoopsTpl->assign("isAdmin", $smartcontent_isAdmin);
$xoopsTpl->assign('smartcontent_url', SMARTCONTENT_URL);
$xoopsTpl->assign('smartcontent_images_url', SMARTCONTENT_IMAGES_URL);
$xoopsTpl->assign("show_breadcrumb", $xoopsModuleConfig['show_breadcrumb']);
$xoopsTpl->assign("xoops_module_header", '<link rel="stylesheet" type="text/css" href="' . SMARTCONTENT_URL . 'module.css" />');

$xoopsTpl->assign("ref_smartfactory", "SmartContent is developed by The SmartFactory (http://smartfactory.ca), a division of InBox Solutions (http://inboxsolutions.net)");

?>