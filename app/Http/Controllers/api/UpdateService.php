<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ServiceCenter;
use App\Models\Day;
use App\Models\Car;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
class UpdateService  extends Controller
{
    use traitapi\apitrait;

    public function customUpdate(Request $request, $id)
    {
        $serviceCenter = ServiceCenter::findOrFail($id);
    
        $this->authorize('update', $serviceCenter);
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'location' => 'required|string',
            'price' => 'required',
            'services' => 'required',
            'cars' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => "Errors", 'data' => $validator->errors()->all()], 422);
        }
    
        $imagePath = $serviceCenter->image;
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        }
    
        DB::table('service_centers')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'phone' => $request->phone,
                
                'description' => $request->description,
                'image' => $imagePath,
                'price' => $request->price,
            ]);

            $data=json_decode($request->days);
                foreach ($data as $dayData) {
                    $day = Day::updateOrCreate([
                        'day' => $dayData->day,
                        'start_hour' => $dayData->startTime,
                        'end_hour' => $dayData->endTime,
                        'service_center_id' => $serviceCenter->id,
                    ]);
                   
                }


                $dataCars = json_decode($request->cars);
                foreach ($dataCars as $carData) {
                    Car::updateOrCreate(
                        ['car_name' => $carData->key, 'service_center_id' => $id],
                        ['service_center_id' => $id]
                    );
                }
                
                $dataServices = json_decode($request->services);
                foreach ($dataServices as $serviceData) {
                    Service::updateOrCreate(
                        ['service_name' => $serviceData->key, 'service_center_id' => $id],
                        ['service_center_id' => $id]
                    );
                }
                

    
        return $this->apiresponse($serviceCenter, "Service updated successfully", 200);
    }


    
    

}
