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

include_once XOOPS_ROOT_PATH.'/modules/smartcontent/include/common.php';

function smartcontent_create_upload_folders()
{
	$handlers_array = array( 'page');
	foreach($handlers_array as $item) {
		$hanlder =& xoops_getmodulehandler($item, 'smartcontent');
		smart_admin_mkdir($hanlder->getImagePath());
	}
}




function smartcontent_getOrderBy($sort)
{
	if ($sort == "datesub") {
		return "DESC";
	} elseif ($sort == "counter") {
		return "DESC";
	} elseif ($sort == "weight") {
		return "ASC";
	}
}
/**
 * Detemines if a table exists in the current db
 *
 * @param string $table the table name (without XOOPS prefix)
 * @return bool True if table exists, false if not
 *
 * @access public
 * @author xhelp development team
 */
function smartcontent_TableExists($table)
{

	$bRetVal = false;
	//Verifies that a MySQL table exists
	$xoopsDB =& Database::getInstance();
	$realname = $xoopsDB->prefix($table);
	$ret = mysql_list_tables(XOOPS_DB_NAME, $xoopsDB->conn);
	while (list($m_table)=$xoopsDB->fetchRow($ret)) {

		if ($m_table ==  $realname) {
			$bRetVal = true;
			break;
		}
	}
	$xoopsDB->freeRecordSet($ret);
	return ($bRetVal);
}
/**
 * Gets a value from a key in the xhelp_meta table
 *
 * @param string $key
 * @return string $value
 *
 * @access public
 * @author xhelp development team
 */
function smartcontent_GetMeta($key)
{
	$xoopsDB =& Database::getInstance();
	$sql = sprintf("SELECT metavalue FROM %s WHERE metakey=%s", $xoopsDB->prefix('smartcontent_meta'), $xoopsDB->quoteString($key));
	$ret = $xoopsDB->query($sql);
	if (!$ret) {
		$value = false;
	} else {
		list($value) = $xoopsDB->fetchRow($ret);

	}
	return $value;
}

/**
 * Sets a value for a key in the xhelp_meta table
 *
 * @param string $key
 * @param string $value
 * @return bool TRUE if success, FALSE if failure
 *
 * @access public
 * @author xhelp development team
 */
function smartcontent_SetMeta($key, $value)
{
	$xoopsDB =& Database::getInstance();
	if($ret = smartcontent_GetMeta($key)){
		$sql = sprintf("UPDATE %s SET metavalue = %s WHERE metakey = %s", $xoopsDB->prefix('smartcontent_meta'), $xoopsDB->quoteString($value), $xoopsDB->quoteString($key));
	} else {
		$sql = sprintf("INSERT INTO %s (metakey, metavalue) VALUES (%s, %s)", $xoopsDB->prefix('smartcontent_meta'), $xoopsDB->quoteString($key), $xoopsDB->quoteString($value));
	}
	$ret = $xoopsDB->queryF($sql);
	if (!$ret) {
		return false;
	}
	return true;
}

function smartcontent_highlighter ($matches) {

	$smartContentConfig =& smartcontent_getModuleConfig();
	$color = $smartContentConfig['highlight_color'];
	if(substr($color,0,1)!='#') {
		$color='#'.$color;
	}
	return '<span style="font-weight: bolder; background-color: '.$color.';">' . $matches[0] . '</span>';
}

// Thanks to Mithrandir :-)
function smartcontent_substr($str, $start, $length, $trimmarker = '...')
{
	// If the string is empty, let's get out ;-)
	if ($str == '') {
		return $str;
	}

	// reverse a string that is shortened with '' as trimmarker
	$reversed_string = strrev(xoops_substr($str, $start, $length, ''));

	// find first space in reversed string
	$position_of_space = strpos($reversed_string, " ", 0);

	// truncate the original string to a length of $length
	// minus the position of the last space
	// plus the length of the $trimmarker
	$truncated_string = xoops_substr($str, $start, $length-$position_of_space+strlen($trimmarker), $trimmarker);

	return $truncated_string;
}

function smartcontent_getConfig($key)
{
	$configs = smartcontent_getModuleConfig();
	return $configs[$key];
}

