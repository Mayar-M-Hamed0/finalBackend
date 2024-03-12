<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class usersController extends Controller
{
// trait api 

use traitapi\apitrait;


    public function index()
    {
        
        $user = User::all();
   
         return $this->apiresponse($user,"ok",200);      


        }
        


    public function store(Request $request)
    {
      
        $validator = Validator::make($request->all(), [
            "name"=>"required|min:3",
            "email" => "required|email|unique:users,email",
            'phone' => ['required', 'regex:/^01[0-2]{1}[0-9]{8}$/'],
            "image" => 'required','max:1000','mimes:png,jpg,jpeg',
            'password' => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
        ]);
        if($validator->fails()){
            return response($validator->errors()->all());
        }
        $user = User::create($request->all());
        return $this->apiresponse($user,"ok",201);  
      
    }


    public function show(User $user)
    {
       
        return  $this->apiresponse($user,"ok",200);  
    }


    public function update(Request $request, User $user)
    {
        //
          $validator = Validator::make($request->all(), [
            "email"=> [Rule::unique('users')->ignore($user->id)],
             "name"=>"required|min:3",
             'phone' => ['required', 'regex:/^01[0-2]{1}[0-9]{8}$/'],
             "image" => 'required','max:1000','mimes:png,jpg,jpeg',
            "password"=>"required|min:8"
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Errors", 'data' => $validator->errors()->all()], 422);
        }
        $user->update($request->all());
    
        return   $this->apiresponse($user,"User updated succcfully",201); 

    }

   
    public function destroy(User $user)
    {
     
          $user->delete();
        return $this->apiresponse($user,"User delete succcfully",201); 
    }
}
