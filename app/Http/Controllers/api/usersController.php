<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class usersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         return User::all();        

    // }
        }
        

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            "fname"=>"required|min:3",
            "lname"=>"required|min:3",
            "email" => "required|email|unique:users,email",
            "phone"=>"required|min:11",
             "image" => "required|image|mimes:jpg,jpeg,png,bmp,gif,svg,webp",
            "password"=>"required|min:8"
        ]);
        if($validator->fails()){
            return response($validator->errors()->all());
        }
        $user = User::create($request->all());
        return response($user, 201);
      
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
          $validator = Validator::make($request->all(), [
            "email"=> [Rule::unique('users')->ignore($user->id)],
             "fname"=>"required|min:3",
            "lname"=>"required|min:3",
            "phone"=>"required|min:11",
             "image" => "required|image|mimes:jpg,jpeg,png,bmp,gif,svg,webp",
            "password"=>"required|min:8"
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Errors", 'data' => $validator->errors()->all()], 422);
        }
        $user->update($request->all());
        return response()->json(['message' => "User updated succcfully", 'data' => $user], 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
          $user->delete();
        return response("Deleted", 204);
    }
}
