<?php
/*
 * $Id$
 * Module: SmartContent
 * Author: Sudhaker Raj <http://xoops.biz>
 * Licence: GNU
 */
if (empty($_GET['seoOp']))
{
	// SEO mode is path-info
	/*
	Sample URL for path-info
	http://localhost/modules/smartcontent/seo.php/item.2/can-i-turn-the-ads-off.html
	*/
	$data = explode("/",$_SERVER['PATH_INFO']);

	$seoParts = explode('.', $data[1]);
	$seoOp = $seoParts[0];
	$seoArg = $seoParts[1];
	// for multi-argument modules, where itemid and catid both are required.
	// $seoArg = substr($data[1], strlen($seoOp) + 1);
}

$seoMap = array(
	'page' => 'page.php',
	'print' => 'print.php'
);

if (! empty($_GET['seoOp']) && ! empty($seoMap[$_GET['seoOp']]))
{
	// module specific dispatching logic, other module must implement as
	// per their requirements.
	$newUrl = '/modules/smartcontent/' . $seoMap[$_GET['seoOp']] . '.php';

	$_ENV['PHP_SELF'] = $newUrl;
	$_SERVER['SCRIPT_NAME'] = $newUrl;
	$_SERVER['PHP_SELF'] = $newUrl;
	switch ($_GET['seoOp']) {
		case 'category':
			$_SERVER['REQUEST_URI'] = $newUrl . '?categoryid=' . $_GET['seoArg'];
			$_GET['categoryid'] = $_GET['seoArg'];
			break;
		case 'page':
		case 'print':
		default:
			$_SERVER['REQUEST_URI'] = $newUrl . '?pageid=' . $_GET['seoArg'];
			$_GET['pageid'] = $_GET['seoArg'];
	}

	include($_GET['seoOp'] . ".php");
}

exit;

?>