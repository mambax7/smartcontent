<?php

/**
* $Id$
* Module: SmartContent
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once('header.php');

if (!$xoopsModuleConfig['allow_browsing']) {
    redirect_header(XOOPS_URL, 1, _NOPERM);
    exit();
}

if ($xoopsModuleConfig['home_url'] != '' &&
	(!strpos($xoopsModuleConfig['home_url'], 'index.php')) &&
	$xoopsModuleConfig['home_url'] != SMARTCONTENT_URL &&
	$xoopsModuleConfig['home_url'] != XOOPS_URL . "/modules/smartcontent"
	&&
	$xoopsModuleConfig['home_url'] != XOOPS_URL . "/modules/smartcontent/"
	) {
		header('Location: ' . $xoopsModuleConfig['home_url']);
		exit;
}

include_once(XOOPS_ROOT_PATH . '/header.php');

$xoopsOption['template_main'] = 'smartcontent_display_content.html';
include_once(XOOPS_ROOT_PATH . "/header.php");
include_once("footer.php");


/**
 * Get all top pages
 */
include_once XOOPS_ROOT_PATH . '/modules/smartobject/class/smartobjectpermission.php';
$smartpermissions_handler = new SmartobjectPermissionHandler($smartcontent_page_handler);
$grantedItems = $smartpermissions_handler->getGrantedItems('read_perm');

$criteria = new CriteriaCompo();
$criteria->add(new Criteria('parentid', 0));
$criteria->add(new Criteria('status', _SCONTENT_STATUS_ONLINE));
$criteria->add(new Criteria('pageid', '('.implode($grantedItems, ', ').')', 'IN'));

$aPages = $smartcontent_page_handler->getObjects($criteria, true, false);
$xoopsTpl->assign('items', $aPages);

/**
 * Generating meta information for this page
 */
$smartcontent_metagen = new SmartMetagen($smartcontent_moduleName, false, false, false, false);
$smartcontent_metagen->createMetaTags();

include_once(XOOPS_ROOT_PATH . '/footer.php');

?>