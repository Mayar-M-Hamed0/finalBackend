<?php

namespace App\Http\Controllers\api;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\ServiceCenter;
use Illuminate\Http\Request;

class ServiceCenterController extends Controller
{
    use traitapi\apitrait;
   
    public function index()
    {
        $serviceCenters = ServiceCenter::all();
        if ($serviceCenters->isEmpty()) {
            return "No Services here !";
        } else {
            return $this->apiresponse($serviceCenters, "ok", 200);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'rating' => 'required|numeric',
            'working_days' => 'required|string|max:255',
            'working_hours' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'services' => 'required|array', // Ensure services are provided as an array
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Create the service center
        $serviceCenter = ServiceCenter::create([
            'car_name' => $request->car_name,
            'name' => $request->name,
            'phone' => $request->phone,
            'rating' => $request->rating,
            'working_days' => $request->working_days,
            'working_hours' => $request->working_hours,
            'description' => $request->description,
            'image' => $request->image,
        ]);
    
        // Attach services to the service center based on the provided service IDs
        $serviceCenter->services()->attach($request->input('services'));
    
        return response()->json(['message' => 'Service center created successfully', 'data' => $serviceCenter], 201);
    }

 
    public function show(ServiceCenter $serviceCenter)
    {
       return $serviceCenter;
     }
    

   
    public function update(Request $request, ServiceCenter $serviceCenter)
    {
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
        return  $this->apiresponse($serviceCenter,"Service updated succcfully",201); 
    }

   
    public function destroy(ServiceCenter $serviceCenter)
    {
        $serviceCenter->delete();
        return $this->apiresponse($serviceCenter,"Service delete succcfully",201); 
    }
}
