<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\usersController;
use App\Http\Controllers\api\ReviewController;
use App\Http\Controllers\api\ServiceCenterController;
use App\Http\Controllers\api\ServiceController;
use App\Http\Controllers\api\ServiceByController;
use App\Http\Controllers\api\CarController;
use App\Http\Controllers\api\ordersController;
use App\Http\Controllers\api\AgentController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {

  Route::put('/users/{user}', [usersController::class, 'update'])->middleware('can:update,user');
  // Route::delete("users/{user}",[usersController::class,'destroy'])->middleware('can:update,user');
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

//gert the order in specific center id
Route::get("orderByServiceCenter/{id}" , [OrdersController::class,'getOrdersByServiceCenterId']);




//  agent only create 
// only agent create service can delete or update this service

Route::apiResource("service-center" , ServiceCenterController::class)->middleware(['auth:sanctum']);


// دي هتجيب السنجل  

Route::get("center/{id}" , [ServiceCenterController::class,'singleitem']);
// دا هيعرض كله
Route::get("Allservice-center" , [ServiceCenterController::class,'all']);



// بترجع كل السرفسيس الي اليوزر كريتها





// GET|HEAD        api/services .............................................................................. services.index › api\ServiceCenterController@index  
// POST            api/services .............................................................................. services.store › api\ServiceCenterController@store  
// GET|HEAD        api/services/{service} ...................................................................... services.show › api\ServiceCenterController@show  
// PUT|PATCH       api/services/{service} .................................................................. services.update › api\ServiceCenterController@update  
// DELETE          api/services/{service} ................................................................ services.destroy › api\ServiceCenterController@destroy  

Route::get("orders-archeive",[ordersController::class,"archeive"]);
Route::get("orders-archeive/{id}",[ordersController::class,"restore"]);
Route::delete("orders-archeive/{id}",[ordersController::class,"forcedelete"]);




//route for crud operations on services
// Route::apiResource('services', ServiceController::class);





//route for retrive service-center by it's including services --> pass the service iddddd
Route::resource('service-by', 'App\Http\Controllers\api\ServiceByController')->only(['show']);



//route for car CRUD
Route::resource('cars', 'App\Http\Controllers\api\CarController');


//admin apply CRUD on USER
Route::apiResource('admins', AgentController::class);
