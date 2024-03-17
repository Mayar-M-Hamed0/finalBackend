<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\ServiceCenter;
use Illuminate\Http\Request;

class ServiceCenterController extends Controller
{
    use traitapi\apitrait;
   
//  all data for web site
    public function all(){
        $serviceCenters = ServiceCenter::all();
        return response()->json($serviceCenters);
    }




    //  auth :sanctum (for user authentication)
    public function index(Request $request)
    {
        $this->authorize('viewAny', ServiceCenter::class);

        $user_id = $request->user()->id;
        $services = ServiceCenter::where('user_id', $user_id)->get();
    
        return response()->json($services);
    }

 
    public function store(Request $request)
    {
        $this->authorize('create', ServiceCenter::class);

        $validator = Validator::make($request->all(), [
          
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'rating' => 'required|numeric',
            'working_days' => 'required|string|max:255',
            'working_hours' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'location' => 'required|string',


            'services' => 'required|array', 
            'cars' => 'required|array', 
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $user_id = $request->user()->id;

        $serviceCenter = ServiceCenter::create([
            'user_id' => $user_id,
            'car_name' => $request->car_name,
            'name' => $request->name,
            'phone' => $request->phone,
            'rating' => $request->rating,
            'working_days' => $request->working_days,
            'working_hours' => $request->working_hours,
            'description' => $request->description,
            'image' => $request->image,
            'location' => $request->location,
        ]);
        
        
        
        $serviceCenter->services()->attach($request->input('services'));
    
        
        $serviceCenter->cars()->attach($request->input('cars'));
    
        return response()->json(['message' => 'Service center created successfully', 'data' => $serviceCenter],201);
    }

 
    public function show(ServiceCenter $serviceCenter)
    {
      
        if ($serviceCenter->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        return response()->json($serviceCenter);
    }
    

   
     public function update(Request $request, ServiceCenter $serviceCenter)
     {
         $this->authorize('update', $serviceCenter);
         $validator = Validator::make($request->all(), [
             'car_name' => 'required|string|max:255',
             'name' => 'required|string|max:255',
             'phone' => 'required|string|max:255',
             'rating' => 'required|numeric',
             'working_days' => 'required|string|max:255',
             'working_hours' => 'required|string|max:255',
             'description' => 'nullable|string',
             'image' => 'nullable|string|max:255',
         ]);
     
         if($validator->fails()){
             return response()->json(['message' => "Errors", 'data' => $validator->errors()->all()], 422);
         }
     
         $serviceCenter->update($request->all());
         return $this->apiresponse($serviceCenter, "Service updated successfully", 200); 
     }
     

   
    public function destroy(ServiceCenter $serviceCenter)
    {
        $this->authorize('update', $serviceCenter);
        $serviceCenter->delete();
        return $this->apiresponse($serviceCenter, "Service deleted successfully", 200); 
    }
    
}
