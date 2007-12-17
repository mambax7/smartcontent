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

function smartcontent_spotlight_show ($options)
{
	include_once(XOOPS_ROOT_PATH."/modules/smartcontent/include/common.php");

	$block = array();

    if (isset($options[0])) {
    	$selectedItems = explode(',', $options[0]);
    } else {
    	$selectedItems = array();
    }

	$criteria = new CriteriaCompo();
	$criteria->setSort('weight');

	$smartcontent_page_handler =& xoops_getmodulehandler('page', 'smartcontent');

	$pagesObj = $smartcontent_page_handler->getObjects($criteria, true);
	$categoriesObj = $smartcontent_category_handler->getObjects($criteria, true);

	foreach($selectedItems as $selectedItem) {
		if (substr($selectedItem, 0, 4) == 'page') {
			// This item is a page..
			$pageid = str_replace('page_', '', $selectedItem);
			if (isset($pagesObj[$pageid])) {
				$block['pages'][] = $pagesObj[$pageid]->toArray();
			}
		} else {
			/**
			 * @todo Currently, only pages can be selected but later, we might add the possibility to add all the pages within one or many category. We just need to think and decide if it could be usefull or not
			 */
			 /*
			// This item is a category..
			$categoryid = str_replace('category_', '', $selectedItem);
			if (isset($categoriesObj[$categoryid])) {

			}*/
		}
	}

	if (count($block) > 0) {
		$block['css'] = '<style type="text/css">@import url(' . SMARTCONTENT_URL . 'module.css);</style>';
		if (!isset($smartcontent_isAdmin)) {
			$smartcontent_isAdmin = smartcontent_userIsAdmin();
		}
		$block['isAdmin'] = $smartcontent_isAdmin;
		return $block;
	} else {
		return false;
	}
}

function smartcontent_getspaces($level) {
	$ret = '';
	for ($i=0; $i < $level; $i++) {
		$ret .= "--";
	}
	return $ret;
}

function smartcontent_addCategoryOption($categoryid, $aCategory, $level=0, &$aOptions) {
	global $smartcontentAllPagesByParent, $smartcontent_page_controller;

	$aOptions["category_" . $aCategory['self']['categoryid']] = smartcontent_getspaces($level) . "[" . _MB_SCONTENT_CATEGORY . "] " . $aCategory['self']['itemLink'];

	if (isset($smartcontentAllPagesByParent[$aCategory['self']['categoryid']])) {
		foreach($smartcontentAllPagesByParent[$aCategory['self']['categoryid']] as $pageid=>$oPage) {
			$aOptions["page_" . $pageid] = smartcontent_getspaces($level+1) . "[" . _MB_SCONTENT_PAGE . "] " . $smartcontent_page_controller->getItemLink($oPage);
		}
	}

	if (isset($aCategory['sub']) && count($aCategory['sub'] > 0)) {
		$level++;
		foreach ($aCategory['sub'] as $categoryid=>$aCategory) {
			smartcontent_addCategoryOption($categoryid, $aCategory, $level, $aOptions);
		}
	}
}

function smartcontent_spotlight_edit($options)
{
    include_once(XOOPS_ROOT_PATH."/modules/smartcontent/include/common.php");
    global $smartcontent_page_controller;

    include_once(SMARTOBJECT_ROOT_PATH."class/smartobjectcontroller.php");
	$smartcontent_page_controller = new SmartObjectController($smartcontent_page_handler);

	$aCategories = $smartcontent_category_handler->getAllCategoriesArray();

	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('status', _SCONTENT_STATUS_ONLINE));

	global $smartcontentAllPagesByParent;
	$smartcontentAllPagesByParent = $smartcontent_page_handler->getObjects($criteria, 'parentid', true);

	$aOptions = array();
	foreach ($aCategories as $categoryid=>$aCategory) {
		smartcontent_addCategoryOption($categoryid, $aCategory, 0, $aOptions);
	}

    if (isset($options[0])) {
    	$selectedItems = explode(',', $options[0]);
    } else {
    	$selectedItems = array();
    }

    $form = _MB_SCONTENT_PAGE_SELECT . "<br /><select name='options[0][]' multiple='multiple'>";

	foreach ($aOptions as $key=>$value) {

		$form .= "<option value='$key'";
			if (substr($key, 0, 8) == 'category') {
				$form .= " disabled='disabled' ";
			}
  		    if (in_array($key, $selectedItems)) {
        		$form .= " selected='selected' ";
  		    }
  		$form .= ">" . $value . "</option>";
    }
    $form .= "</select>\n<br />";

    return $form;
}

?>