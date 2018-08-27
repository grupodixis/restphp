<?php                                                                                                                                           
// Parte  - CRUD - 
require "datos/login_mysql.php";

//Obra -> [idsTareas]
//Tareas -> Id - Nombre - tiempoEstimado

// Tareas -> Id - Nombre - tiempoEstimado - idObra

//registro -> idParte - idObra - idTarea - inicio - final

class parte{
	// GET recibira ID o grupo de IDs.
	function get($data){
		$id = $data->id;
		$where = ($id != "")? "where idParte in ($id)" : "where 1";
		$inner = "INNER JOIN obras ON partes.idObra = obras.idObra"; //ASOCIAR OBRAS
		$inner = $inner." INNER JOIN tareas ON partes.idTarea = tareas.idTarea"; // ASOCIAR TAREAS
		$inner = $inner." INNER JOIN usuarios ON partes.idUsuario = usuarios.idUsuario"; // ASOCIAR USUARIOS
		$fields = ""; //AGREGAR LOS CAMPOS QUE QUIERO SELECCIONAR DE LA BASE DE DATOS.
		$fields = $fields."partes.fecha, partes.idObra, obras.nombreObra, obras.clienteObra, partes.idTarea, tareas.nombreTarea, partes.idUsuario, usuarios.nombreUsuario"; 
		$sql = "SELECT $fields FROM partes $inner ".$where;
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$statement->execute();
		$results=$statement->fetchAll(PDO::FETCH_OBJ);
		$json=json_encode($results, JSON_PRETTY_PRINT);
		return $json;
	}
	function post($data){
		//'$date','$end','$start','$idWork','$idTask','$idUser','$comments'
		$date=$data->date;$end=$data->end;$start=$data->start;$idWork=$data->idWork;
		$idTask=$data->idTask;$idUser=$data->idUser;$comments=$data->comments;
		$sql = "INSERT INTO partes (fecha,idObra,idTarea,idUsuario,observacion) 
		VALUES ('$date','$idWork','$idTask','$idUser','$comments')";
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$response = ($statement->execute())? "success":"Fail";
		return $response;
		
	}
	function put($data){
		$idRegistry=$data->idRegistry;$date=$data->date;$end=$data->end;$start=$data->start;
		$idWork=$data->idWork;$idTask=$data->idTask;$idUser=$data->idUser;$comments=$data->comments;
		$sql = "UPDATE partes SET 
		fecha = '$date',
		horaFinal = '$end', 
		horaInicio = '$start', 
		idObra = '$idWork', 
		idTarea = '$idTask',
		idUsuario = '$idUser',
		observacion = '$comments' where idParte = $idRegistry";
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$response = ($statement->execute())? "success":"Fail";
		return $response;
	}
	function delete($data){
		$idRegistry = $data['idRegistry'];
		$sql = "DELETE from partes where idParte = '$idRegistry'";
		$response = ($qry = mysqli_query($sql))? "Registry deleted":"Fail deleting Registry";
		return $response;
	}

}

class tarea{
	function post($data){
		$task = $data['task'];
		$sql = "INSERT INTO tareas (nombreTarea) VALUES ('".$task."')";
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$response = ($statement->execute())? "success":"Fail";
		return $response;
	}
	function put($data){
		$task = $data['task'];
		$id = $data['id'];
		$sql = "UPDATE tareas SET nombreTarea = '".$task."' WHERE idTarea='".$id."'" ;
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$response = ($statement->execute())? "success":"Fail";
		return $response;
	}
	function delete($data){
		$id = $data['id'];
		$sql = "DELETE from tareas WHERE idTarea=$id";
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$response = ($statement->execute())? "success":"Fail";
		return $response;
	}
	function get($data){
		$id = $data['id'];
		$where = ($id != "")? "where idTarea = $id" : "where 1";
		$sql = "SELECT * FROM tareas ".$where;
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$statement->execute();
		$results=$statement->fetchAll(PDO::FETCH_OBJ);
		$json=json_encode($results, JSON_PRETTY_PRINT);
		return $json;
	}
}
class obra{
	function post($data){
		$work=$data->work;
		$client=$data->client;
		$sql = "INSERT INTO obras (nombreObra, clienteObra) VALUES ('".$work."', '".$client."')";
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$response = ($statement->execute())? "success":"Fail";
		return $response;
	}
	function put($data){
		$work=$data->work;
		$client=$data->client;
		$id = $data->id;
		$sql = "UPDATE obras SET nombreObra = '".$work."', clienteObra = '".$client."' WHERE idObra ='". $id."'";
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$response = ($statement->execute())? "success":"Fail";
		return $response;
	}
	function delete($data){
		$id = $data->id;
		$sql = "DELETE FROM obras WHERE idObra = $id";
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$response = ($statement->execute())? "success":"Fail";
		return $response;
	}
	function get($data){
		$id = $data->id;
		$where = ($id)? "WHERE idObra = '$id'" : "where 1";
		$sql = "SELECT * FROM obras ".$where;
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$statement->execute();
		$results=$statement->fetchAll(PDO::FETCH_OBJ);
		$json=json_encode($results, JSON_PRETTY_PRINT);
		return $json;
	} 
}

