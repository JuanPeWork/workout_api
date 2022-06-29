<?php

namespace App\Http\Controllers;

use App\Exercise;

use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    //
    public function getExercises($training_session_id) {
        $exercise = Exercise::where(['training_session_id' => $training_session_id])->get();

        if($exercise->isEmpty()){
            $data = array(
                'status' => 'error',
                'code' => '404',
                'data' => 'No se han obtenido resultados'
            );
        } else {
            $data = array(
                'status' => 'success',
                'code' => '200',
                'data' => $exercise
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
                'name' => 'required|alpha',
                'training_session_id' => 'required|numeric',
                'sets' => 'required|numeric',
                'weight' => 'numeric|nullable',
                'max_repts' => 'required|numeric',
            ]);

            if(!$validate->fails()){

                // Creamos un objeto user
                $exercise = new Exercise();
                
                $exercise->name = $params['name'];
                $exercise->training_session_id = $params['training_session_id'];
                $exercise->sets = $params['sets'];
                $exercise->weight = $params['weight'];
                $exercise->max_repts = $params['max_repts'];

                //Guardamos los datos
                $exercise->save();

                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Ejercicio creado correctamente.'
                );

            } else {
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'Hubo un problema al validar los datos del ejercicio.',
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

    public function update($exercise_id, Request $request) {

        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

         // Validar los datos
         $validate = \Validator::make($params_array, [
            'training_session_id' => 'required|numeric',
            'name' => 'required|alpha',
            'sets' => 'numeric',
            'repts' =>'string|nullable',
            'weight' =>'numeric',
        ]);

            if(!$validate->fails()) {
                // Quitar campos que no quiero actualizar
                unset($params_array['id']);
                
                // Actualizar en base de datos
                $exercise_update = Exercise::where('id', $exercise_id)->update($params_array);

                // Devolver array con resultado
                $data = array(
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Exercise actualizado correctamente',
                    'changes' => $params_array
                );

            } else {
                $data = array(
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'Los datos enviados no son correctos',
                    'errors' => $validate->errors()
                );
            }

        return response()->json($data, $data['code']);

    }

    public function updateExerciseVolume($exercise_id, Request $request) {

        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

         // Validar los datos
         $validate = \Validator::make($params_array, [
            'repts' =>'string|nullable',
            'weight' =>'numeric',
        ]);

            if(!$validate->fails()) {
                
                // Actualizar en base de datos
                $exercise_update = Exercise::where('id', $exercise_id)->update($params_array);

                // Devolver array con resultado
                $data = array(
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Exercise actualizado correctamente',
                    'exercise' => $exercise_id,
                    'changes' => $params_array
                );

            } else {
                $data = array(
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'Los datos enviados no son correctos',
                    'changes' =>  $params_array,
                    'errors' => $validate->errors()
                );
            }

        return response()->json($data, $data['code']);

    }
}
