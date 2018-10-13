<?php

try {
	$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME .";port=3306",DB_USER,DB_PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$db->exec("SET NAMES 'utf8'");
} catch (Exception $e) {
	echo "No se ha podido conectar";
	exit;
}

?>