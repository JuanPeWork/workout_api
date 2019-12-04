<?php

namespace App\Http\Controllers;

use App\TrainingSession;
use Illuminate\Http\Request;

class TrainingSessionController extends Controller
{
    //Obtener las sesiones de entrenamiento de la rutina
    public function getTrainingSessionWorkout($workout_id){
        $trainingSession = TrainingSession::where(['workout_id' => $workout_id])->get();

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
                'data' => $workout
            );
        }
        return response()->json($data, $data['code']);
    }

    //?Obtener una sesion de entrenamiento

    //!Create
    //?Update
    //?Delete
}
