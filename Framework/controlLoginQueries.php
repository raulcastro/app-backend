<?php 

/**
 *	Consultas para el funcionamiento del login
 *
 * 	@author		Jardiel Aban
 * 	@version    1
 */
require_once "Connection_Data.php";

class queriesLogin {

	public function MessageError ($e) {
		echo "Ha ocurrido un problema";
		exit;
	}

	/**
 	*	Esta funcion verifica si el usuario que se esta ingresando existe.
 	* @param 	String 	result 	Este valor se retorna la contraseña 
 	*							de un usuario para el inicio de sesión.
 	*/
	public function query_check_data($email) {
		require "db-connection.php";

		try {
		    $query = "SELECT user_id, password, account_available, type_user, FirstName, LastName
						FROM users
						WHERE email = ?";
		    
	        $result = $db->prepare($query);
	        $result->bindValue(1, $email);
	        $result->execute();
	    } catch (Exception $e) {
	    	  self::MessageError ($e);
	    }

	    $data = $result->fetch(PDO::FETCH_ASSOC);
		return $data;
	}

	/*
	* Bloquea la cuenta del usuario que ha exedido el número de intentos de ingreso al sistema.
	* @param	string	 $id_user	 Contiene el id del usuario que será bloqueada su cuenta.
	*/
	public function query_block_account($id_user) {
		require "db-connection.php";

		try{
			$result = $db->prepare("
									UPDATE `users`
	        						SET `account_available` = 'unavailable'
	        						WHERE `user_id` = ?
									");
			$result-> bindParam(1 , $id_user);				
			$result-> execute();
		}catch (Exception $e) {
			MessageError($e);
			exit();
		}		
	}

	/*
	* Consulta el rango de tiempo en que ha intentado el usuario ingresar al sistema y los 
	* intentos fallidos que ha realizado en ese rango.
	* @param	string	 $id_user			Contiene el id del usuario que se requiere saber sus intentos.
	* @return	array	 $attempts_data		Contiene el número de intento y el rango en que ha realizado esos intentos el usuario.
	*/
	public function query_check_attempts($id_user) {
		require "db-connection.php";

		try {
        	$result = $db->prepare("
        								SELECT `n_tries`, `time_tries` 
	        							FROM `users` 
	        							WHERE `user_id` = ?
        							");        	
        	$result->bindParam(1, $id_user);
        	$result->execute();
	    } catch (Exception $e) {
	        MessageError($e);
	        exit();
	    }

	    $attempts_data = $result->fetch(PDO::FETCH_ASSOC);
	    return $attempts_data;
	}

	/*
	* Guarda un nuevo intento fallido del usuario al tratar de ingresar al sistema.
	* @param	string    $attempts			Contiene el número de intentos fallidos de ingresar al sistema del usuario.
	* @param	string	  $current_time		Contiene el rango de tiempo que el usuario tiene para seguir intentando.
	* @param	string	  $id_user			Contiene el id del usuario.
	*/
	public function query_save_attempt($attempts, $current_time, $id_user) {
		require "db-connection.php";

		try{
			$result = $db->prepare("
									UPDATE `users`
									SET `n_tries` = ?, `time_tries` = ?
									WHERE `user_id` = ?
									");
			$result-> bindParam(1 , $attempts);
			$result-> bindParam(2 , $current_time);
			$result-> bindParam(3 , $id_user);		
			$result-> execute();
		}catch (Exception $e) {
			MessageError($e);
			exit();
		}
	}
}