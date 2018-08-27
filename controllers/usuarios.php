<?php 
class usuario {
	public static function get($data) {
		$id = $data->id;
		$where = ($id)? "WHERE idUsuario = $id" : "where 1";
		$sql = "SELECT * FROM usuarios ".$where;
		return runner::run($sql);
	}
	public static function post($data) {
		$email = $data->email;
		$user = $data->user;
		$pass = $data->pass;
		$categoria = $data->categoria;
		if(($email)&&($user)&&($pass)&&($categoria)){
			$sql = "INSERT INTO usuarios (email,nombreUsuario,pass,categoria) VALUES ('$email','$user','$pass','$categoria')";

			if ($response['json'] = json_decode(runner::run($sql))) {
				$response['response'] ="Data inserted";
				return json_encode($response);
			}else{
				$response['response'] ="Error on inserting data";
				return json_encode($response);
			}
		}else{
			$response['response'] ="Missing Data parameters";
			return json_encode($response);
		}

	}
	public static function put($data) {
		$id = $data->idUsuario;
		$email = $data->email;
		$nombreUsuario = $data->nombreUsuario;
		$pass = $data->pass;
		$categoria = $data->categoria;
		$token = $data->token;
		$update = "UPDATE usuarios SET ";
		$update.=($email !="")? " email = '$email', ":"";
		$update.=($nombreUsuario !="")? " nombreUsuario = '$nombreUsuario', ":"";
		$update.=($pass !="")? " pass = '$pass', ":"";
		$update.=($categoria !="")? " categoria = '$categoria' ":"";
		$update.=($token !="")? " token = '$token' ":"";
		$where =($id)? " WHERE idUsuario = $id":"";
		$sql = $update.$where;
		$response['response'] = runner::run($sql);
		return json_encode($response);

	}
	public static function delete($data) {
		$id = $data->idUsuario;
		if($id){
			$sql = "DELETE FROM usuarios WHERE idUsuario = $id";
			if(runner::run($sql)){
				$response['response']="Data deleted";

			}else{
				$response['response'] = "Error deleting data.";
			}
			return json_encode($response);
		}else{
			$response['response'] ="Missing Data parameters";
			return json_encode($response);
		}
	}
	
}

