<?php
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();

require_once $root.'/views/Layout_View.php';

if (isset($_SESSION['id_user'])) {
	require_once $root.'/backends/admin-backend.php';
	
	$data 					= $backend->loadBackend('add-company');
	$data['title'] 			= 'ADD COMPANY';
	$data['section'] 		= 'add-company';
	$data['template-class']  = '';
	$data['icon']			= 'fa-dashboard';
}
else
{
	require_once $root.'/backends/general.php';
	$data 					= $backend->loadBackend('mainSection');
	$data['title'] 			= 'Un Authorized';
	$data['section'] 		= 'unauthorized-page';
	$data['template-class'] = 'log-in';
}

$view 		= new Layout_View($data);
echo $view->printHTMLPage();
