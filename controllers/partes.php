<?php

class parte{
	public static function get($data){
		$id = $data->id;
		$where = ($id != "")? "where partes.idObra in ($id)" : "where 1";
		$inner = "INNER JOIN obras ON partes.idObra = obras.idObra"; //ASOCIAR OBRAS
		$inner = $inner." INNER JOIN tareas ON partes.idTarea = tareas.idTarea"; // ASOCIAR TAREAS
		$inner = $inner." INNER JOIN usuarios ON partes.idUsuario = usuarios.idUsuario"; // ASOCIAR USUARIOS
		$fields = ""; //AGREGAR LOS CAMPOS QUE QUIERO SELECCIONAR DE LA BASE DE DATOS.
		$fields = $fields."partes.idParte,partes.idObra, obras.nombreObra, obras.clienteObra, partes.idTarea, tareas.nombreTarea, partes.idUsuario, usuarios.nombreUsuario,partes.inicio,partes.final, partes.observacion";
		$sql = "SELECT $fields FROM partes $inner ".$where;
		return runner::run($sql);
	}
	public static function post($data){
		$idObra = $data->idObra;
		$idTarea = $data->idTarea;
		$idUsuario =$data->idUsuario;
		$inicio = $data->inicio;
		$final = $data->final;
		$observacion = $data->observacion;
		if(($idObra)&&($idTarea)&&($inicio)){
			$sql = "INSERT INTO partes (idObra,idTarea,idUsuario,inicio,final,observacion) VALUES
				('$idObra','$idTarea','$idUsuario','$inicio','$final','$observacion')";
			$response['json'] = runner::run($sql);
			return $response['json'];

		}else{
			$response['response'] ="Missing Data parameters ";
			return json_encode($response);
		}
	}
	public static function put($data){
		$id = $data->idParte;
		$idObra = $data->idObra;
		$idTarea = $data->idTarea;
		$idUsuario =$data->idUsuario;
		$inicio = $data->inicio;
		$final = $data->final;
		$observacion = $data->observacion;
		$update = "UPDATE partes SET ";
		$update .= ($idObra !="")? " idObra = '$idObra',":"";
		$update .= ($idTarea !="")? " idTarea = '$idTarea',":"";
		$update .= ($idUsuario !="")? " idUsuario = '$idUsuario',":"";
		$update .= ($final !="")? " final = '$final', ":"";
		$update .= ($observacion !="")? " observacion = '$observacion'":"";
		if($id){
			$where = " where idParte='$id'";
			$sql = $update.$where;
			if ($response['json'] = json_decode(runner::run($sql))) {
				$response['response'] ="Data updated ";
				return json_encode($response);
			}else{
				$response['response'] ="Error updating data";
				return json_encode($response);
			}
		}else{
			$response['response'] ="Missing Data parameters ";
			return json_encode($response);
		}
	}
	public static function delete($data){
		$id = $data->idParte;
		if($id){
			$sql = "DELETE FROM partes WHERE idParte = $id";
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