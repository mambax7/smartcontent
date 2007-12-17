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

function smartcontent_items_new_show ($options)
{	
	include_once(XOOPS_ROOT_PATH."/modules/smartcontent/include/common.php");	
	
	$block = array();
	If ($options[0] == 0) {
		$categoryid = -1;
	} else {
		$categoryid = $options[0];
	}
	
	$sort = $options[1];
	$order = smartcontent_getOrderBy($sort);				
	$limit = $options[2];
	
	$smartcontent_item_handler =& smartcontent_gethandler('item');
	
	// creating the ITEM objects that belong to the selected category
	$itemsObj = $smartcontent_item_handler->getAllPublished($limit, 0, $categoryid, $sort, $order);
	$totalitems = count($itemsObj);
	If ($itemsObj) {
		for ( $i = 0; $i < $totalitems; $i++ ) {
            $newitems = array();
            $newitems['link'] = $itemsObj[$i]->getItemLink();
            $newitems['id'] = $itemsObj[$i]->itemid();
            if ($sort == "datesub") {
                $newitems['new'] = $itemsObj[$i]->datesub();
            } elseif ($sort == "counter") {
                $newitems['new'] = $itemsObj[$i]->counter();
            } elseif ($sort == "weight") {
                $newitems['new'] = $itemsObj[$i]->weight();
            } 
			
			$block['newitems'][] = $newitems;		
		}
	}
	
	return $block;	
} 

function smartcontent_items_new_edit($options)
{
    global $xoopsDB, $xoopsModule, $xoopsUser;
	include_once(XOOPS_ROOT_PATH."/modules/smartcontent/include/functions.php");
	
	$form = smartcontent_createCategorySelect($options[0]);
	
    $form .= "&nbsp;<br>" . _MB_SCONTENT_ORDER . "&nbsp;<select name='options[]'>";

    $form .= "<option value='datesub'";
    if ($options[1] == "datesub") {
        $form .= " selected='selected'";
    } 
    $form .= ">" . _MB_SCONTENT_DATE . "</option>\n";

    $form .= "<option value='counter'";
    if ($options[1] == "counter") {
        $form .= " selected='selected'";
    } 
    $form .= ">" . _MB_SCONTENT_HITS . "</option>\n";

    $form .= "<option value='weight'";
    if ($options[1] == "weight") {
        $form .= " selected='selected'";
    } 
    $form .= ">" . _MB_SCONTENT_WEIGHT . "</option>\n";

    $form .= "</select>\n";

    $form .= "&nbsp;" . _MB_SCONTENT_DISP . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "' />&nbsp;" . _MB_SCONTENT_ITEMS . "";

    return $form;
} 

?>