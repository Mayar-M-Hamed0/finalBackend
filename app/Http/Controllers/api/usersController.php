<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;



use Illuminate\Support\Facades\Hash;
use  App\Http\Requests;
class usersController extends Controller
{
// trait api 

use traitapi\apitrait;

// public function __construct(){

//      $this->middleware('auth');
//      abort(403, 'please Log In !');
// }

public function index()
{
    $users = User::all();

    if ($users->isEmpty()) {
        return "No User here !";
    } else {
        return $this->apiresponse($users, "ok", 200);
    }
}



        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                "name" => "required|min:3",
                "email" => "required|email|unique:users,email",
                'phone' => ['regex:/^01[0-2]{1}[0-9]{8}$/'],
                "image" => 'max:1000','mimes:png,jpg,jpeg',
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
        
      
        
            return $this->apiresponse($user,"ok",201);;
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
        
        if ($request->hasFile('image'))
        {
              $file      = $request->file('image');
              $filename  = $file->getClientOriginalName();
              $extension = $file->getClientOriginalExtension();
              $picture   = date('His').'-'.$filename;
              //move image to public/img folder
              $file->move(public_path('img'), $picture);
              return response()->json(["message" => "Image Uploaded Succesfully"]);
        } 

        $user->update($request->all());
    
        return   $this->apiresponse(null,"User updated succcfully",201); 

    }

   
    public function destroy(User $user)
    {
     
          $user->delete();
        return $this->apiresponse($user,"User delete succcfully",201); 
    }











   
}
