<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/registerAddress',[CustomerController::class,'storeAddress']);
Route::post('/address/index',[CustomerController::class,'allAddress']);
Route::any('/order',[OrderController::class,'store']);
Route::any('/order2',[OrderController::class,'store']);




//http://localhost/back_cake/public/api/login --PostMan--