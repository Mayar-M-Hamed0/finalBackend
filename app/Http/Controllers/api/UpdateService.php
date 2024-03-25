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


                $datacars = json_decode($request->cars);

// Assuming $serviceCenterId is the ID you want to match
Car::where('service_center_id', $serviceCenter->id)->delete();

// Decode JSON data from the request
$datacars = json_decode($request->cars);
foreach ($datacars as $carData) {
    $car = new Car([
        'car_name' => $carData->key,
    ]);


        $car->service_center_id = $serviceCenter->id;

    $car->save();
}

$dataServices = json_decode($request->services);

// Assuming $serviceCenterId is the ID you want to match
Service::where('service_center_id', $serviceCenter->id)->delete();

// Decode JSON data from the request
$dataservice=json_decode($request->services);
foreach ($dataservice as $serviceData) {
    $service = new Service([

        'service_name' => $serviceData->key,
    ]);

        $service->service_center_id = $serviceCenter->id;
    
    $service->save();
}





        return $this->apiresponse($serviceCenter, "Service updated successfully", 200);
    }





}
