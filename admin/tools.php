<?php
/**
* $Id$
* Module: SmartCourse
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once("admin_header.php");

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

switch ($op) {

    case "reset_meta":
		$confirm = (isset($_POST['confirm'])) ? $_POST['confirm'] : 0;
		if ($confirm) {
			$smartcontent_page_handler = xoops_getModuleHandler('page', 'smartcontent');
			$pagesObj = $smartcontent_page_handler->getObjects();
			foreach($pagesObj as $pageObj) {
				$pageObj->setVar('meta_keywords', '');
				$pageObj->setVar('meta_description', '');
				$pageObj->setVar('short_url', '');
				$smartcontent_page_handler->insert($pageObj);
			}

			redirect_header('index.php', 3, 'All meta information have been reseted for all pages.');
			exit();
		} else {
				xoops_cp_header();

				xoops_confirm(array('op' => $op, 'confirm' => 1), xoops_getenv('PHP_SELF'), 'Are you sure yo want to reset ALL meta information for all pages ? This will reset meta-keywords, meta-description and short_url fields for ALL pages. Would you like to continue ?', _YES);

				xoops_cp_footer();

		}        break;
}

smart_modFooter();
xoops_cp_footer();

?>