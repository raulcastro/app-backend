<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root.'/models/Media_Model.php');
require_once($root.'/models/Layout_Model.php');
require_once $root.'/backends/admin-backend.php';
require_once $root.'/Framework/Tools.php';

if (isset($_SESSION["id_user"]))
{
    $model	= new Layout_Model();
    $data 	= $backend->loadBackend();

	// Se valida que ningún campo se encuentre vacio.
	$title = trim($_POST["title"]);
	$category = (int) $_POST['category'];

	if ($title == "") {
		header("Location: /add-entry-blog/"); //<-- Posible Mensaje "Llene todos los campos."
		exit();
	}
	try {
		// Almacenado de la actividad.
	    if ($lastId = $model->addEntryBlog($title, $category))
		{
		    header("Location: /edit-entry-blog/" . $lastId . "/" . Tools::slugify($title) . "/");
		    exit();
		}
	} catch (Exception $e) {
		echo "We got a serious problem.";
	}
}

