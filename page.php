<?php

/**
* $Id$
* Module: SmartContent
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once("header.php");

global $smartcontent_page_handler;

$pageid = isset($_GET['pageid']) ? intval($_GET['pageid']) : 0;

// Creating the page object for the selected pageid
$smartcontent_pageObj = $smartcontent_page_handler->get($pageid);
include_once XOOPS_ROOT_PATH . '/modules/smartobject/class/smartobjectpermission.php';
$smartpermissions_handler = new SmartobjectPermissionHandler($smartcontent_page_handler);
$grantedItems = $smartpermissions_handler->getGrantedItems('read_perm');

// if the selected page is new, it means that this pageid was not found, OR if the page is not active, exit
if ($smartcontent_pageObj->isNew() || $smartcontent_pageObj->getVar('status','n') != _SCONTENT_STATUS_ONLINE || !in_array($pageid, $grantedItems)) {
    redirect_header(SMARTCONTENT_URL, 1, _MD_SCONTENT_PAGE_NOT_FOUND);
    exit();
}

/**
 * Update page counter
 */

$smartcontent_page_handler->updateCounter($smartcontent_pageObj);

// if external link then redirect

if ($smartcontent_pageObj->getVar('external_link')) {
	header('Location: ' . $smartcontent_pageObj->getVar('external_link'));
	exit;
}
$link2page = $smartcontent_pageObj->getVar('link2page');
if ($link2page > 0) {
	header('Location: ' . SMARTCONTENT_URL . 'page.php?pageid=' . $link2page);
	exit;
}

$xoopsOption['template_main'] = 'smartcontent_page.html';
include_once(XOOPS_ROOT_PATH . "/header.php");
include_once("footer.php");

$pageArray = $smartcontent_pageObj->toArray();
if (substr($pageArray['title'], 0, 7) == 'notitle') {
	$pageArray['title'] = false;
	$smartcontent_pageObj->setVar('title', '');
}

$xoopsTpl->assign('page', $pageArray);

$parentObj = $smartcontent_page_handler->get($smartcontent_pageObj->getVar('parentid', 'e'));
if (!$parentObj->isNew() && $xoopsModuleConfig['display_cat_in_breadcrumb']) {
	$breadCrumb = $parentObj->getBreadCrumb(true, false) . " > ";
} else {
	$breadCrumb = '';
}

// This is done in our SmartX distribution but if this module is not use with SmartX we need to retreive xoops_urls
if (!isset($xoops_urls)) {
	$xoops_urls = smart_getCurrentUrls();
	$xoopsTpl->assign('xoops_urls', $xoops_urls);
}

$xoopsTpl->assign('module_home', smart_getModuleName(true, true));
$xoopsTpl->assign('bread_crumb', $breadCrumb . $smartcontent_pageObj->getVar('title', 'clean'));
if(is_object($xoTheme)){
	$xoTheme->addStylesheet('', array(), $smartcontent_pageObj->getVar('custom_css', 'n'));
}else{
	echo "<style>.$smartcontent_pageObj->getVar('custom_css', 'n').</style>";
}
/**
 * Generating meta information for this page
 */
$smartcontent_metagen = new SmartMetagen($smartcontent_pageObj->getVar('title'), $smartcontent_pageObj->getVar('meta_keywords'), $smartcontent_pageObj->getVar('meta_description'), $breadCrumb, false);
$smartcontent_metagen->createMetaTags();


include_once(XOOPS_ROOT_PATH . "/footer.php");

?>