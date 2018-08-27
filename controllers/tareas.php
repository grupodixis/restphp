<?php

class tarea{
	public static function get($data){
		$id = $data->id;
		$where = ($id)? "WHERE tareas.idObra in ($id)" : "where 1";
		$fields = "tareas.idTarea, tareas.nombreTarea, tareas.tiempoEstimado, obras.nombreObra, tareas.idObra, tareas.codigo";
		$inner ="INNER JOIN obras ON tareas.idObra = obras.idObra";
		$sql = "SELECT $fields FROM tareas $inner ".$where;
		return runner::run($sql);
	}
	public static function post($data){
		$idObra = $data->idObra;
		$nombreTarea = $data->nombreTarea;
		$tiempoEstimado = $data->tiempoEstimado;
		$codigo = $data->codigo;
		$sql = "INSERT INTO tareas (idObra, nombreTarea, tiempoEstimado, codigo) VALUES ('".$idObra."','".$nombreTarea."','".$tiempoEstimado."','".$codigo."')";
		if(($idObra)&&($nombreTarea)&&($tiempoEstimado)){
			if ($response['json'] = json_decode(runner::run($sql))) {
				$response['response'] ="Data inserted";
				return json_encode($response);
			}else{
				$response['response'] ="Error on inserting data";
				return json_encode($response);
			}
		}else{
			$response['response'] ="Missing Data parameters ";
			return json_encode($response);
		}
	}
	public static function put($data){
		$id = $data->idTarea;
		$idObra = $data->idObra;
		$nombreTarea = $data->nombreTarea;
		$horaInicio = $data->horaInicio;
		$horaFinal = $data->horaFinal;
		$tiempoEstimado = $data->tiempoEstimado;
		$codigo = $data->codigo;
		$sql = "UPDATE tareas SET
		nombreTarea = '$nombreTarea',
		tiempoEstimado = '$tiempoEstimado',
		codigo = '$codigo' 
		WHERE idTarea='$id'" ;
		if(($nombreTarea)&&($tiempoEstimado) && ($id)){
			if ($response['json'] = json_decode(runner::run($sql))) {
				$response['response'] ="Data updated";
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
		$id = $data->idTarea;
		if($id){
			$sql = "DELETE FROM tareas WHERE idTarea = $id";
			if ($response['json'] = json_decode(runner::run($sql))) {
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