function smartcontent_metagen_html2text($document)
{
	// PHP Manual:: function preg_replace
	// $document should contain an HTML document.
	// This will remove HTML tags, javascript sections
	// and white space. It will also convert some
	// common HTML entities to their text equivalent.
	// Credits : newbb2

	$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
	"'<img.*?/>'si",       // Strip out img tags
	"'<[\/\!]*?[^<>]*?>'si",          // Strip out HTML tags
	"'([\r\n])[\s]+'",                // Strip out white space
	"'&(quot|#34);'i",                // Replace HTML entities
	"'&(amp|#38);'i",
	"'&(lt|#60);'i",
	"'&(gt|#62);'i",
	"'&(nbsp|#160);'i",
	"'&(iexcl|#161);'i",
	"'&(cent|#162);'i",
	"'&(pound|#163);'i",
	"'&(copy|#169);'i",
	"'&#(\d+);'e");                    // evaluate as php

	$replace = array ("",
	"",
	"",
	"\\1",
	"\"",
	"&",
	"<",
	">",
	" ",
	chr(161),
	chr(162),
	chr(163),
	chr(169),
	"chr(\\1)");

	$text = preg_replace($search, $replace, $document);
	return $text;
}

function smartcontent_getAllowedImagesTypes()
{
	return array('jpg/jpeg', 'image/bmp', 'image/gif', 'image/jpeg', 'image/jpg', 'image/x-png', 'image/png', 'image/pjpeg');
}


/**
 * Copy a file, or a folder and its contents
 *
 * @author      Aidan Lister <aidan@php.net>
 * @version     1.0.0
 * @param       string   $source    The source
 * @param       string   $dest      The destination
 * @return      bool     Returns true on success, false on failure
 */
function smartcontent_copyr($source, $dest)
{
	// Simple copy for a file
	if (is_file($source)) {
		return copy($source, $dest);
	}

	// Make destination directory
	if (!is_dir($dest)) {
		mkdir($dest);
	}

	// Loop through the folder
	$dir = dir($source);
	while (false !== $entry = $dir->read()) {
		// Skip pointers
		if ($entry == '.' || $entry == '..') {
			continue;
		}

		// Deep copy directories
		if (is_dir("$source/$entry") && ($dest !== "$source/$entry")) {
			copyr("$source/$entry", "$dest/$entry");
		} else {
			copy("$source/$entry", "$dest/$entry");
		}
	}

	// Clean up
	$dir->close();
	return true;
}

