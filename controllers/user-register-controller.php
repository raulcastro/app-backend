<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . "/Framework/controlSaveData.php";
 
	// Se instancian las clases que se usaran para el almacenado de la información. 
	$saveData = new queriesSaveData();

	// Elimina un usuario cuando se presiona el botón de accion de la lista
	if (isset($_GET["delete"])) {
		$saveData->deleteUser($_GET["delete"]);
		header("Location: /users-list/");
		exit();
	}

	// Se valida que ningún campo se encuentre vacio.
	
	$name = trim($_POST["name"]);
	$mail = trim($_POST["mail"]);
	$password = trim($_POST["password"]);
	$org = null;
	
	if ($_POST["organization"] != 0) { $org = $_POST["organization"]; }

	if ($name == "" || $mail == "") {
		header("Location: /user-register.php?m=4"); //<-- Posible Mensaje "Llene todos los campos."
		exit();
	}

	// Agrega los parametro para la actualización de la información.
	if (!isset($_GET["edit"])) {
		try {
			$pass = trim($password);
			if ($pass == "") {
				header("Location: /user-register.php?m=4"); //<-- Posible Mensaje "Llene todos los campos."
				exit();
			}
			$hashPass = md5($saveData->encryptPass($pass));
			$saveData->saveUserRegistration($hashPass, $mail, $name, $_POST["typeUser"], $org);
			header("Location: /users-list/"); //<-- Posible Mensaje "Todos los datos an sido guardados con exito."
			exit();
		} catch (Exception $e) {
			echo "Ha ocurrido un problema";
		}
	} else {
		if ($password != "") {
			$hashPass = md5($saveData->encryptPass($password));
		} else {
			$hashPass = $_POST["lastPassword"];
		}

		$saveData->updateUser($mail, $name, $_POST["typeUser"], $org, $_GET["edit"], $hashPass);
		header("Location: /users-list/"); // Posible Mensaje "Los datos ha sido actualizados con exito."
		exit();
	}
	
