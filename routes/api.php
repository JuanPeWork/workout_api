<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//USER
Route::post('user/create', 'UserController@create');
Route::post('user/login', 'UserController@login');
Route::post('user/token', 'UserController@checkToken');
//? function Editar
//? function Leer


//WORKOUT
Route::post('user/{user_id}/workout/create', 'WorkoutController@create');
Route::get('user/{user_id}/workouts', 'WorkoutController@getUserWorkouts');
Route::get('user/{user_id}/workouts/{id}', 'WorkoutController@getWorkout');
//? function Editar
//? function Eliminar

//WORKOUT_TYPE
Route::get('workout-type/', 'WorkoutTypeController@listWorkoutType');

//TRAINING_SESSION
//! Crear
//! Leer
//? Eliminar
//? Editar

//TRAINING_SESSION_TYPE
Route::get('training-session-type/', 'TrainingSessionTypeController@listTrainingSessionType');

//Exercise
//! Crear 
//! Leer 
//? Editar
//? Eliminar

//Exercise_type
//* Leer

// Muscle Group
//? Leer