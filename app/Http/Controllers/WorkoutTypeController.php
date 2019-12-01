<?php

namespace App\Http\Controllers;
use App\WorkoutType;

use Illuminate\Http\Request;

class WorkoutTypeController extends Controller
{
    public function listWorkoutType(){
        $workout_type = WorkoutType::all();

        if($workout_type->isEmpty()){
            $data = array(
                'status' => 'error',
                'code' => '404',
                'data' => 'No se han obtenido resultados'
            );
        } else {
            $data = array(
                'status' => 'success',
                'code' => '200',
                'data' => $workout_type
            );
        }
        return response()->json($data, $data['code']);
    }
}
