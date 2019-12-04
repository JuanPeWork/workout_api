<?php

namespace App\Http\Controllers;
use App\TrainingSessionType;

use Illuminate\Http\Request;

class TrainingSessionTypeController extends Controller
{
    // Obtener tipos de sesiones de entrenamiento
    public function listTrainingSessionType(){
        $training_session_type = TrainingSessionType::all();

        if($training_session_type->isEmpty()){
            $data = array(
                'status' => 'error',
                'code' => '404',
                'data' => 'No se han obtenido resultados'
            );
        } else {
            $data = array(
                'status' => 'success',
                'code' => '200',
                'data' => $training_session_type
            );
        }
        return response()->json($data, $data['code']);
    }
}
