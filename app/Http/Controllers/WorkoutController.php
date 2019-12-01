<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Workout;

class WorkoutController extends Controller
{
    //Obtener rutinas de un usuario
    public function getUserWorkouts($user_id){
        $workout = Workout::where(['user_id' => $user_id])->get();

        if($workout->isEmpty()){
            $data = array(
                'status' => 'error',
                'code' => '404',
                'data' => 'No se han obtenido resultados'
            );
        } else {
            $data = array(
                'status' => 'success',
                'code' => '200',
                'data' => $workout
            );
        }
        return response()->json($data, $data['code']);
    }

    //Obtener rutinas de un usuario
    public function getWorkout($id){
        $workout = Workout::where(['id' => $id])->get();

        if($workout->isEmpty()){
            $data = array(
                'status' => 'error',
                'code' => '404',
                'data' => 'No se han obtenido resultados'
            );
        } else {
            $data = array(
                'status' => 'success',
                'code' => '200',
                'data' => $workout
            );
        }
        return response()->json($data, $data['code']);
    }


    public function create(Request $request){

        // Obtenemos los datos por post
        $json = $request->input('json', null);
        // Generamos un array con los datos obtenidos
        $params = json_decode($json, true);

        if(!empty($params)) {

            // Validamos los datos 
            $validate = \Validator::make($params, [
                'user_id' => 'required|alpha_num',
                'workout_type_id' => 'required|alpha_num',
                'name' => 'required',
                'num_days' => 'required|numeric|min:1|max:7',
            ]);

            if(!$validate->fails()){

                // Creamos un objeto user
                $workout = new Workout();

                $workout->user_id = $params['user_id'];
                $workout->workout_type_id = $params['workout_type_id'];
                $workout->name = $params['name'];
                $workout->num_days = $params['num_days'];

                //Guardamos los datos
                $workout->save();

                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Rutina creada correctamente.'
                );

            } else {
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'Hubo un problema al validar los datos de la rutina.',
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

    public function update(){
        
    }

    public function delete(){
        
    }
}
