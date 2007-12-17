<?php

/**
* $Id$
* Module: SmartContent
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once "../../mainfile.php";

if( !defined("SMARTCONTENT_DIRNAME") ){
	define("SMARTCONTENT_DIRNAME", 'smartcontent');
}

include_once XOOPS_ROOT_PATH.'/modules/' . SMARTCONTENT_DIRNAME . '/include/common.php';
smart_loadCommonLanguageFile();
?>