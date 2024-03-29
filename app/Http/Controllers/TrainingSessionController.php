<?php

namespace App\Http\Controllers;

use App\TrainingSession;
use Illuminate\Http\Request;

class TrainingSessionController extends Controller
{
    //Obtener las sesiones de entrenamiento de la rutina
    public function getTrainingSessionWorkout($workout_id){
        $trainingSession = TrainingSession::where(['workout_id' => $workout_id]) ->orderBy('day', 'asc')->get();

        if($trainingSession->isEmpty()){
            $data = array(
                'status' => 'error',
                'code' => '404',
                'data' => 'No se han obtenido resultados'
            );
        } else {
            $data = array(
                'status' => 'success',
                'code' => '200',
                'data' => $trainingSession
            );
        }
        return response()->json($data, $data['code']);
    }

    //?Obtener una sesion de entrenamiento

    //!Create
    public function create(Request $request){

        // Obtenemos los datos por post
        $json = $request->input('json', null);
        // Generamos un array con los datos obtenidos
        $params = json_decode($json, true);

        if(!empty($params)) {

            // Validamos los datos 
            $validate = \Validator::make($params, [
                'workout_id' => 'required|numeric',
                'day' => 'required|numeric|min:1|max:7',
                'name' => 'required|alpha',
            ]);

            if(!$validate->fails()){

                // Creamos un objeto user
                $trainingSession = new TrainingSession();

                $trainingSession->workout_id = $params['workout_id'];
                $trainingSession->day = $params['day'];
                $trainingSession->session_type_id = $params['name'];

                //Guardamos los datos
                $trainingSession->save();

                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Sesión de entrenamiento creada correctamente.'
                );

            } else {
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'Hubo un problema al validar los datos de la sesión de entrenamiento.',
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

    //?Update
    //?Delete
}
