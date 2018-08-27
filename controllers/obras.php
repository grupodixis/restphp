<?php

class obra{
	public static function get($data){
		$id = $data->id;
		$where = ($id) ? "WHERE idObra in ($id)" : "where 1";
		$sql = "SELECT * FROM obras ".$where;
		return runner::run($sql);
		
	}
	public static function post($data){
		$nombreObra=$data->nombreObra;
		$clienteObra=$data->clienteObra;
		$descripcion = ($data->descripcion)? $data->descripcion : "";
		if(($nombreObra )&& ($clienteObra)){
			$sql = "INSERT INTO obras (nombreObra, clienteObra, descripcion) VALUES ('".$nombreObra."', '".$clienteObra."', '".$descripcion."')";
				if ($response['json'] = json_decode(runner::run($sql))) {
					$response['response'] ="Data inserted";
					return json_encode($response);
				}else{
					$response['response'] ="Error on inserting data";
					$response['qry'] =$sql;
					return json_encode($response);
				}
		}else{
			$response['response'] ="Missing Data parameters";
			return json_encode($response);
		}
	}
	public static function put($data){
		$nombreObra=$data->nombreObra;
		$clienteObra=$data->clienteObra;
		$descripcion = ($data->descripcion)? $data->descripcion : "";
		$status = 
		$id = $data->idObra;
		if($id!=""){
			$sql = "UPDATE obras SET nombreObra = '".$nombreObra."', clienteObra = '".$clienteObra."', descripcion = '".$descripcion."' WHERE idObra ='".$id."'";
			if ($response['json'] = json_decode(runner::run($sql))){
				$response['response']="Data updated";
			}else{
				$response['response'] = "Error updating data.";
			}
			return json_encode($response);
		}else{
			$response['response'] ="Missing Data parameters";
			return json_encode($response);
		}
	}

	public static function delete($data){
		$id = $data->idObra;
		
		if($id){
			$sql = "DELETE FROM obras WHERE idObra = $id";
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
