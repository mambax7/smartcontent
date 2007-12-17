<?php
// $Id$
// ------------------------------------------------------------------------ //
// 				 XOOPS - PHP Content Management System                      //
//					 Copyright (c) 2000 XOOPS.org                           //
// 						<http://www.xoops.org/>                             //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //

// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //

// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// URL: http://www.xoops.org/												//
// Project: The XOOPS Project                                               //
// -------------------------------------------------------------------------//

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}
include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartseoobject.php";
include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjecttree.php";

class SmartcontentPage extends SmartSeoObject {

	var $_breadCrumb;

    function SmartcontentPage() {
        $this->quickInitVar('pageid', XOBJ_DTYPE_INT, true);
		$this->quickInitVar('parentid', XOBJ_DTYPE_INT, true, _CO_SCONTENT_PAGE_PARENT, _CO_SCONTENT_PAGE_PARENT_DSC);
		$this->quickInitVar('title', XOBJ_DTYPE_TXTBOX, true, _CO_SCONTENT_PAGE_TITLE, _CO_SCONTENT_PAGE_TITLE_DSC);
		$this->quickInitVar('menu_title', XOBJ_DTYPE_TXTBOX, false, _CO_SCONTENT_PAGE_MENUTITLE, _CO_SCONTENT_PAGE_MENUTITLE_DSC);
		$this->quickInitVar('is_external_link', XOBJ_DTYPE_INT, false);
		$this->quickInitVar('external_link', XOBJ_DTYPE_TXTBOX, false, _CO_SCONTENT_PAGE_EXTERNAL_LINK, _CO_SCONTENT_PAGE_EXTERNAL_LINK_DSC);
		$this->quickInitVar('body', XOBJ_DTYPE_TXTAREA, false, _CO_SCONTENT_PAGE_BODY, _CO_SCONTENT_PAGE_BODY_DSC);
		$this->quickInitVar('uid', XOBJ_DTYPE_INT, false, _CO_SCONTENT_PAGE_UID, _CO_SCONTENT_PAGE_UID_DSC);
		$this->quickInitVar('submenu', XOBJ_DTYPE_INT, false, _CO_SCONTENT_PAGE_SUBMENU, _CO_SCONTENT_PAGE_SUBMENU_DSC, true);
		$this->quickInitVar('datesub', XOBJ_DTYPE_INT, false, _CO_SCONTENT_PAGE_DATESUB, _CO_SCONTENT_PAGE_DATESUB_DSC);
		$this->quickInitVar('status', XOBJ_DTYPE_INT, false, _CO_SCONTENT_PAGE_STATUS, _CO_SCONTENT_PAGE_STATUS_DSC, _SCONTENT_STATUS_ONLINE);
		/*
		 * test_dev
		 */
		/*$this->quickInitVar('file', XOBJ_DTYPE_FILE, false, 'test_file');
		$this->quickInitVar('link', XOBJ_DTYPE_URLLINK, false, 'test_link');
		$this->quickInitVar('file2', XOBJ_DTYPE_FILE, false, 'test_file2');
		$this->quickInitVar('link2', XOBJ_DTYPE_URLLINK, false, 'test_link2');*/

        $this->initCommonVar('counter', false);
        $this->initCommonVar('weight');
        $this->initCommonVar('dohtml', true);
        $this->initCommonVar('dosmiley', false);
        $this->initCommonVar('doxcode', false);
        $this->initCommonVar('doimage', false);
        $this->initCommonVar('custom_css');

        global $xoopsModuleConfig;
        $value = isset($xoopsModuleConfig['dobr_default']) ? $xoopsModuleConfig['dobr_default'] : true;
        $this->initCommonVar('dobr', true,$value);

        $this->setControl('parentid', array('itemHandler' => 'page',
        									'module' => 'smartcontent',
        									'method' => 'getPageTree'));

        $this->setControl('body', array('name' => 'textarea',
                                        'itemHandler' => false,
                                        'method' => false,
                                        'module' => false,
                                        'form_editor' => 'default'));
        $this->setControl('submenu', 'yesno');
        $this->setControl('uid', array('name' => 'user'));
        $this->setControl('datesub', array('name' => 'date_time'));
        $this->setControl('status', array('name' => false,
                                          'itemHandler' => 'page',
                                          'method' => 'getStatus',
                                          'module' => 'smartcontent'));

        // call parent constructor to get SEO fields initiated
        $this->SmartSeoObject();
    }