class usuario{
	function post($data){
		$email = $data->email;
		$user = $data->user;
		$pass = $data->pass;
		$sql = "INSERT INTO usuarios (email,nombreUsuario,pass) VALUES ('$email','$user','$pass')";
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$response = ($statement->execute())? "success sign up":"Fail sign up";
		return $response;
	}
	function put($data){
		$email = $data->email;
		$user = $data->user;
		$pass = $data->pass;
		$id = $data->id;
		$sql = "UPDATE usuarios SET email = '$email', nombreUsuario = '$user', pass = '$pass' where idUsuario =$id";
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$response = ($statement->execute())? "success sign up":"Fail sign up";
		return $response;
	}
	function delete($data){
		$id = $data->id;
		$sql = "DELETE FROM usuarios WHERE idUsuario = $id";
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$response = ($statement->execute())? "User Deleted":"Delete user error";
		return $response;
	}
	function login($data){
		$user = $data->user;
		$pass = $data->pass;
		$sql = "SELECT idUsuario FROM usuarios WHERE nombreUsuario ='$user' and pass ='$pass'" ;
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$statement->execute();
		if($statement->rowCount()>= 1){
			$response ="succesful login";
		}else{
			$response= $sql. " Wrong User/pass";
		}
		return $response;
	}
	function remember($data){
		$email = $data->email;
		$sql = "SELECT * FROM usuarios WHERE email = '$email'";
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$statement->execute();

		if($statement->rowCount() >= 1){
			$fetch = $statement->fetchAll(PDO::FETCH_OBJ);
			$email = $fetch->email;
			$user =  $fetch->nombreUsuario;
			$pass = $fetch->pass;
			$subject = "Recuerdo de Usuario y contraseña";
			$message = "Usuario: $user \n Contraseña: $pass\n";
			mail($email, $subject, $message);
			$response = "Email sent! check $email";	
		}else{
			$response = "No email in the database";
		}
		return $response;
	}
	function get($data){
		$id = $data->id;
		$where = ($id)? "WHERE idUsuario = $id" : "where 1";
		$sql = "SELECT * FROM usuarios ".$where;
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$statement->execute();
		$results=$statement->fetchAll(PDO::FETCH_OBJ);
		$json=json_encode($results, JSON_PRETTY_PRINT);
		return $json;
	}
}

class compra{
	function post($data){
		$codigo = generateRandomString(5);
		$idUser = $data->idWork;
		$idWork = $data->idUser;
		$sql = "INSERT INTO compras (codigo, idObra, idUsuario) VALUES ('$codigo','$idWork','$idUser')";
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$response = ($statement->execute())? "success":"Fail";
		return $response;
	}
	function delete($data){
		$id = $data->id;
		$sql = "DELETE FROM compras WHERE idCompra= '$id'";
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$response = ($statement->execute())? "success":"Fail";
		return $response;
	}
	function get($data){
		$id = $data->id;
		$where = ($id)? "WHERE idCompra = '$id'" : "where 1";
		$sql = "SELECT * FROM compras ".$where;
		$pdo=new PDO("mysql:dbname=".BASE_DE_DATOS.";host=".NOMBRE_HOST.";",USUARIO,CONTRASENA);
		$statement=$pdo->prepare($sql);
		$statement->execute();
		$results=$statement->fetchAll(PDO::FETCH_OBJ);
		$json=json_encode($results, JSON_PRETTY_PRINT);
		return $json;
	}
}

//FUNCIONES

function generateRandomString($length = 5) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>