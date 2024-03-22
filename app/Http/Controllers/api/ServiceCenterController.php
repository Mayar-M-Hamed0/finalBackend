<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\ServiceCenter;
use App\Models\CenterDayPivot;
use App\Models\Day;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ServiceCenterController extends Controller
{
    use traitapi\apitrait;

//  all data for web site
public function all()
{
    $serviceCenters = ServiceCenter::with([
        'services' => function ($query) {
            $query->select('service_name', 'service_details');
        },
        'cars' => function ($query) {
            $query->select('car_name');
        },
        'days' => function ($query) {
            $query->select('day', 'start_hour', 'end_hour', 'service_center_id');
        }
    ])->get();

    return response()->json($serviceCenters);
}



public function index()
{
    $this->authorize('create', ServiceCenter::class);
    $user_id = Auth::id();

    $userServices = ServiceCenter::with([
        'services' => function ($query) {
            $query->select('service_name', 'service_details');
        },
        'cars' => function ($query) {
            $query->select('car_name');
        },
        'days' => function ($query) {
            $query->select('day', 'start_hour', 'end_hour', 'service_center_id');
        }
    ])->where('user_id', $user_id)->get();

    return response()->json($userServices);
}


    public function store(Request $request)
    {
        $this->authorize('create', ServiceCenter::class);
    
        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'rating' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'location' => 'required|string',
            'price' => 'required',
            'services' => 'required|array',
            'cars' => 'required|array',
            'days' => 'nullable|array',
            // 'days' => 'nullable|array',
            // 'days.*.start_hour' => 'required|date_format:H:i', 
            // 'days.*.end_hour' => 'required|date_format:H:i',  
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
    


       $user_id = $request->user()->id;


        $serviceCenter = ServiceCenter::create([
            'user_id' => $user_id,
            'car_name' => $request->cars,
            'name' => $request->name,
            'phone' => $request->phone,
            'rating' => $request->rating,
            'description' => $request->description,
            'image' => $imagePath, 
            'location' => $request->location,
            'price' => $request->price,
            
        ]);

       
    foreach ($request->days as $dayData) {
        $day = Day::create([
            'day' => $dayData['day'],
            'start_hour' => $dayData['start_hour'],
            'end_hour' => $dayData['end_hour'],
            'service_center_id' => $serviceCenter->id,
        ]);
        $serviceCenter->days()->save($day);
    }

        $serviceCenter->services()->attach($request->input('services'));
        $serviceCenter->cars()->attach($request->input('cars'));
    
        return response()->json(['message' => 'Service center created successfully', 'data' => $serviceCenter], 201);
    }
    
//  show retutn service only created this service !!

public function show($id)
{
    $serviceCenter = ServiceCenter::with([
        'services' => function ($query) {
            $query->select('service_name', 'service_details');
        },
        'cars' => function ($query) {
            $query->select('car_name');
        },
        'days' => function ($query) {
            $query->select('day', 'start_hour', 'end_hour', 'service_center_id');
        }
    ])->find($id);
   
    if (!$serviceCenter) {
        return response()->json(['message' => 'مركز الخدمة غير موجود'], 404);
    }

    return response()->json($serviceCenter);
}





    //  retturn single service for all user
    public function singleitem($id)
    {
        $serviceCenter = ServiceCenter::with(['services' => function ($query) {
            $query->select('service_name', 'service_details');
        }])
        ->with(['cars' => function ($query) {
            $query->select('car_name');
        }])
        ->with('days')
        
        ->find ($id);
    
        if (!$serviceCenter) {
            return response()->json(['message' => 'مركز الخدمة غير موجود'], 404);
        }
    
        return response()->json($serviceCenter);
    }
    



     public function update(Request $request, ServiceCenter $serviceCenter)
     {
        $this->authorize('update', $serviceCenter);


         $validator = Validator::make($request->all(), [
            'cars' => 'required|array',
             'name' => 'required|string|max:255',
             'phone' => 'required|string|max:255',
             'rating' => 'required|numeric',
             'working_days' => 'required|string|max:255',
             'working_hours' => 'required|string|max:255',
             'description' => 'nullable|string',
             'image' => 'nullable|string|max:255',
             'price' => 'required',
         ]);

         if($validator->fails()){
             return response()->json(['message' => "Errors", 'data' => $validator->errors()->all()], 422);
         }

         $serviceCenter->update($request->all());
         return $this->apiresponse($serviceCenter, "Service updated successfully", 200);
     }



    public function destroy(ServiceCenter $serviceCenter)
    {
        $this->authorize('delete', $serviceCenter);
        $serviceCenter->delete();
        return $this->apiresponse($serviceCenter, "Service deleted successfully", 200);
    }


}
