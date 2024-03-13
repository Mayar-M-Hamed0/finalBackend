<?php

use App\Http\Controllers\api\ordersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\usersController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// Route::post('/login', [usersController::class, 'login']);
Route::apiResource("users",usersController::class);
Route::apiResource("orders",ordersController::class);
