<?php 
namespace App\Helpers;

// Funcioes JWT 
use Firebase\JWT\JWT;
// Para realizar consultas a la base de datos
use illuminate\Support\Facades\DB;
// Incluimos el modelo
use App\User;

class JwtAuth{

    
    public $key;

    public function __construct(){
        $this->key = 'KgOF8lGfFjzWNoaiKtr6hUnQ8YzCaSQt';
    }

    public function signup($email, $password) {

        // Comprobamos si existe el usuario
        $user = User::where([
            'email' => $email,
            'password' => $password
        ])->first();

        $signup = false;

        if(is_object($user)) {
            $signup = true;
        }

        // Generamos el token con los datos del usuario identificado
        if($signup) {
            $token = array(
                'sub'       => $user->id,
                'email'     => $user->email,
                'name'      => $user->name,
                'surname'   => $user->surname,
                'iat'       => time(),
                'exp'       => time() + (364 * 24 * 60 * 60)
            );

            $jwt = JWT::encode($token, $this->key, 'HS256');
            //$decoded = JWT::decode($jwt, $this->key, ['HS256']);
            
            // Devolvemos los datos decodificados o el token en funcion del parámetro
            $data = $jwt;
   
        } else {
            $data = array(
                'status' => 'error',
                'message' => 'Usuario o contraseña incorrectos.'
            );
        }

        return $data;
    }

    
    public function checkToken($jwt, $getIdentity = false) {
        
        $auth = false;

        try {
            $jwt = str_replace('"', '', $jwt);
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
            
        } catch(\UnexpectedValueException $e) {
            $auth = false;
        } catch(\DomainException $e) {
            $auth = false;
        }

        if(!empty($decoded) && is_object($decoded) && isset($decoded->sub)) {
            $auth = true;
        } else {
            $auth = false;
        }

        if($getIdentity && isset($decoded->sub)) {
            return $decoded;
        }

        return $auth;
    }

}