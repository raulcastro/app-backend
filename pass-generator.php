<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root."/Framework/SessionValidation.php";
	
	$session = new SessionValidation();
// 	$pass = md5($session->encryptPass("W3dd1ng003"));
	
	$encrypted_string = password_hash("topoesamor", PASSWORD_DEFAULT);
// 	$encrypted_string = crypt("F70ra@1016");
	
	echo $encrypted_string;
	    
	