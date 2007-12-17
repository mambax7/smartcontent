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

if( !defined("SMARTCONTENT_DIRNAME") ){
	define("SMARTCONTENT_DIRNAME", 'smartcontent');
}

if( !defined("SMARTCONTENT_URL") ){
	define("SMARTCONTENT_URL", XOOPS_URL.'/modules/'.SMARTCONTENT_DIRNAME.'/');
}
if( !defined("SMARTCONTENT_ROOT_PATH") ){
	define("SMARTCONTENT_ROOT_PATH", XOOPS_ROOT_PATH.'/modules/'.SMARTCONTENT_DIRNAME.'/');
}

if( !defined("SMARTCONTENT_IMAGES_URL") ){
	define("SMARTCONTENT_IMAGES_URL", SMARTCONTENT_URL.'/images/');
}

/** Include SmartObject framework **/
include_once XOOPS_ROOT_PATH.'/modules/smartobject/class/smartloader.php';

/*
 * Including the common languag file of the module
 */
$fileName = SMARTCONTENT_ROOT_PATH . 'language/' . $GLOBALS['xoopsConfig']['language'] . '/common.php';
if (!file_exists($fileName)) {
	$fileName = SMARTCONTENT_ROOT_PATH . 'language/english/common.php';
}

include_once($fileName);

// Definition of some constants that should be put in module preferences when time permits
define('SMARTCONTENT_UINTS_PER_PAGE_ADMIN', 10);

include_once(SMARTCONTENT_ROOT_PATH . "include/functions.php");

// Creating the SmartModule object
$smartContentModule =& smart_getModuleInfo(SMARTCONTENT_DIRNAME);

// Find if the user is admin of the module
$smartcontent_isAdmin = smart_userIsAdmin(SMARTCONTENT_DIRNAME);

$myts = MyTextSanitizer::getInstance();
if ($smartContentModule) {
	$smartcontent_moduleName = $smartContentModule->getVar('name');
}

// Creating the SmartModule config Object
$smartContentConfig =& smart_getModuleConfig(SMARTCONTENT_DIRNAME);

define('_SCONTENT_STATUS_UNDEFINED', 0);
define('_SCONTENT_STATUS_OFFLINE', 1);
define('_SCONTENT_STATUS_ONLINE', 2);
$statusArray = array(
	_SCONTENT_STATUS_UNDEFINED => _CO_SCONTENT_STATUS_UNDEFINED,
	_SCONTENT_STATUS_OFFLINE => _CO_SCONTENT_STATUS_OFFLINE,
	_SCONTENT_STATUS_ONLINE => _CO_SCONTENT_STATUS_ONLINE
	);


include_once(SMARTCONTENT_ROOT_PATH . "class/page.php");


// Creating the page handler object
$smartcontent_page_handler =& xoops_getmodulehandler('page', SMARTCONTENT_DIRNAME);

?>