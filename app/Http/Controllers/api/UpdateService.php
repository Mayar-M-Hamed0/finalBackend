<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ServiceCenter;
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
            'rating' => 'required|numeric',
            'working_days' => 'required|string|max:255',
            'working_hours' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'location' => 'required|string',
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
                'rating' => $request->rating,
                'working_days' => $request->working_days,
                'working_hours' => $request->working_hours,
                'description' => $request->description,
                'image' => $imagePath,
            ]);
    
        return $this->apiresponse($serviceCenter, "Service updated successfully", 200);
    }
    

}