function smartcontent_getEditor($caption, $name, $value, $dhtml = true)
{
	$smartContentConfig =& smartcontent_getModuleConfig();
	switch ($smartContentConfig['use_wysiwyg']) {
		case 'tiny' :
		if ( is_readable(XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinytextarea.php"))	{
			include_once(XOOPS_ROOT_PATH . "/class/xoopseditor/tinyeditor/formtinytextarea.php");
			$editor = new XoopsFormTinyTextArea(array('caption'=> $caption, 'name'=>$name, 'value'=>$value, 'width'=>'100%', 'height'=>'300px'),true);
		} else {
			if ($dhtml) {
				$editor = new XoopsFormDhtmlTextArea($caption, $name, $value, 20, 60);
			} else {
				$editor = new XoopsFormTextArea($caption, $name, $value, 7, 60);
			}
		}
		break;

		case 'koivi' :
		if ( is_readable(XOOPS_ROOT_PATH . "/class/wysiwyg/formwysiwygtextarea.php"))	{
			include_once(XOOPS_ROOT_PATH . "/class/wysiwyg/formwysiwygtextarea.php");
			$editor = new XoopsFormWysiwygTextArea($caption, $name, $value, '100%', '400px');
		} else {
			if ($dhtml) {
				$editor = new XoopsFormDhtmlTextArea($caption, $name, $value, 20, 60);
			} else {
				$editor = new XoopsFormTextArea($caption, $name, $value, 7, 60);
			}
		}
		break;

		default :
		if ($dhtml) {
			$editor = new XoopsFormDhtmlTextArea($caption, $name, $value, 20, 60);
		} else {
			$editor = new XoopsFormTextArea($caption, $name, $value, 7, 60);
		}

		break;
	}

	return $editor;
}


/**
* Thanks to the NewBB2 Development Team
*/
function smartcontent_admin_mkdir($target)
{
	// http://www.php.net/manual/en/function.mkdir.php
	// saint at corenova.com
	// bart at cdasites dot com
	if (is_dir($target) || empty($target)) {
		return true; // best case check first
	}

	if (file_exists($target) && !is_dir($target)) {
		return false;
	}

	if (smartcontent_admin_mkdir(substr($target,0,strrpos($target,'/')))) {
		if (!file_exists($target)) {
			$res = mkdir($target, 0777); // crawl back up & create dir tree
			smartcontent_admin_chmod($target);
			return $res;
		}
	}
	$res = is_dir($target);
	return $res;
}

/**
* Thanks to the NewBB2 Development Team
*/
function smartcontent_admin_chmod($target, $mode = 0777)
{
	return @chmod($target, $mode);
}


function smartcontent_getUploadDir($local=true, $item=false)
{
	if ($item) {
		if ($item=='root') {
			$item = '';
		} else {
			$item = $item . '/';
		}
	} else {
		$item = '';
	}

	If ($local) {
		return XOOPS_ROOT_PATH . "/uploads/smartcontent/$item";
	} else {
		return XOOPS_URL . "/uploads/smartcontent/$item";
	}
}

function smartcontent_getImageDir($item='', $local=true)
{
	if ($item) {
		$item = "images/$item";
	} else {
		$item = 'images';
	}

	return smartcontent_getUploadDir($local, $item);
}

function smartcontent_imageResize($src, $maxWidth, $maxHeight)
{
	$width = '';
	$height = '';
	$type = '';
	$attr = '';

	if (file_exists($src)) {
		list($width, $height, $type, $attr) = getimagesize($src);
		If ($width > $maxWidth) {
			$originalWidth = $width;
			$width = $maxWidth;
			$height = $width * $height / $originalWidth;
		}

		If ($height > $maxHeight) {
			$originalHeight = $height;
			$height = $maxHeight;
			$width = $height * $width / $originalHeight;
		}

		$attr = " width='$width' height='$height'";
	}
	return array($width, $height, $type, $attr);
}

function smartcontent_getHelpPath()
{
	$smartContentConfig =& smartcontent_getModuleConfig();
	switch ($smartContentConfig['helppath_select'])
	{
		case 'docs.xoops.org' :
		return 'http://docs.xoops.org/help/ssectionh/index.htm';
		break;

		case 'inside' :
		return XOOPS_URL . "/modules/smartcontent/doc/";
		break;

		case 'custom' :
		return $smartContentConfig['helppath_custom'];
		break;
	}
}

function &smartcontent_getModuleInfo()
{
	static $smartContentModule;
	if (!isset($smartContentModule)) {
		global $xoopsModule;
		if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == 'smartcontent') {
			$smartContentModule =& $xoopsModule;
		}
		else {
			$hModule = &xoops_gethandler('module');
			$smartContentModule = $hModule->getByDirname('smartcontent');
		}
	}
	return $smartContentModule;
}

function &smartcontent_getModuleConfig()
{
	static $smartContentConfig;
	if (!$smartContentConfig) {
		global $xoopsModule;
		if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == 'smartcontent') {
			global $xoopsModuleConfig;
			$smartContentConfig =& $xoopsModuleConfig;
		}
		else {
			$smartContentModule =& smartcontent_getModuleInfo();
			$hModConfig = &xoops_gethandler('config');
			$smartContentConfig = $hModConfig->getConfigsByCat(0, $smartContentModule->getVar('mid'));
		}
	}
	return $smartContentConfig;
}


function smartcontent_deleteFile($dirname)
{
	// Simple delete for a file
	if (is_file($dirname)) {
		return unlink($dirname);
	}
}

function smartcontent_formatErrors($errors=array())
{
	$ret = '';
	foreach ($errors as $key=>$value)
	{
		$ret .= "<br /> - " . $value;
	}
	return $ret;
}




function smartcontent_getStatusArray ()
{
	$result = array("1" => _AM_SCONTENT_STATUS1,
	"2" => _AM_SCONTENT_STATUS2,
	"3" => _AM_SCONTENT_STATUS3,
	"4" => _AM_SCONTENT_STATUS4,
	"5" => _AM_SCONTENT_STATUS5,
	"6" => _AM_SCONTENT_STATUS6,
	"7" => _AM_SCONTENT_STATUS7,
	"8" => _AM_SCONTENT_STATUS8);
	return $result;
}


