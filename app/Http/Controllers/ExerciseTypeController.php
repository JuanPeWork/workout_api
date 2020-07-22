<?php

namespace App\Http\Controllers;

use App\ExerciseType;

use Illuminate\Http\Request;

class ExerciseTypeController extends Controller
{
    //
    public function listExercisesType() {
        $training_session_type = ExerciseType::all()->orderBy('id', 'asc')
        ->get();;

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
