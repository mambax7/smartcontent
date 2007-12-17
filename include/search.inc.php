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

function smartcontent_search($queryarray, $andor, $limit, $offset, $userid)
{
	include_once XOOPS_ROOT_PATH.'/modules/smartcontent/include/common.php';

	$ret = array();

	if (!isset($smartcontent_page_handler)) {
		$smartcontent_page_handler = xoops_getmodulehandler('page', 'smartcontent');
	}

	if ($queryarray == ''){
		$keywords= '';
		$hightlight_key = '';
	} else {
		$keywords=implode('+', $queryarray);
		$hightlight_key = "&amp;keywords=" . $keywords;
	}

	$itemsObj =& $smartcontent_page_handler->getItemsFromSearch($queryarray, $andor, $limit, $offset, $userid);

	foreach ($itemsObj as $result) {
		$item['image'] = "images/item_icon.gif";
		$item['link'] = "page.php?pageid=" . $result['id'] . $hightlight_key;
		$item['title'] = "" . $result['title'];
		$item['time'] = '';
		$item['uid'] = '';
		$ret[] = $item;
		unset($item);
	}

	return $ret;
}

?>