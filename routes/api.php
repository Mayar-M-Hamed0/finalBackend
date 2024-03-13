<?php


use App\Http\Controllers\api\usersController;

use App\Http\Controllers\api\ReviewController;

use App\Http\Controllers\api\ordersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// Route::post('/login', [usersController::class, 'login']);
Route::apiResource("users",usersController::class);




Route::post("login",[usersController::class,"login"]);

Route::post("logout",[usersController::class,"logout"])->middleware("auth:sanctum");

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
