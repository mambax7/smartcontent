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


function smartcontent_sub_menu_show ($options)
{
	global $xoopsModule, $xoops_urls, $smartcontent_pageObj;

	include_once(XOOPS_ROOT_PATH . '/modules/smartcontent/include/common.php');
	$smartcontent_page_handler = xoops_getModuleHandler('page', 'smartcontent');
	include_once XOOPS_ROOT_PATH . '/modules/smartobject/class/smartobjectpermission.php';
	$smartpermissions_handler = new SmartobjectPermissionHandler($smartcontent_page_handler);
	$grantedItems = $smartpermissions_handler->getGrantedItems('read_perm');
	if(is_object($smartcontent_pageObj)){
		$parentid = $smartcontent_pageObj->getVar('parentid', 'e') == 0 ? $smartcontent_pageObj->getVar('pageid', 'e') :$smartcontent_pageObj->getVar('parentid', 'e');

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('parentid', $parentid));
		$criteria->add(new Criteria('submenu', 1));
		$criteria->add(new Criteria('status', _SCONTENT_STATUS_ONLINE));
		$criteria->add(new Criteria('pageid', '('.implode($grantedItems, ', ').')', 'IN'));
		$criteria->setSort('weight');
		$criteria->setOrder('ASC');

		$pagesObj = $smartcontent_page_handler->getObjects($criteria, true);
		foreach($pagesObj as $pageObj){
			$block[$pageObj->getVar('pageid')]['caption'] = $pageObj->getVar('menu_title')  !=  '' ? $pageObj->getVar('menu_title') :  $pageObj->getVar('title');
			$block[$pageObj->getVar('pageid')]['link'] = SMARTCONTENT_URL."page.php?pageid=".$pageObj->getVar('pageid');
			$block[$pageObj->getVar('pageid')]['selected'] =  $smartcontent_pageObj->getVar('pageid', 'e') == $pageObj->getVar('pageid');
		}
	}
	return $block;
}

function smartcontent_sub_menu_edit($options)
{

    return '';
}

?>
