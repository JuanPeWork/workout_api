<?php

namespace App\Http\Controllers;

use App\ExerciseType;

use Illuminate\Http\Request;

class ExerciseTypeController extends Controller
{
    //
    public function listExercisesType() {
        $exerciseType = ExerciseType::all();

        if($exerciseType->isEmpty()){
            $data = array(
                'status' => 'error',
                'code' => '404',
                'data' => 'No se han obtenido resultados'
            );
        } else {
            $data = array(
                'status' => 'success',
                'code' => '200',
                'data' => $exerciseType
            );
        }
        return response()->json($data, $data['code']);
    }
    
}
