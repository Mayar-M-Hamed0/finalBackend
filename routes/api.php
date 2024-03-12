<?php

use App\Http\Controllers\api\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\usersController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::get('users', function(){
//     return "helo user api";
// });

// Route::get('users', [usersController::class, 'index']);
// Route::post('users', [usersController::class, 'store']);
// Route::get('users/{id}', [usersController::class, 'show']);

