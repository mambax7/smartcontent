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

$modversion['name'] = _MI_SCONTENT_MD_NAME;
$modversion['version'] = 1.1;
$modversion['description'] = _MI_SCONTENT_MD_DESC;
$modversion['author'] = "The SmartFactory [www.smartfactory.ca]";
$modversion['credits'] = "INBOX Solutions, Sudhaker, Ampersand Design, Technigrapha";
$modversion['help'] = "";
$modversion['license'] = "GNU General Public License (GPL)";
$modversion['official'] = 0;
$modversion['dirname'] = "smartcontent";

// Settting InBox module image if it is present
$inbox_logo_filename = $modversion['dirname'] . "_inbox_logo.gif";

if (file_exists(XOOPS_ROOT_PATH . "/modules/" . $modversion['dirname'] . "/images/" . $inbox_logo_filename)) {
	$modversion['image'] = "images/$inbox_logo_filename";
} else {
	$modversion['image'] = "images/module_logo.gif";
}

// Added by marcan for the About page in admin section
$modversion['developer_lead'] = "marcan [Marc-André Lanciault]";
$modversion['developer_contributor'] = "Mithrandir, Sudhaker, Felix, Fred";
$modversion['developer_website_url'] = "http://smartfactory.ca";
$modversion['developer_website_name'] = "The SmartFactory";
$modversion['developer_email'] = "info@smartfactory.ca";
$modversion['status_version'] = "Beta 1";
$modversion['status'] = "Beta";
$modversion['date'] = "unreleased";

$modversion['warning'] = _CO_SOBJECT_WARNING_BETA;

$modversion['demo_site_url'] = "";
$modversion['demo_site_name'] = "";
$modversion['support_site_url'] = "http://smartfactory.ca/modules/newbb/";
$modversion['support_site_name'] = "The SmartFactory Community Forums";
$modversion['submit_bug'] = "";
$modversion['submit_feature'] = "";
$modversion['submit_feature'] = "";
$modversion['submit_feature'] = "";

$modversion['author_word'] = "";

$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

$modversion['onInstall'] = "include/onupdate.inc.php";
$modversion['onUpdate'] = "include/onupdate.inc.php";

$modversion['tables'][0] = "smartcontent_meta";
$modversion['tables'][1] = "smartcontent_page";

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "smartcontent_search";
// Menu
$modversion['hasMain'] = 1;
$i = 0;
/*
$i++;
$modversion['blocks'][$i]['file'] = "b_spotlight.php";
$modversion['blocks'][$i]['name'] = _MI_SCONTENT_SPOTLIGHT;
$modversion['blocks'][$i]['description'] = "Displays 1 or more pages in a block";
$modversion['blocks'][$i]['show_func'] = "smartcontent_spotlight_show";
$modversion['blocks'][$i]['edit_func'] = "smartcontent_spotlight_edit";
$modversion['blocks'][1]['options'] = "";
$modversion['blocks'][1]['template'] = "smartcontent_spotlight.html";*/

$i++;
$modversion['blocks'][$i]['file'] = "smartcontent_menu.php";
$modversion['blocks'][$i]['name'] = _MI_SCONTENT_B_NAVIGATION;
$modversion['blocks'][$i]['description'] = "Displays a navigation menu";
$modversion['blocks'][$i]['show_func'] = "smartcontent_menu_show";
$modversion['blocks'][$i]['edit_func'] = "smartcontent_menu_edit";
$modversion['blocks'][$i]['options'] = "";
$modversion['blocks'][$i]['template'] = "smartcontent_navigation.html";

$i++;
$modversion['blocks'][$i]['file'] = "smartcontent_top_menu.php";
$modversion['blocks'][$i]['name'] = _MI_SCONTENT_B_TOPPAGES;
$modversion['blocks'][$i]['description'] = "Displays top pages menu";
$modversion['blocks'][$i]['show_func'] = "smartcontent_top_menu_show";
$modversion['blocks'][$i]['edit_func'] = "smartcontent_top_menu_edit";
$modversion['blocks'][$i]['options'] = "";
$modversion['blocks'][$i]['template'] = "smartcontent_topmenu.html";