/**
* Checks if a user is admin of SmartContent
*
* smartcontent_userIsAdmin()
*
* @return boolean : array with userids and uname
*/
function smartcontent_userIsAdmin()
{
	global $xoopsUser;

	static $smartcontent_isAdmin;

	if (isset($smartcontent_isAdmin)) {
		return $smartcontent_isAdmin;
	}

	if (!$xoopsUser) {
		$smartcontent_isAdmin = false;
		return $smartcontent_isAdmin;
	}

	$smartcontent_isAdmin = false;

	$smartContentModule = smartcontent_getModuleInfo();
	$module_id = $smartContentModule->getVar('mid');
	$smartcontent_isAdmin = $xoopsUser->isAdmin($module_id);

	return $smartcontent_isAdmin;
}

/**
* Checks if a user has access to a selected item. If no item permissions are
* set, access permission is denied. The user needs to have necessary category
* permission as well.
*
* smartcontent_itemAccessGranted()
*
* @param integer $itemid : itemid on which we are setting permissions
* @param integer $ categoryid : categoryid of the item
* @return boolean : TRUE if the no errors occured
*/



function smartcontent_getLinkedUnameFromId($userid = 0, $name = 0, $users = array())
{
	if (!is_numeric($userid)) {
		return $userid;
	}

	$userid = intval($userid);
	if ($userid > 0) {
		if ($users == array()) {
			//fetching users
			$member_handler = &xoops_gethandler('member');
			$user = &$member_handler->getUser($userid);
		}
		else {
			if (!isset($users[$userid])) {
				return $GLOBALS['xoopsConfig']['anonymous'];
			}
			$user =& $users[$userid];
		}

		if (is_object($user)) {
			$ts = &MyTextSanitizer::getInstance();
			$username = $user->getVar('uname');
			$fullname = '';

			$fullname2 = $user->getVar('name');

			if (($name) && !empty($fullname2)) {
				$fullname = $user->getVar('name');
			}
			if (!empty($fullname)) {
				$linkeduser = "$fullname [<a href='" . XOOPS_URL . "/userinfo.php?uid=" . $userid . "'>" . $ts->htmlSpecialChars($username) . "</a>]";
			} else {
				$linkeduser = "<a href='" . XOOPS_URL . "/userinfo.php?uid=" . $userid . "'>" . ucwords($ts->htmlSpecialChars($username)) . "</a>";
			}
			return $linkeduser;
		}
	}
	return $GLOBALS['xoopsConfig']['anonymous'];
}

function smartcontent_getxoopslink($url = '')
{
	$xurl = $url;
	If (strlen($xurl) > 0) {
		If ($xurl[0] = '/') {
			$xurl = str_replace('/', '', $xurl);
		}
		$xurl = str_replace('{SITE_URL}', XOOPS_URL, $xurl);
	}
	$xurl = $url;
	return $xurl;
}

function &smartcontent_gethandler($name)
{
	static $smartcontent_handlers;

	if (!isset($smartcontent_handlers[$name])) {
		$smartcontent_handlers[$name] =& xoops_getmodulehandler($name, 'smartcontent');
	}
	return $smartcontent_handlers[$name];
}

/**
 * Generate smartcontent URL
 *
 * @param string $page
 * @param array $vars
 * @return
 *
 * @access public
 * @credit : xHelp module, developped by 3Dev
 */
function smartcontent_makeURI($page, $vars = array(), $encodeAmp = true)
{
	$joinStr = '';

	$amp = ($encodeAmp ? '&amp;': '&');

	if (! count($vars)) {
		return $page;
	}
	$qs = '';
	foreach($vars as $key=>$value) {
		$qs .= $joinStr . $key . '=' . $value;
		$joinStr = $amp;
	}
	return $page . '?'. $qs;
}

function smart_highlighter ($matches) {

	$color = smart_getConfig('module_search_highlight_color', false, '#FFFF80');

	if(substr($color,0,1)!='#') {
		$color='#'.$color;
	}
	return '<span style="font-weight: bolder; background-color: '.$color.';">' . $matches[0] . '</span>';
}

?>