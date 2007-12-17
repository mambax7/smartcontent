<?php

/**
* $Id$
* Module: SmartContent
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once 'header.php';
require_once XOOPS_ROOT_PATH.'/class/template.php';

$pageid = isset($_GET['pageid']) ? intval($_GET['pageid']) : 0;

if ($pageid == 0) {
	redirect_header("javascript:history.go(-1)", 1, _MD_SCONTENT_NOITEMSELECTED);
	exit();
}

// Creating the ITEM object for the selected ITEM
$pageObj = $smartcontent_page_handler->get($pageid);

// if the selected ITEM was not found, exit
if ($pageObj->isNew()) {
	redirect_header("javascript:history.go(-1)", 1, _MD_SCONTENT_NOITEMSELECTED);
	exit();
}

// Creating the category object that holds the selected ITEM
//$categoryObj = $smartcontent_category_handler->get($pageObj->getVar('parentid'));

$xoopsTpl = new XoopsTpl();
global $xoopsConfig, $xoopsDB, $xoopsModule, $myts;

$page=  $pageObj->toArray();
/*
 *Trouver une meilleure façon ( pas le temps auj...)
 */
 if (method_exists($myts, 'formatForML')) {
	$xoopsConfig['sitename'] = $myts->FormatForML($xoopsConfig['sitename']);
}
$page['title'] = str_replace("\n", "", $page['title'] );
$printtitle = $xoopsConfig['sitename']."  > ".$myts->displayTarea($page['title']);
$printheader = $myts->displayTarea(smartcontent_getConfig('headerprint'));
//$page['categoryname'] = $myts->displayTarea($categoryObj->getVar('name'));

$xoopsTpl->assign('printtitle', $printtitle);
$xoopsTpl->assign('printlogourl', $xoopsModuleConfig['printlogourl']);
$xoopsTpl->assign('printheader', $printheader);
$xoopsTpl->assign('lang_category', _MD_SCONTENT_CATEGORY);
$xoopsTpl->assign('lang_author_date', $who_where);
$xoopsTpl->assign('sitetitle', $myts->displayTarea($xoopsConfig['sitename']));
$xoopsTpl->assign('siteslogan', $myts->displayTarea($xoopsConfig['slogan']));
$xoopsTpl->assign('page', $page);
$xoopsTpl->assign('printfooter', $myts->displayTarea($xoopsModuleConfig['printfooter']));
$xoopsTpl->assign('doNotStartPrint', $doNotStartPrint);
$xoopsTpl->assign('noTitle', $noTitle);
$xoopsTpl->assign('smartPopup', $smartPopup);
$xoopsTpl->assign('current_language', $xoopsConfig['language']);

$xoopsTpl->display('db:smartcontent_print.html');

?>