    /**
    * returns a specific variable for the object in a proper format
    *
    * @access public
    * @param string $key key of the object's variable to be returned
    * @param string $format format to use for the output
    * @return mixed formatted value of the variable
    */
    function getVar($key, $format = 's') {
       if ($format == 's' && in_array($key, array('title', 'menu_title', 'uid', 'datesub', 'status', 'parentid', 'body', 'external_link'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

    function parentid(){

        $smartcontent_page_handler = xoops_getmodulehandler('page', 'smartcontent');

        $obj =& $smartcontent_page_handler->get($this->getVar('parentid', 'e'));
        $ret = $obj->getVar('name');
        return $ret;
    }

	function toArray(){
	    $myts = MyTextSanitizer::getInstance();

	    $objectArray = parent::toArray();
	    $objectArray['title'] = $myts->undoHtmlSpecialChars($objectArray['title']);
		$objectArray['body'] = explode('[pagebreak]', $objectArray['body']);
		$sectionid = isset($_GET['section']) && $_GET['section']!= '' ? intval($_GET['section']) : 0;
		if (isset($objectArray['body'][$sectionid-1])){
			$objectArray['previous'] = "<a href='page.php?pageid=".$this->id()."&section=".($sectionid-1)."'>"._CO_SCONTENT_PREV."</a>";
		}
		if (isset($objectArray['body'][$sectionid+1])){
			$objectArray['next'] = "<a href='page.php?pageid=".$this->id()."&section=".($sectionid+1)."'>"._CO_SCONTENT_NEXT."</a>";
		}
		$objectArray['body'] = $objectArray['body'][$sectionid];
		 return $objectArray;
    }

    function uid() {
        $ret = smart_getLinkedUnameFromId($this->getVar('uid', 'e'), false);
        return $ret;
    }

    function datesub() {
        $ret = formatTimestamp($this->getVar('datesub','e'));
        return $ret;
    }

 	function title() {
        $myts = MyTextSanitizer::getInstance();
        if (method_exists($myts, 'formatML')){
       		 $ret = $myts->formatForML($this->getVar('title','e'));
	    }else{
	       	 $ret = $this->getVar('title','e');
	    }

        return $ret;
    }

	function menu_title() {
        $myts = MyTextSanitizer::getInstance();
        if (method_exists($myts, 'formatML')){
       		$ret = $myts->formatForML($this->getVar('menu_title','e'));
        }else{
	       	$ret = $this->getVar('menu_title','e');

	    }
        return $ret;
    }

    function status() {
        global $statusArray;
        $ret = isset($statusArray[$this->getVar('status', 'e')]) ? $statusArray[$this->getVar('status','e')] : _CO_SCONTENT_STATUS_UNDEFINED;
        return $ret;
    }

    function body() {
    	$ret = $this->getValueFor('body', false);
    	// parse for smartpopup
    	$ret = smart_sanitizeForSmartpopupLink($ret);
    	return $ret;
    }

	function external_link() {
         $ret = str_replace('{XOOPS_URL}', XOOPS_URL , $this->getVar('external_link', 'e'));

        return $ret;
    }
    function getPageEditActionLink() {
    	if ($this->getVar('external_link')) {
    		$external = '&external';
    	} else {
    		$external = '';
    	}
		$ret = '<a href="' . SMARTCONTENT_URL . 'admin/page.php?op=mod&pageid=' . $this->id() . $external . '"><img src="' . SMARTOBJECT_IMAGES_ACTIONS_URL . 'edit.png" style="vertical-align: middle;" alt="' . _CO_SOBJECT_MODIFY . '" title="' . _CO_SOBJECT_MODIFY . '" /></a>';
		return $ret;
    }

    function getPageUrl() {
    	if ($this->getVar('external_link') != '') {
    		$ret = $this->getVar('external_link');
    	} else{
    		$ret = $this->getItemLink(true);
    	}
    	return $ret;
    }

    function getPageCloneActionLink() {
		$ret = '<a href="' . SMARTCONTENT_URL . 'admin/page.php?op=clone&pageid=' . $this->id() . '"><img src="' . SMARTOBJECT_IMAGES_ACTIONS_URL . 'editcopy.png" style="vertical-align: middle;" alt="' . _CO_SOBJECT_CLONE . '" title="' . _CO_SOBJECT_CLONE . '" /></a>';
		return $ret;
    }

    function getWeightControl() {
		$control = new XoopsFormText('', 'weight_' . $this->id(), 5, 100, $this->getVar('weight'));
		return $control->render();
    }

    function getParentidControl() {
    	$page_select = new XoopsFormSelect('', 'parentid_' . $this->id(), $this->getVar('parentid', 'e'));
    	$smartcontent_page_handler = xoops_getModuleHandler('page', 'smartcontent');
    	$page_select->addOptionArray($smartcontent_page_handler->getPageTree());
    	return $page_select->render();
    }

	function getStatusControl() {
    	$page_select = new XoopsFormSelect('', 'status_' . $this->id(), $this->getVar('status', 'e'));
    	$smartcontent_page_handler = xoops_getModuleHandler('page', 'smartcontent');
    	$page_select->addOptionArray($smartcontent_page_handler->getStatus());
    	return $page_select->render();
    }

	function getSubmenuControl() {
    	$menu_yesno = new XoopsFormRadioYN('', 'submenu_' . $this->id(), $this->getVar('submenu'));
    	return $menu_yesno->render();
    }

    function getTitleLink() {
		$title = $this->getVar('title');
		$extra_title = '';

    	if ($this->getVar('external_link')) {
			$url = $this->getVar('external_link');
			$img_alt = _CO_SCONTENT_PAGE_EXTERNAL_LINK . ':&nbsp;' . $url;
			$extra_title = '&nbsp;<img style="vertical-align: middle;" src="' . SMARTCONTENT_IMAGES_URL . 'links/link.gif' . '" alt="' . $img_alt . '" title="' . $img_alt . '" />';
    	} else {
    		$url = $this->getItemLink(true);
    	}

		$ret = '<a href="' . $this->getItemLink(true) . '">' . $title . '</a>' . $extra_title;
		return $ret;
    }
    function getBreadCrumb($withAllLink=true, $currentPage=false)	{

		include_once SMARTOBJECT_ROOT_PATH . "class/smartobjectcontroller.php";
        $controller = new SmartObjectController($this->handler);

		if (!$this->_breadCrumb) {
			if ($withAllLink && !$currentPage) {
				$ret = $controller->getItemLink($this);
			} else {
				$currentPage = false;
				$ret = $this->getVar('title');
			}
			$parentid = $this->getVar('parentid', 'e');
			if ($parentid != 0) {
				$parentObj =& $this->handler->get($parentid);
				if ($parentObj->isNew()) {
					exit;
				}
				$parentid = $parentObj->getVar('parentid', 'e');
				$ret = $parentObj->getBreadCrumb($withAllLink, $currentPage) . " > " .$ret;
			}
			$this->_breadCrumb = $ret;
        }

		return $this->_breadCrumb;
	}


}

class SmartcontentPageHandler extends SmartPersistableObjectHandler {
   	var $objects = false;
    function SmartcontentPageHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'page', 'pageid', 'title', 'body', 'smartcontent');
        $this->addPermission('read_perm', _CO_SCONTENT_PERM_READ, _CO_SCONTENT_PERM_READ_DSC);
    	$this->highlightFields = array('title', 'body');
    }

    function getStatus(){
        global $statusArray;
        return $statusArray;
    }



    function getPagesList() {
    	$pagesList = $this->getList();
    	$ret = array(0=>'-----');
    	$ret[-1] = _AM_SCONTENT_PAGE_SET_EXT_LINK;
    	foreach ($pagesList as $k=>$v) {
    		$ret[$k] = $v;
    	}
    	return $ret;
    }

	function getItemsFromSearch($queryarray = array(), $andor = 'AND', $limit = 0, $offset = 0, $userid = 0)
	{

		$ret = array();

		if ($userid != 0) {
			$criteriaUser = new CriteriaCompo();
			$criteriaUser->add(new Criteria('uid', $userid), 'OR');
		}

		if ($queryarray) {
			$criteriaKeywords = new CriteriaCompo();
			for ($i = 0; $i < count($queryarray); $i++) {
				$criteriaKeyword = new CriteriaCompo();
				$criteriaKeyword->add(new Criteria('title', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeyword->add(new Criteria('body', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
				$criteriaKeywords->add($criteriaKeyword, $andor);
				unset($criteriaKeyword);
			}
		}

		$criteriaItemsStatus = new CriteriaCompo();
		$criteriaItemsStatus->add(new Criteria('status', _SCONTENT_STATUS_ONLINE));

		$criteria = new CriteriaCompo();
		if (!empty($criteriaUser)) {
			$criteria->add($criteriaUser, 'AND');
		}

		if (!empty($criteriaKeywords)) {
			$criteria->add($criteriaKeywords, 'AND');
		}

		if (!empty($criteriaItemsStatus)) {
			$criteria->add($criteriaItemsStatus, 'AND');
		}

		$criteria->setLimit($limit);
		$criteria->setStart($offset);
		$criteria->setSort('title');

		$itemsObj = $this->getObjects($criteria);

		if (count($itemsObj) == 0) {
			return $ret;
		}

		foreach ($itemsObj as $itemObj) {
			$item['id'] = $itemObj->getVar('pageid');
			$item['title'] = $itemObj->getVar('title');
			$item['datesub'] = $itemObj->getVar('datesub');
			$item['uid'] = $itemObj->getVar('uid', 'e');

			$ret[] = $item;
			unset($item);
		}

		return $ret;
	}
	function getPageTree($addNoParent = true){
		$criteria = new CriteriaCompo();
        $criteria->setSort("weight, title");
        $pages = $this->getObjects($criteria);

        $mytree = new SmartObjectTree($pages, "pageid", "parentid");
		$ret = array();

		$options = $this->getOptionArray($mytree, "title", 0, "", $ret);
        if ($addNoParent) {
        	$newOptions = array('0'=>'----');
        	foreach ($options as $k=>$v) {
        		$newOptions[$k] = $v;
        	}
        	$options = $newOptions;
        }
        return $options;

	}

	 /**
     * Get options for a category select with hierarchy (recursive)
     *
     * @param XoopsObjectTree $tree
     * @param string $fieldName
     * @param int $key
     * @param string $prefix_curr
     * @param array $ret
     *
     * @return array
     */
    function getOptionArray($tree, $fieldName, $key, $prefix_curr = "", &$ret) {

        if ($key > 0) {
            $value = $tree->_tree[$key]['obj']->getVar($tree->_myId);
			$ret[$key] = $prefix_curr.$tree->_tree[$key]['obj']->getVar($fieldName);
            $prefix_curr .= "-";
        }

        if (isset($tree->_tree[$key]['child']) && !empty($tree->_tree[$key]['child'])) {
            foreach ($tree->_tree[$key]['child'] as $childkey) {
                $this->getOptionArray($tree, $fieldName, $childkey, $prefix_curr, $ret);
            }
        }
        return $ret;
    }


}
?>