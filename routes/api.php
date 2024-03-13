<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\usersController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





Route::apiResource("users",usersController::class);

Route::get('/service-centers', [ServiceCenterController::class, 'index']);
Route::post('/service-centers', [ServiceCenterController::class, 'store']);
Route::get('/service-centers/{serviceCenter}', [ServiceCenterController::class, 'show']);
Route::put('/service-centers/{serviceCenter}', [ServiceCenterController::class, 'update']);
Route::delete('/service-centers/{serviceCenter}', [ServiceCenterController::class, 'destroy']);