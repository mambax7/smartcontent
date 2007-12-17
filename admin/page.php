<?php
/**
* $Id$
* Module: SmartCourse
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function editpage($showmenu = false, $pageid = 0)
{
    global $smartcontent_page_handler, $op;
	$pageObj = $smartcontent_page_handler->get($pageid);

    // if the page is an external_link
    if (isset($_GET['external']) || $pageObj->getVar('is_external_link') == 1) {
    	$pageObj->hideFieldFromForm(array('body', 'uid', 'datesub', 'counter', 'custom_css', 'short_url', 'meta_keywords', 'meta_description', 'dohtml', 'dobr', 'is_external_link'));
    	$pageObj->setVar('is_external_link', 1);
    } else {
    	$pageObj->hideFieldFromForm(array('external_link', 'link2page', 'is_external_link'));
    	$pageObj->setVar('is_external_link', 0);
    }

	if (isset($_POST['op'])) {
		$controller = new SmartObjectController($smartcontent_page_handler);
		$controller->postDataToObject($pageObj);

		if ($_POST['op'] == 'changedField') {

			switch($_POST['changedField']) {
				case 'link2page':
					if ($pageObj->getVar('link2page', 'e') == -1) {
						$pageObj->showFieldOnForm(array('external_link'));
					} else {
						$pageObj->hideFieldFromForm(array('external_link'));
					}
				break;
			}
		}
	}

	if ($op == 'clone') {
		$pageObj->setNew();
		$pageObj->setVar('datesub', time());
		$pageObj->setVar('meta_description', '');
		$pageObj->setVar('meta_keywords', '');
		$pageObj->setVar('short_url', '');
		$pageObj->setVar('pageid', 0);
	}


    if (!$pageObj->isNew()){

        if ($showmenu) {
            smart_adminMenu(0, _AM_SCONTENT_PAGES . " > " . _AM_SCONTENT_EDITING);
        }
        echo "<br />\n";
        smart_collapsableBar('pageedit', _AM_SCONTENT_PAGE_EDIT, _AM_SCONTENT_PAGE_EDIT_INFO);

        $sform = $pageObj->getForm(_AM_SCONTENT_PAGE_EDIT, 'addpage');
        $sform->display();
        smart_close_collapsable('pageedit');
    } else {
        if ($showmenu) {
            smart_adminMenu(0, _AM_SCONTENT_PAGES . " > " . _AM_SCONTENT_CREATINGNEW);
        }

        //echo "<br />\n";
        smart_collapsableBar('pagecreate', _AM_SCONTENT_PAGE_CREATE, _AM_SCONTENT_PAGE_CREATE_INFO);
        $sform = $pageObj->getForm(_AM_SCONTENT_PAGE_CREATE, 'addpage');
        $sform->display();
        smart_close_collapsable('pagecreate');
    }
}

include_once("admin_header.php");

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

switch ($op) {
    case "mod":
    case "clone":
    case "changedField":
        $pageid = isset($_GET['pageid']) ? intval($_GET['pageid']) : 0 ;

        smart_xoops_cp_header();

        editpage(true, $pageid);
        break;

    case "addpage":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartcontent_page_handler);
        $controller->storeFromDefaultForm(_AM_SCONTENT_PAGE_CREATED, _AM_SCONTENT_PAGE_MODIFIED, 'page.php');

        break;

    case "del":
        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartcontent_page_handler);
        $controller->handleObjectDeletion();
        break;

	case "updatePages":
		if (!isset($_POST['SmartcontentPage_objects']) || count($_POST['SmartcontentPage_objects']) == 0) {
			redirect_header($smart_previous_page, 3, _CO_SOBJECT_NO_RECORDS_TO_UPDATE);
			exit;
		}

		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('pageid', '(' . implode(', ', $_POST['SmartcontentPage_objects']) . ')', 'IN'));
		$pagesObj = $smartcontent_page_handler->getObjects($criteria, true);
		foreach($pagesObj as $pageid=>$pageobj) {
			$pageobj->setVar('weight', isset($_POST['weight_' . $pageid]) ? intval($_POST['weight_' . $pageid]) : 0);
			$pageobj->setVar('parentid', isset($_POST['parentid_' . $pageid]) ? intval($_POST['parentid_' . $pageid]) : 0);
			$pageobj->setVar('status', isset($_POST['status_' . $pageid]) ? $_POST['status_' . $pageid] : '');
			$pageobj->setVar('submenu', isset($_POST['submenu_' . $pageid]) ? $_POST['submenu_' . $pageid] : '');
			$smartcontent_page_handler->insert($pageobj, true);
		}

		redirect_header($smart_previous_page, 3, _CO_SOBJECT_NO_RECORDS_UPDATED);
		exit;

		break;

    case "default":
    default:

        smart_xoops_cp_header();

        smart_adminMenu(0, _AM_SCONTENT_PAGES);

        smart_collapsableBar('createdpages', _AM_SCONTENT_PAGES, _AM_SCONTENT_PAGES_DSC);

        $criteria = new CriteriaCompo();

        include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
        $objectTable = new SmartObjectTable($smartcontent_page_handler, $criteria, array('delete'));
        $objectTable->addColumn(new SmartObjectColumn('title', 'left', false, 'getTitleLink'));
        $objectTable->addColumn(new SmartObjectColumn('parentid', 'left', 200, 'getParentidControl'));
        $objectTable->addColumn(new SmartObjectColumn('weight', 'center', 50, 'getWeightControl'));
       	$objectTable->addColumn(new SmartObjectColumn('submenu', 'center', 100, 'getSubmenuControl'));
       	$objectTable->addColumn(new SmartObjectColumn('status', 'center', 100, 'getStatusControl'));

		$objectTable->addIntroButton('addpage', 'page.php?op=mod', _AM_SCONTENT_PAGE_CREATE);
		$objectTable->addIntroButton('addexternallink', 'page.php?op=mod&external', _AM_SCONTENT_PAGE_EXTERNAL_LINK_CREATE);

		$objectTable->addCustomAction('getPageCloneActionLink');
		$objectTable->addCustomAction('getPageEditActionLink');

		$objectTable->addActionButton('updatePages', _SUBMIT, _CO_SOBJECT_UPDATE_ALL . ':');

		$criteria_main_pages = new CriteriaCompo();
		$criteria_main_pages->add(new Criteria('parentid', 0));
		$objectTable->addFilter(_CO_SCONTENT_MAIN_PAGES, array(
									'key' => 'pageid',
									'criteria' => $criteria_main_pages
		));

        $objectTable->render();


        echo "<br />";
        smart_close_collapsable('createdpages');
        echo "<br>";

        break;
}

smart_modFooter();
xoops_cp_footer();

?>