$i++;
$modversion['blocks'][$i]['file'] = "smartcontent_sub_menu.php";
$modversion['blocks'][$i]['name'] = _MI_SCONTENT_B_SUBPAGE;
$modversion['blocks'][$i]['description'] = "Displays subpage of current page.";
$modversion['blocks'][$i]['show_func'] = "smartcontent_sub_menu_show";
$modversion['blocks'][$i]['edit_func'] = "smartcontent_sub_menu_edit";
$modversion['blocks'][$i]['options'] = "";
$modversion['blocks'][$i]['template'] = "smartcontent_submenu.html";

global $xoopsModule;

// Templates
$i = 0;

$i++;
$modversion['templates'][$i]['file'] = 'smartcontent_admin_menu.html';
$modversion['templates'][$i]['description'] = '(Admin) Tabs bar for administration pages';

$i++;
$modversion['templates'][$i]['file'] = 'smartcontent_header.html';
$modversion['templates'][$i]['description'] = 'Header template of all pages';

$i++;
$modversion['templates'][$i]['file'] = 'smartcontent_footer.html';
$modversion['templates'][$i]['description'] = 'Footer template of all pages';

$i++;
$modversion['templates'][$i]['file'] = 'smartcontent_page.html';
$modversion['templates'][$i]['description'] = 'Single page template';

$i++;
$modversion['templates'][$i]['file'] = 'smartcontent_display_content.html';
$modversion['templates'][$i]['description'] = 'Display Index and Category page';

$i++;
$modversion['templates'][$i]['file'] = 'smartcontent_print.html';
$modversion['templates'][$i]['description'] = 'Print friendly page';

$i++;
$modversion['templates'][$i]['file'] = 'smartcontent_submenus.html';
$modversion['templates'][$i]['description'] = 'Displays Submenus';

$i++;
$modversion['templates'][$i]['file'] = 'smartcontent_navigation_loop.html';
$modversion['templates'][$i]['description'] = 'Navigation loop in the block';


// Config Settings (only for modules that need config settings generated automatically)
$i = 0;
/*
$i++;
$modversion['config'][$i]['name'] = 'show_subcats';
$modversion['config'][$i]['title'] = '_MI_SCONTENT_SHOW_SUBCATS';
$modversion['config'][$i]['description'] = '_MI_SCONTENT_SHOW_SUBCATS_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'all';
$modversion['config'][$i]['options'] = array(_MI_SCONTENT_SHOW_SUBCATS_NO  => 'no',
                                   		_MI_SCONTENT_SHOW_SUBCATS_NOTEMPTY   => 'nonempty',
                                  		 _MI_SCONTENT_SHOW_SUBCATS_ALL => 'all');
*/

$modversion['config'][$i]['name'] = 'allow_browsing';
$modversion['config'][$i]['title'] = '_MI_SCONTENT_ALLOWBROWS';
$modversion['config'][$i]['description'] = '_MI_SCONTENT_ALLOWBROWSDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;

$modversion['config'][$i]['name'] = 'home_url';
$modversion['config'][$i]['title'] = '_MI_SCONTENT_HOME';
$modversion['config'][$i]['description'] = '_MI_SCONTENT_HOMEDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = XOOPS_URL . '/modules/smartcontent/';
$i++;

$modversion['config'][$i]['name'] = 'display_cat_in_breadcrumb';
$modversion['config'][$i]['title'] = '_MI_SCONTENT_DISCATBREAD';
$modversion['config'][$i]['description'] = '_MI_SCONTENT_DISCATBREADDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;

$modversion['config'][$i]['name'] = 'items_per_page';
$modversion['config'][$i]['title'] = '_MI_SCONTENT_ITEMSPERPAGE';
$modversion['config'][$i]['description'] = '_MI_SCONTENT_ITEMSPERPAGE_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = array('5'  => 5,
                                   			'10'  => 10,
                                   			'15'  => 15,
                                   			'20'  => 20,
                                   			'25'  => 25,
                                   			'30'  => 30,
                                  		 );
$modversion['config'][$i]['default'] = '10';
$i++;

