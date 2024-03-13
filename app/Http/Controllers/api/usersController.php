<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
                "name" => "required|min:3",
                "email" => "required|email|unique:users,email",
                'phone' => ['required', 'regex:/^01[0-2]{1}[0-9]{8}$/'],
                "image" => 'required','max:1000','mimes:png,jpg,jpeg',
                'password' => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            ]);
        
            if ($validator->fails()) {
                return response($validator->errors()->all());
            }
        
            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'image' => $request->image,
                'password' => Hash::make($request->password),
            ]);
        
            // Generate Sanctum token
            $token = $user->createToken("personal access token")->plainTextToken;
        
            // Attach the token to the user
            $user->token = $token;
        
            return $this->apiresponse($user, "ok", 201);
        }

    public function show($id)
    {
        $user = user::findOrFail($id);
       if($user){
        return  $this->apiresponse($user,"ok",200);
       }else{
        return  $this->apiresponse(null,"this user not found",401); 
    } 
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






// login method
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)){
            $user = User::where("email",$request->email)->first();
            $token = $user->createToken("personal access token")->plainTextToken;
            $user->token = $token;
            return response()->json(["user"=>$user]);
        }
        return response()->json(["user"=> "These credentials do not match our records."]);
    }


    // logout

    public function logout(Request $request){
        if ($request->user()->currentAccessToken()->delete()){
            return response()->json(['msg' => "You have been successfully logged out!"]);
        }
        return response()->json(['msg' => "some thing went wrong"]);
    }
}
