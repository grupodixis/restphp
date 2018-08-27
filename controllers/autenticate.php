<?php
use \Firebase\JWT\JWT;


class autenticate {
	public static function post($data){
        
       // $response['valid'] =($data->token)? self::compareToken($data->token):"";
      
       $response['token'] = $data->token;
       //$response['login'] = self::login($data);
       
       try{
           $response['decode'] = self::decodeToken($data->token);
       }catch(Exception $e){
        $response['decode'] = "Invalid Token", $e->getMessage();
       }
       // $response['data'] = $data;
       // $response['server'] = apache_request_headers() ;
       /*
        if ( self::validToken($data) ) {  // SI EL TOKEN ES VALIDO
            
            $response['decodeToken'] = self::decodeToken($data->token); //DEVUELVE EL TOKEN DESCODIFICADO
        }else if( ( $data->nombreUsuario !="" ) && ( $data->pass != "" ) ) {  // SI EL TOKEN NO ES VALIDO, SI EXISTE NOMBREUSUARIO Y CONTRASEÑA
            
            $login = self::login($data); // AUTENTICO EL USUARIO Y CONTRASEÑA
                        
            if ($login['token'] !="") { // SI AUTENTICO CORRECTAMENTE
               
                $response['decodeToken'] = self::decodeToken($login['token']);  //DEVUELVE EL TOKEN DESCODIFICADO
                $response['token'] = $login['token'];
            }else{ // SI NO AUTENTICO CORRECTAMENTE 
             
                $response['response'] = "Error autenticando"; // DEVUELVE RESPUESTA DE ERROR AUTENTICANDO.
           
            }

            }else{

            $response['response'] = "Token invalido, Autentique por favor"; // DEVUELVE RESPUESTA DE ERROR DE TOKEN Y AUTENTICADO.

        }
        $response['testigo'] = "alive";*/
        return json_encode($response, JSON_PRETTY_PRINT);
    
    
    
    }
    public static function login($data){
        $nombreUsuario = ($data->nombreUsuario) ? $data->nombreUsuario : ""  ;
        $pass = ($data->pass)? $data->pass : "" ;
        $sql = "SELECT * FROM usuarios WHERE nombreUsuario = '$nombreUsuario' AND pass = '$pass'";
		$res = json_decode(run($sql));
        
        if ( $res->data[0]->idUsuario > -1 ){
			$response['token'] = self::createToken($res->data[0]);
		}else{
			$response['response'] = "Usuario no autorizado"; 
		}
		return $response;

    }

	public static function createToken($data){
		$token = array(
			"iss" => EMPRESA,
			"aud" => AUDIENCIA,
            "iat" => time(),
			"exp" => time()+150,
			"uid" => $data->idUsuario,
			"user" => $data->nombreUsuario,
			"email" => $data->email

		);
		$jwt = JWT::encode($token, KEY);
		return $jwt;
    }
    public static function compareToken($token){

        $decodeToken = self::decodeToken($token);
        $response['decode'] ="Token descodificado ". $decodeToken;
        /*
        if ( $decodeToken->exp > time() ){
            $response ['valid'] = true;
            $response ['time'] = time();
            $response ['exp'] = $decodeToken->exp;
        }else{
            $response ['valid'] = false;
            $response ['time'] = time();
            $response ['exp'] = $decodeToken->exp;
        }*/
           
        return $response;
    }

    public static function validToken($data){
        if ($data->token != ""){
       
            $decodeToken = self::decodeToken($data->token);
            if ($decodeToken->exp < time()){
                return false;
            }else{
                return true;
            }   

        }else{
        
            return false;
        }
    
        
       
    
    }
    
    public static function decodeToken($token){
        $decoded = JWT::decode($token, KEY, array('HS256'));
        return $decoded;
    }    

}

