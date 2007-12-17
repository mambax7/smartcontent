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


function smartcontent_top_menu_show ($options)
{
	global $xoopsModule, $xoops_urls, $smartcontent_pageObj;

	include_once(XOOPS_ROOT_PATH . '/modules/smartcontent/include/common.php');
	$smartcontent_page_handler = xoops_getModuleHandler('page', 'smartcontent');
	include_once XOOPS_ROOT_PATH . '/modules/smartobject/class/smartobjectpermission.php';
	$smartpermissions_handler = new SmartobjectPermissionHandler($smartcontent_page_handler);
	$grantedItems = $smartpermissions_handler->getGrantedItems('read_perm');
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('submenu', 1));
	$criteria->add(new Criteria('status', _SCONTENT_STATUS_ONLINE));
	$criteria->add(new Criteria('pageid', '('.implode($grantedItems, ', ').')', 'IN'));
	$criteria->setSort('weight');
	$criteria->setOrder('ASC');

	$url = $xoops_urls['full'];

	// is the page we are in is a page or an external link of SmartContent ?
	if (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == 'smartcontent') {
		// we are in SmartContent
		if (!isset($smartcontent_pageObj)) {
			$smartcontent_pageObj = $smartcontent_page_handler->get(intval($_GET['pageid']));
		}
	} else {

		// we are not in SmartContent. Let's check if the current url matches any external_link of SmartContent
		$criteria2 = new CriteriaCompo();
		//$criteria2->add(new Criteria('submenu', 1));
		$criteria2->add(new Criteria('status', _SCONTENT_STATUS_ONLINE));
		$criteria2->add(new Criteria('external_link', $url));
		$linkObj = $smartcontent_page_handler->getObjects($criteria2);
		if ($linkObj && count($linkObj) != 0) {
			$smartcontent_pageObj = $linkObj[0];
		}
	}

	$pagesObj = $smartcontent_page_handler->getObjects($criteria, true);
	if(is_object($smartcontent_pageObj)){
		$top_selected = $smartcontent_pageObj;
		while($top_selected->getVar('parentid', 'e') != 0){
			$top_selected = $pagesObj[$top_selected->getVar('parentid', 'e')];
		}
		$currentid = $top_selected->getVar('pageid');
	}else{
		$currentid = 0;
	}
	foreach($pagesObj as $pageObj){
		if($pageObj->getVar('parentid', 'e') == 0 && $pageObj->getVar('submenu')== 1){
			$block[$pageObj->getVar('pageid')]['caption'] = $pageObj->getVar('menu_title')  !=  '' ? $pageObj->getVar('menu_title') :  $pageObj->getVar('title');
			$block[$pageObj->getVar('pageid')]['link'] = SMARTCONTENT_URL."page.php?pageid=".$pageObj->getVar('pageid');
			$block[$pageObj->getVar('pageid')]['selected'] =  $currentid == $pageObj->getVar('pageid');
		}
	}
	return $block;
}

function smartcontent_top_menu_edit($options)
{

    return '';
}

?>
