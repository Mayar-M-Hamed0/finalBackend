<?php

use App\Http\Controllers\api\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\usersController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




<<<<<<< HEAD
=======
// Route::post('/login', [usersController::class, 'login']);
Route::apiResource("users",usersController::class);
>>>>>>> 211618027c52c73e980aa6791692ba6d3a21c61d
