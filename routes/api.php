<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\CitizenController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\v1\ResourceController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('auth/login',[AuthController::class,'login']);
Route::post('auth/logout', [AuthController::class,'logout']);

Route::group(['prefix' => 'doctors'], function () {
    Route::get('show/{id}',[DoctorController::class,'show']);
    Route::post('store', [DoctorController::class,'store']);
    Route::delete('destroy/{id}', [DoctorController::class,'destroy']);
    Route::put('update/{id}', [DoctorController::class,'update']);

});
Route::group(['prefix' => 'citizens'], function () {
    Route::get('show/{id}',[CitizenController::class,'show']);
    Route::post('store', [CitizenController::class,'store']);
    Route::delete('destroy/{id}', [CitizenController::class,'destroy']);
    Route::put('update/{id}', [CitizenController::class,'update']);
    Route::post('passport', [CitizenController::class,'getPassport']);

});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
    Route::apiResource('citizens', CitizenController::class);
    Route::apiResource('doctors', DoctorController::class);

Route::group(['prefix' => 'resources'], function () {
    Route::get('regions',[ResourceController::class,'regions']);
    Route::get('cities',[ResourceController::class,'cities']);
    Route::get('diseases',[ResourceController::class,'diseases']);
    Route::get('users',[ResourceController::class,'users']);
});

Route::group(['prefix' => 'application'], function () {
    Route::get('/', [ApplicationController::class,'index']);
    Route::post('/store', [ApplicationController::class,'store']);
    Route::get('/show/{id}', [ApplicationController::class,'show']);
    Route::put('/update/{id}', [ApplicationController::class,'update']);
    Route::get('/check-status-application', [ApplicationController::class,'checkStatusApplication']);

    Route::put('/confirm/{id}', [ApplicationController::class,'confirm']);



    Route::get('/getCode/{phone}', [ResourceController::class,'getCode']);
    Route::post('/confirm-sms', [ResourceController::class,'confirmSms']);
});
