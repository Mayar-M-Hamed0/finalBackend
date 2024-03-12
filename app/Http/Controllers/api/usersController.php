<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class usersController extends Controller
{
    public function index()
    {
    
         return User::all();        


        }
        


    public function store(Request $request)
    {
      
        $validator = Validator::make($request->all(), [
            "name"=>"required|min:3",
            "email" => "required|email|unique:users,email",
            "phone"=>"required|min:11",
         
            "image" => 'required','max:1000','mimes:png,jpg,jpeg',
            "password"=>"required|min:8"
        ]);
        if($validator->fails()){
            return response($validator->errors()->all());
        }
        $user = User::create($request->all());
        return response($user, 201);
      
    }


    public function show(User $user)
    {
       
        return $user;
    }


    public function update(Request $request, User $user)
    {
        //
          $validator = Validator::make($request->all(), [
            "email"=> [Rule::unique('users')->ignore($user->id)],
             "name"=>"required|min:3",
            "phone"=>"required|min:11",
            "image" => 'required','max:1000','mimes:png,jpg,jpeg',
            "password"=>"required|min:8"
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Errors", 'data' => $validator->errors()->all()], 422);
        }
        $user->update($request->all());
        return response()->json(['message' => "User updated succcfully", 'data' => $user], 201);

    }

   
    public function destroy(User $user)
    {
        //
          $user->delete();
        return response("Deleted", 204);
    }
}
