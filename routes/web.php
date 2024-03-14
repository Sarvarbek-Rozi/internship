<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitizenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get("/login",[AuthController::class,'login'])-> name("login");
Route::post("/authenticate",[AuthController::class,'authenticate'])-> name("authenticate");
Route::get("/register",[AuthController::class,'register'])-> name("register");
Route::post("/register",[AuthController::class,'register_store'])-> name("register.store");

//Route::resources(['citizens'=>CitizenController::class]);

