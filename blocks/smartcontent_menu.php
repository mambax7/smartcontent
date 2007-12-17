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
function build_menu($pagesObj, $ascendency, $parentid, $currentPageid, $level){

	foreach($pagesObj as $page){
		if($page->getVar('parentid', 'e') == $parentid){
			$pageid = $page->getVar('pageid', 'e');
			$menuArray[$pageid]['caption'] = $page->getVar('menu_title')  !=  '' ? $page->getVar('menu_title') :  $page->getVar('title');
			$menuArray[$pageid]['link'] =  SMARTCONTENT_URL."page.php?pageid=".$page->getVar('pageid');
			$menuArray[$pageid]['level'] =  $level;
			if($pageid == $currentPageid){
				$menuArray[$pageid]['selected'] = true;
			}
			if(in_array($pageid, $ascendency)){
				$menuArray[$pageid]['subs'] = build_menu($pagesObj, $ascendency, $pageid, $currentPageid, $level+1);
			}
		}
	}
	return $menuArray;

}


function smartcontent_menu_show ($options)
{
	global $xoopsModule, $xoops_urls, $smartcontent_pageObj;
	include_once(XOOPS_ROOT_PATH . '/modules/smartcontent/include/common.php');
	$smartcontent_page_handler = xoops_getModuleHandler('page', 'smartcontent');
	include_once XOOPS_ROOT_PATH . '/modules/smartobject/class/smartobjectpermission.php';
	$smartpermissions_handler = new SmartobjectPermissionHandler($smartcontent_page_handler);
	$grantedItems = $smartpermissions_handler->getGrantedItems('read_perm');
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('status', _SCONTENT_STATUS_ONLINE));
	$criteria->add(new Criteria('submenu', true));
	$criteria->add(new Criteria('pageid', '('.implode($grantedItems, ', ').')', 'IN'));
	$criteria->setSort('weight');
	$criteria->setOrder('ASC');
	$pagesObj = $smartcontent_page_handler->getObjects($criteria, true);

	if (!isset($xoops_urls)) {
		include_once XOOPS_ROOT_PATH.'/modules/smartobject/include/functions.php';
		$xoops_urls = smart_getCurrentUrls();
	}
	$url = $xoops_urls['full'];

	// is the page we are in is a page or an external link of SmartContent ?
	if (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == 'smartcontent') {
		// we are in SmartContent
		if (!isset($smartcontent_pageObj)) {
			$smartcontent_pageObj = $smartcontent_page_handler->get(intval($_GET['pageid']));
		}
	} else {

		// we are not in SmartContent. Let's check if the current url matches any external_link of SmartContent
		$url = strrev(str_replace($xoops_urls['querystring'], '', $xoops_urls['full']));
		 if(substr($url, 0, 4) == 'php.'){
		 	$url = substr($url, 4, strlen($url)-1);
		 	while(substr($url, 0, 1) != '/'){
		 		$url = substr($url, 1, strlen($url)-1);
		 	}
		 	if(substr($url, 0, 1) == '/'){
		 		$url = substr($url, 1, strlen($url)-1);
		 	}
		 }
	  	$url = strrev($url);
		if($url != XOOPS_URL){
			$url = str_replace(XOOPS_URL, '', $url);
		}

		$criteria->add(new Criteria('external_link', '%'.$url.'%', 'LIKE'));
		$linkObj = $smartcontent_page_handler->getObjects($criteria);
		if ($linkObj && count($linkObj) != 0) {
			$smartcontent_pageObj = $linkObj[0];
		}
	}
	//Retreive parent ids for wich submenu must be shown
	$ascendency = array();
	if(isset($smartcontent_pageObj)){
		$ascendency[] = $smartcontent_pageObj->getVar('pageid', 'e');
		$parentObj = $pagesObj[$smartcontent_pageObj->getVar('parentid', 'e')];
		while(is_object($parentObj)){
			$ascendency[] = $parentObj->getVar('pageid', 'e');
			$parentObj = $pagesObj[$parentObj->getVar('parentid', 'e')];
		}
	}
	$currentPageid = is_object($smartcontent_pageObj) ? $smartcontent_pageObj->getVar('pageid') : 0;
	$block = build_menu($pagesObj, $ascendency, 0, $currentPageid, 0);
	return $block;
}

function smartcontent_menu_edit($options)
{

    return '';
}

?>
