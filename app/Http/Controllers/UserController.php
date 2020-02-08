<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\User;
use App\Helpers\JWT;

class UserController extends Controller
{
    public function create(Request $request) {
        // Obtenemos los datos por post
        $json = $request->input('json', null);
        // Generamos un array con los datos obtenidos
        $params = json_decode($json, true);

        if(!empty($params)) {

            // Validamos los datos 
            $validate = \Validator::make($params, [
                'name' => 'required|alpha',
                'surname' => 'required|alpha',
                'email' => 'required|email|unique:user',
                'password' => 'required',
            ]);

            if(!$validate->fails()){
                // Ciframos la password
                $pwd = hash('sha256', $params['password']);

                // Creamos un objeto user
                $user = new User();

                $user->name = $params['name'];
                $user->surname = $params['surname'];
                $user->email = $params['email'];
                $user->password = $pwd;
                $user->role = "ROLE_USER";

                //Guardamos los datos
                $user->save();

                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Usuario creado correctamente.'
                );

            } else {
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'Hubo un problema al validar el usuario.',
                    'errors' => $validate->errors()
                );    
            }

        } else {
            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'Los datos enviados no son correctos.'
            );
        }

        return response()->json($data, $data['code']);
    }

    public function login(Request $request) {
        $json = $request->input('json', null);

        $params = json_decode($json, true);
        
        if(!empty($params)) {
            $validator = \Validator::make($params, [
                'email' => 'required|email',
                'password' => 'required'
            ]);


            if(!$validator->fails()) {
                $pwd = hash('sha256', $params['password']);

                $jwtAuth = new \JwtAuth();
                
                $signup = $jwtAuth->signup($params['email'], $pwd);

            } else {
                $signup = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'Los datos enviados no son correctos.'
                );
            }
        } else {
            $signup = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'Los datos enviados no son correctos.'
            );
        }

        return response()->json($signup, 200);
    }

    public function update() {
        
    }

    public function forgotPassword() {
        
    }

    public function checkToken(Request $request) {

        $token = $request->header('Authorization');
        $jwtAuth = new \JwtAuth();

        $getToken = $jwtAuth->checkToken($token);
        if($getToken) {
            $data = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Acceso autorizado'
            );
        } else {
            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'El token ha caducado'
            );
        }

        return response()->json($data, $data['code']);        
    }

}
