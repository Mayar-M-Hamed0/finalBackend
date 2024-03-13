<?php

use App\Http\Controllers\api\usersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// Route::post('/login', [usersController::class, 'login']);
Route::apiResource("users",usersController::class);



Route::post("login",[usersController::class,"login"]);

Route::post("logout",[usersController::class,"logout"])->middleware("auth:sanctum");
