<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

// var_dump($_SESSION);

$root = $_SERVER['DOCUMENT_ROOT'];
//echo $root;

require_once($root.'/Framework/Mysqli_Tool.php'); // to control the SQL querys
require_once($root.'/Framework/controlAccess.php');
require_once($root.'/Framework/Connection_Data.php');

$db =  new Mysqli_Tool(DB_HOST, DB_USER, DB_PASS, DB_NAME);

require_once $root.'/views/Layout_View.php';

//var_dump($_SESSION);

if (isset($_SESSION["id_user"])) 
{
	require_once $root.'/backends/admin-backend.php';
	
	$data 				= $backend->loadBackend('blog');
	$data['title'] 			= 'dashboard';
	$data['section'] 		= 'dashboard';
	$data['template-class']  = '';
	$data['icon']			= 'fa-dashboard';
} else {
	require_once $root.'/backends/general.php';
        
	$data 			= $backend->loadBackend();
	$data['title'] 		= 'Log-In';
	$data['section'] 	= 'log-in';
	$data['template-class'] = 'login-page';
}

$view = new Layout_View($data);

echo $view->printHTMLPage();
?>