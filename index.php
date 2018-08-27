<?php
error_reporting( E_ALL );
$debug = true;
//
// Opción GET :: dominio / objeto(s) / id /
// Opcion POST :: dominio / objeto / -> $data (con la informacion a insertar)
// Opcion PUT :: dominio / objeto / id / -> $data (con la informacion a actualizar)
// Opcion DELETE :: dominio / objeto / id
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$peticion = explode("/",$_GET['PATH_INFO']);
$recurso = array_shift($peticion);
$valor =array_shift($peticion);
$recursos_existentes = array('usuarios', 'obras','partes','compras','tareas','autenticate');
$metodo = strtolower($_SERVER['REQUEST_METHOD']);
$metodos_permitidos = array('post','put','get','delete');
//$data=(json_decode(file_get_contents("php://input")))? json_decode(file_get_contents("php://input")):"";
$data=json_decode(file_get_contents("php://input"));
require_once 'src/JWT.php';
// Comprobar si existe el recurso

if((!in_array($recurso, $recursos_existentes)) or (!in_array($metodo,$metodos_permitidos))) {
echo json_encode('{"error":"Recurso o metodo no permitido"}');
// Respuesta error
// parse_str(file_get_contents("php://input"),$post_vars);
// array_push($post_vars->listaTareas,"Tarea agregada por PHP");
// echo json_encode($post_vars);

}else{
    require "ConexionBD.php";
    require "controllers.php";
}