$modversion['config'][$i]['name'] = 'module_meta_description';
$modversion['config'][$i]['title'] = '_MI_SCONTENT_MODMETADESC';
$modversion['config'][$i]['description'] = '_MI_SCONTENT_MODMETADESC_DSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';
$i++;

$modversion['config'][$i]['name'] = 'default_editor';
$modversion['config'][$i]['title'] = '_MI_SCONTENT_EDITOR';
$modversion['config'][$i]['description'] = '_MI_SCONTENT_EDITOR_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
include_once(XOOPS_ROOT_PATH . '/modules/smartobject/include/functions.php');
$modversion['config'][$i]['options'] = smart_getEditors();
/*$modversion['config'][$i]['options'] = array('TextArea'  => 'textarea',
                                   			 'DHTML Text Area' => 'dhtmltextarea',
                                   			 'TinyEditor' => 'tiny',
                                   			 'FCKEditor' => 'fckeditor',
                                   			 'FCKEditor2' => 'fckeditor2',
                                   			 'InBetween' => 'inbetween',
                                   			 'Koivi' => 'koivi',
                                   			 'Spaw' => 'spaw',
                                   			 'HTMLArea' => 'htmlarea'
                                  		 );*/
$modversion['config'][$i]['default'] = 'dhtmltextarea';
$i++;

$modversion['config'][$i]['name'] = 'dobr_default';
$modversion['config'][$i]['title'] = '_MI_SCONTENT_DOBR_DEF';
$modversion['config'][$i]['description'] = '_MI_SCONTENT_DOBR_DEFDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;

$modversion['config'][$i]['name'] = 'show_breadcrumb';
$modversion['config'][$i]['title'] = '_MI_SCONTENT_SHOW_BCRUMB';
$modversion['config'][$i]['description'] = '_MI_SCONTENT_SHOW_BCRUMBDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;

$modversion['config'][$i]['name'] = 'show_mod_name_breadcrumb';
$modversion['config'][$i]['title'] = '_MI_SCONTENT_BCRUMB';
$modversion['config'][$i]['description'] = '_MI_SCONTENT_BCRUMBDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;

$modversion['config'][$i]['name'] = 'printlogourl';
$modversion['config'][$i]['title'] = '_MI_SCONTENT_PRINTLOGOURL';
$modversion['config'][$i]['description'] = '_MI_SCONTENT_PRINTLOGOURLDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = XOOPS_URL . '/images/logo.gif';
$i++;

$modversion['config'][$i]['name'] = 'printfooter';
$modversion['config'][$i]['title'] = '_MI_SCONTENT_PRINTFOOT';
$modversion['config'][$i]['description'] = '_MI_SCONTENT_PRINTFOOTDSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';
$i++;

$modversion['config'][$i]['name'] = 'seo_module_name';
$modversion['config'][$i]['title'] = '_MI_SCONTENT_SEOMODNAME';
$modversion['config'][$i]['description'] = '_MI_SCONTENT_SEOMODNAMEDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = $modversion['dirname'];
$i++;

$modversion['config'][$i]['name'] = 'seo_mode';
$modversion['config'][$i]['title'] = '_MI_SCONTENT_SEOMODE';
$modversion['config'][$i]['description'] = '_MI_SCONTENT_SEOMODEDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'disabled';
$modversion['config'][$i]['options'] = array('Disabled'  => 'disabled', 'Path Info' => 'pathinfo', 'URL Rewrite' => 'rewrite');
$i++;

/*
$modversion['config'][$i]['name'] = 'seo_inc_id';
$modversion['config'][$i]['title'] = '_MI_SCONTENT_SEOINCID';
$modversion['config'][$i]['description'] = '_MI_SCONTENT_SEOINCIDDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
*/
// On Update
if( ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] ) {

	// referer check
	$ref = xoops_getenv('HTTP_REFERER');
	if( $ref == '' || strpos( $ref , XOOPS_URL.'/modules/system/admin.php' ) === 0 ) {
		// Keep the values of block's options when module is updated (by nobunobu)
		include dirname( __FILE__ ) . "/include/updateblock.inc.php" ;
	}
}
?>