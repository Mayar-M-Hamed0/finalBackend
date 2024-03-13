<?php

namespace App\Http\Controllers\api;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use traitapi\apitrait;
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)){
            $user = User::where("email",$request->email)->first();
            $token = $user->createToken("personal access token")->plainTextToken;
            $user->token = $token;
            return $this->apiresponse($user,"Login succcfully",200); 
        }
        return response()->json(["user"=> "These credentials do not match our records."]);
    }
    

    public function logout(Request $request){
        if ($request->user()->currentAccessToken()->delete()){
            return response()->json(['msg' => "You have been successfully logged out!"]);
        }
        return response()->json(['msg' => "some thing went wrong"]);
    }
}
