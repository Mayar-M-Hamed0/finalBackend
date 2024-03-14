<?php

namespace App\Http\Controllers\api;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{


  

    // function __construct(){
    //     $this->middleware("auth:sanctum");
    // }

    
// test api authenticate


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Review::all();
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
   // return Review::create($request->all());
   $validator = Validator::make($request->all(), [
          
    "user_id" => "required",

    "service_center_id" => "required",

    "Description" => "required"
  
   

]);
if($validator->fails()){
    return response($validator->errors()->all());
}
$review = Review::create($request->all());
return response($review, 201);
}


    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return $review;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        return $review->update($request->all());
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return "Deleted Successfully";
    }

}
