<?php

static $smartcontent_submenus;
static $smartcontent_mainmenu;
static $xoops_urls;

if (!isset($smartcontent_mainmenu)) {

	include_once(XOOPS_ROOT_PATH . '/modules/smartcontent/include/common.php');

	$smartcontent_page_handler = xoops_getModuleHandler('page', 'smartcontent');

	// is the page we are in is a page or an external link of SmartContent ?
	if (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == 'smartcontent') {
		// we are in SmartContent
		if (isset($smartcontent_pageObj)) {
			$currentPageObj = $smartcontent_page_handler->get(intval($_GET['pageid']));
		}
		$url = $xoops_urls['full'];
	} else {
		if (!isset($xoops_urls)) {
			include_once XOOPS_ROOT_PATH.'/modules/smartobject/include/functions.php';
			$xoops_urls = smart_getCurrentUrls();
		}
		$url = $xoops_urls['full'];
		/*
		 * big fat hack
		 */
/*		 $url = strrev(str_replace($xoops_urls['querystring'], '', $xoops_urls['full']));
		 if(substr($url, 0, 4) == 'php.'){
		 	$url = substr($url, 4, strlen($url)-1);
		 	while(substr($url, 0, 1) != '/'){
		 		$url = substr($url, 1, strlen($url)-1);
		 	}
		 }
		  $url = strrev($url);
*/		 /*
		 * big fat hack
		 */
		// we are not in SmartContent. Let's check if the current url matches any external_link of SmartContent
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('external_link', $url));
		$criteria->add(new Criteria('status', _SCONTENT_STATUS_ONLINE));
		$pagesObj = $smartcontent_page_handler->getObjects($criteria);
		if ($pagesObj && count($pagesObj) != 0) {
			$currentPageObj = $pagesObj[0];
		}
	}

	if (isset($currentPageObj)) {
		// we are on a page of or managed by SmartContent
		$parentid = $currentPageObj->getVar('parentid', 'e');
		if ($parentid) {
			// this page is in a category so let's retreive the other pages of this category
			$categoryObj = $smartcontent_category_handler->get($parentid);
			if (!$categoryObj->isNew()) {
				$otherPagesObj = $smartcontent_page_handler->getPagesOfCategory($categoryObj->id());
				if ($otherPagesObj) {
					$i = -1;
					foreach ($otherPagesObj as $pageObj) {
						if ($pageObj->getVar('submenu')) {
							$i++;
							$itemExternal = $pageObj->getVar('external_link');
							$itemLink = $pageObj->getItemLink(true);
							$smartcontent_submenus[$i]['caption'] = $pageObj->getVar('title');
							$smartcontent_submenus[$i]['link'] = $itemExternal ? $itemExternal : $itemLink;
							$smartcontent_submenus[$i]['id'] = $pageObj->getVar('short_url');
							if (($url != '' && $url == $itemExternal) || $xoops_urls['full'] == $itemLink) {
								// this is the object selected
								$smartcontent_submenus[$i]['selected'] = true;
								$selectedPage = $pageObj;
							}
						}
					}

					$y = round(count($smartcontent_submenus) / 2);
					if ($y <= 4) $y = 4;

					$y2 = $y-1;

				}
			}
		}
	}

	$pagesObj = $smartcontent_page_handler->getPagesOfCategory(0);

	if ($pagesObj) {
		$i = -1;
		foreach ($pagesObj as $pageObj) {
			$i++;
			$itemLink = $pageObj->getItemLink(true);
			$itemExternal = $pageObj->getVar('external_link');
			//hack for planetair

			if ($pageObj->getVar('submenu')) {
				$itemExternal = $pageObj->getVar('external_link');
				$itemLink = $pageObj->getItemLink(true);
				$smartcontent_submenu = $itemExternal ? $itemExternal : $itemLink;

			}

			$smartcontent_mainmenu[$i]['caption'] = $pageObj->getVar('title');
			$smartcontent_mainmenu[$i]['link'] = $itemExternal ? $itemExternal : $itemLink;
			$smartcontent_mainmenu[$i]['id'] = $pageObj->getVar('short_url');
			/*echo "Url: " ;var_dump($url);echo"<br>";
			echo "smartcontent_submenu: " ;var_dump($smartcontent_submenu);echo"<br>";
			echo"<br><br><br>";*/
			//if (($url != '' && $url == $itemExternal || in_array($url, $smartcontent_submenus))) || $xoops_urls['full'] == $itemLink || in_array($xoops_urls['full'], $subLinks)) {
			if (($url != '' && $url == $itemExternal) || $xoops_urls['full'] == $itemLink || (isset($currentPageObj) && $this->getVar('link2page') == $currentPageObj->getVar('pageid', 'e')) || $url == $smartcontent_submenu ) {
				// this is the object selected
				$smartcontent_mainmenu[$i]['selected'] = true;
			}
		unset($subUrls);
		}
	}
}

if (is_object($xoopsTpl)) {
	$xoopsTpl->assign('xoops_urls', $xoops_urls);
	$xoopsTpl->assign('smartcontent_submenus', $smartcontent_submenus);
	$xoopsTpl->assign('smartcontent_mainmenu', $smartcontent_mainmenu);
	$xoopsTpl->assign('smartcontent_submenus_biggerhalf', $y);
	$xoopsTpl->assign('smartcontent_submenus_biggerhalf_minus1', $y2);
}
?>