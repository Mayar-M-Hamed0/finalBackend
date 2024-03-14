<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\usersController;

use App\Http\Controllers\api\ReviewController;

use App\Http\Controllers\api\ordersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {

  Route::put('/users/{user}', [usersController::class, 'update'])->middleware('can:update,user');
  Route::delete("users/{user}",[usersController::class,'destroy'])->middleware('can:update,user');
});

Route::get("alluser",[usersController::class,'index'])->middleware('auth:sanctum', 'checkrole:admin');
Route::get("users/{user}",[usersController::class,'show'])->middleware('auth:sanctum', 'checkrole:admin');;

Route::post("register",[AuthController::class,"register"]);
Route::post("login",[AuthController::class,"login"]);
Route::post("logout",[AuthController::class,"logout"])->middleware("auth:sanctum");

// 








//// Route For review /////////

Route::apiResource("reviews",ReviewController::class);
/*

 GET|HEAD        api/reviews ....... reviews.index › api\ReviewController@index
  POST            api/reviews ... reviews.store › api\ReviewController@store
  GET|HEAD        api/reviews/{review} ...... reviews.show › api\ReviewController@show
  PUT|PATCH       api/reviews/{review} ..... reviews.update › api\ReviewController@update
  DELETE          api/reviews/{review}.... reviews.destroy › api\ReviewController@destroy


  */

Route::apiResource("orders",ordersController::class);

Route::get("orders-archeive",[ordersController::class,"archeive"]);
Route::get("orders-archeive/{id}",[ordersController::class,"restore"]);
Route::delete("orders-archeive/{id}",[ordersController::class,"forcedelete"]);
