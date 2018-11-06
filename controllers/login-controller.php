<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root."/Framework/SessionValidation.php";
 
	// Se instancian las clases que se usaran para el inicio de sessión. 
	$session = new SessionValidation();
	

	// Se comprueba como primer punto la existencia de un usuario.
	$data = $session->query_check_data($_POST["email"]);

	// Verificación de existencia del usuario que se esta ingresando.
	if (empty($data)) {
		header("Location: /?m=1"); //<-- Posible Mensaje "El usuario no existe, intente de nuevo"
		exit();
	}

	// Verifica que la cuenta no este bloqueada.
	if ($data["account_available"] == "unavailable") {
		header("Location: /?m=3"); //<-- Posible Mensaje "Por seguridad esta cuenta ha quedado bloqueada, por motivos de intento de ingreso forzado."
		exit();
	}

	// Verificación de la coincidencia de la contraseña proporcionada, con la almacenada en la BD.
	if (!password_verify($_POST["password"], $data["password"])) {
		// Se inicia el proceso de bloqueo en caso de un ingreso no autorizando por medio de fuerza bruta.
		$session->checkbrute($data["detail_id"], time());
		header("Location: /?m=2"); //<-- Posible Mensaje "La contraseña no coinciden"
		exit();
	}
	// Inicializacion de las variables de sesión.
 	$session->login($data);
// $session->logout();  // Se eliminara esto, face de testeo.