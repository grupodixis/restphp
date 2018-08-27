<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
$autenticate = true;
// Autenticate and set token


if($autenticate){
    
    $availableMethods = ['post','get','put'];
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    $availableResources = ['usuario','parte','tarea','obra','compra'];
    $resources = explode("/",$_GET['PATH_INFO']);

    if ( (in_array($method , $availableMethods) ) && ( in_array($resources[0], $availableResources) ) ){
        include ('ConexionBD.php');
        include ('controllers.php');
        $response->response = 'authorized';
        $response->method = $method;
        $response->resources = $resources;
        $data=(json_decode(file_get_contents("php://input")))? json_decode(file_get_contents("php://input")):"";
        $objeto = new $resources[0];
        $response->data = $objeto->$method($data);
        echo json_encode($response , JSON_PRETTY_PRINT);    
       

    }

}else{

    $response->response= 'No authorized';
    echo json_encode($response , JSON_PRETTY_PRINT);

}
//

?>