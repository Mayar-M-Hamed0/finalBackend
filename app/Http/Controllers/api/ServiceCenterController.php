<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\ServiceCenter;
class ServiceCenterController extends Controller
{
    use traitapi\apitrait;
   

 






//  all data for web site
public function all()
{
    $serviceCenters = ServiceCenter::with(['services' => function ($query) {
        $query->select('service_name', 'service_details');
    }])->with(['cars' => function ($query) {
        $query->select('car_name');
    }])->get();



    return response()->json($serviceCenters);
}





    public function index(){
       $this->authorize('create', ServiceCenter::class);
     $user_id = Auth::id();

    $userServices = ServiceCenter::where('user_id', $user_id)->get();

    return response()->json($userServices);
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
            'image' => 'nullable|image|max:2048',
            'location' => 'required|string',
            'services' => 'required|array', 
            'cars' => 'required|array', 
        ]);
    
        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()], 422);
        }
    
        $user_id = $request->user()->id;
    
  
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName; 
        }
    
        $serviceCenter = ServiceCenter::create([
            'user_id' => $user_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'rating' => $request->rating,
            'working_days' => $request->working_days,
            'working_hours' => $request->working_hours,
            'description' => $request->description,
            'image' => $imagePath, 
            'location' => $request->location,
        ]);
    
        $serviceCenter->services()->attach($request->input('services'));
        $serviceCenter->cars()->attach($request->input('cars'));
    
        return response()->json(['message' => 'Service center created successfully', 'data' => $serviceCenter], 201);
    }
    
//  show retutn service only created this service !!


public function show($id)
{
    $serviceCenter = ServiceCenter::with(['services' => function ($query) {
        $query->select( 'service_name', 'service_details'); // Specify 'services.id'
    }])->with(['cars' => function ($query) {
        $query->select( 'car_name'); // Specify 'cars.id'
    }])->find($id);
    // Authorize the view action against the $serviceCenter
    $this->authorize('view', $serviceCenter);

    return response()->json($serviceCenter);
}



    //  retturn single service for all user 
    public function singleitem($id)
{
    $serviceCenter = ServiceCenter::with(['services' => function ($query) {
        $query->select('service_name', 'service_details');
    }])->with(['cars' => function ($query) {
        $query->select('car_name');
    }])->find($id);


    if (!$serviceCenter) {
        return response()->json(['message' => 'مركز الخدمة غير موجود'], 404);
    }

    return response()->json($serviceCenter);
}
    

   
     public function customUpdate(Request $request, ServiceCenter $serviceCenter)
     {

        $this->authorize('create', ServiceCenter::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'rating' => 'required|numeric',
            'working_days' => 'required|string|max:255',
            'working_hours' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'location' => 'required|string',
            'services' => 'required|array', 
            'cars' => 'required|array', 
        ]);
    
  
        if($validator->fails()){
            return response()->json(['message' => "Errors", 'data' => $validator->errors()->all()], 422);
        }
    
        $imagePath = $serviceCenter->image; 
    

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName; 
        }
        
         $serviceCenter->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'rating' => $request->rating,
            'working_days' => $request->working_days,
            'working_hours' => $request->working_hours,
            'description' => $request->description,
            'image' => $imagePath, 
            
        ]);

        $serviceCenter->services()->attach($request->input('services'));
        $serviceCenter->cars()->attach($request->input('cars'));
        
         return $this->apiresponse($serviceCenter, "Service updated successfully", 200); 
     }
     

   
    public function destroy(ServiceCenter $serviceCenter)
    {
        $this->authorize('delete', $serviceCenter);
        $serviceCenter->delete();
        return $this->apiresponse($serviceCenter, "Service deleted successfully", 200); 
    }

}
