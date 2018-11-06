<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . "/Framework/controlSaveData.php";
	require_once $root . '/Framework/Tools.php';
 
	// Instancia. 
	$queriesData = new queriesSaveData();

	try {
		if (isset($_GET["v"])) {
			$queriesData->deleteVideo($_GET["v"]);
		} else if (isset($_GET["d"])) {
			$queriesData->deleteDocument($_GET["d"]);
			unlink($root . '/media/documents/' . $_GET["name"]);
		}
		
		$infoActivity = $queriesData->getActivityById($_GET["c"]);
		header("Location: /edit-company/main/" . $_GET["c"] . "/" . Tools::slugify($infoActivity['name']) . "/");
		exit();
	} catch (Exception $e) {
		echo "Ocurrio un problema.";
	}
