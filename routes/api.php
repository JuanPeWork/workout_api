<?php

use Illuminate\Http\Request;

use App\Http\Middleware\ApiAuthMiddleware;
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
Route::get('user/token', 'UserController@checkToken');
Route::get('user/get-identity', 'UserController@getIdentity');
//?  function Editar
//? function Leer


//WORKOUT
Route::post('user/{user_id}/workout/create', 'WorkoutController@create')->middleware(ApiAuthMiddleware::class);
Route::get('user/{user_id}/workouts', 'WorkoutController@getUserWorkouts')->middleware(ApiAuthMiddleware::class);
Route::get('user/{user_id}/workouts/{id}', 'WorkoutController@getWorkout')->middleware(ApiAuthMiddleware::class);
//? function Editar
//? function Eliminar

//WORKOUT_TYPE
Route::get('workout-type', 'WorkoutTypeController@listWorkoutType')->middleware(ApiAuthMiddleware::class);

//TRAINING_SESSION
//! Crear
Route::post('/training-session', 'TrainingSessionController@create')->middleware(ApiAuthMiddleware::class);

//! Leer
Route::get('workouts/{workout_id}/training-session/', 'TrainingSessionController@getTrainingSessionWorkout')->middleware(ApiAuthMiddleware::class);

//? Eliminar
//? Editar

//TRAINING_SESSION_TYPE
Route::get('training-session-type', 'TrainingSessionTypeController@listTrainingSessionType')->middleware(ApiAuthMiddleware::class);

//Exercise
//! Crear 
Route::post('/exercise', 'ExerciseController@create')->middleware(ApiAuthMiddleware::class);

//! Leer
Route::get('/training-session/{training_session_id}/exercise', 'ExerciseController@getExercises')->middleware(ApiAuthMiddleware::class);

//! Editar
Route::post('/exercise/{exercise_id}', 'ExerciseController@update')->middleware(ApiAuthMiddleware::class);
Route::post('/exercise/volume/{exercise_id}', 'ExerciseController@updateExerciseVolume');

//? Eliminar

//Exercise_type
//* Leer
Route::get('/exercise-type/', 'ExerciseTypeController@listExercisesType')->middleware(ApiAuthMiddleware::class);

// Muscle Group
//? Leer
