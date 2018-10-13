<?php
define("ENCRYPTION_KEY", "!@#$%^&*");
include "controlLoginQueries.php";

class SessionValidation extends queriesLogin {
	/*
	* Función que encripta el password de un usuario.
	* @param	string	 $password			Contiene la contraseña del usuario.
	* @return	string	 $encrypted_string	Contiene la contraseña del usuario ya encriptada.
	*/
	function encryptPass($password) {
// 	   	$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
// 	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
// 	    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, ENCRYPTION_KEY, utf8_encode($password), MCRYPT_MODE_ECB, $iv);
	    $encrypted_string = password_hash($password, PASSWORD_DEFAULT);
	    
	    return $encrypted_string;
	    
// 	    return $encrypted_string;
	}

	/*
	* Inicia la sesión y crea las variables de la misma.
	* @param	array	 $user_data		Arreglo que contiene la información de un usuario.
	* Nota: incrementar de ser necesario dependiendo de los requerimientos del sistema.
	*/
	function login($user_data) {
		session_start();
		$_SESSION["id_user"]      = $user_data["user_id"];
		$_SESSION["type_user"]    = $user_data["type_user"];
		$_SESSION["name"]         = $user_data["FirstName"].' '.user_data['LastName'];
		header("Location: /");
		exit();
	}

	/*
	* Cierra la sesión y redirecciona al usuario al formulario de login.
	*/
	public static function logout() {
		session_start();
		$_SESSION = array();
		session_destroy();
		header("Location: /");
		exit();
	}

	/*
	* Verifica los intentos de un usuario y el rango de tiempo en que podrá hacer cierto número de ellos.
	* @param	string	 $id_user			Contiene el id del usuario.
	* @param	int	 	 $current_time		Tiempo exacto en el que el usuario intento de manera fallida entrar al sistema.
	* @return	bool	 $bool_answer		Regresará True cuando la cuenta sea bloqueada y False cuando aun pueda iniciar su session de manera exitosa.
	*/
	function checkbrute($id_user, $current_time) {
        $time_frame = $current_time + (20 * 60);

        $number_attempts = $this->query_check_attempts($id_user);
       	$attempts = $number_attempts["n_tries"];

       	if (!is_null($number_attempts["n_tries"])) {
       		if ($current_time < $number_attempts["time_tries"] OR $current_time == $number_attempts["time_tries"]) {
       			$attempts++;
       			if ($attempts > 3) {
       				$this->query_block_account($id_user);
       				$bool_answer = TRUE;
       			} else {
       				$this->query_save_attempt($attempts, $number_attempts["time_tries"], $id_user);
       				$bool_answer = FALSE;
       			}
       		} else {
       			$this->query_save_attempt($attempts, $time_frame, $id_user);
       			$bool_answer = FALSE;
       		}
       	} else {
       		$attempts = 1;
       		$this->query_save_attempt($attempts, $time_frame, $id_user);
       		$bool_answer = FALSE;
       	}

        return $bool_answer;
    }
}