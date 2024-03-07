<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserExerciseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware'=>'api','prefix'=>'auth'],function(){

    Route::post('/register',[AuthController::class,'Register']);
    Route::post('/login',[AuthController::class,'Login']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);


});



Route::group(['middleware'=>'api','prefix'=>'exercises'],function(){

    Route::get('/get',[UserExerciseController::class,'getAll']);
    Route::post('/user-exercises',[UserExerciseController::class,'store']);
    Route::get('/user-exercises',[UserExerciseController::class,'index']);


});
