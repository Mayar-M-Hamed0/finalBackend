<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceCenterController extends Controller
{
    public function index()
    {
        $serviceCenters = ServiceCenter::all();
        return response()->json($serviceCenters);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'rating' => 'required|numeric',
            'working_days' => 'required|string|max:255',
            'working_hours' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $serviceCenter = ServiceCenter::create($request->all());

        return response()->json($serviceCenter, 201);
    }

    public function show(ServiceCenter $serviceCenter)
    {
        return response()->json($serviceCenter);
    }

    public function update(Request $request, ServiceCenter $serviceCenter)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'rating' => 'required|numeric',
            'working_days' => 'required|string|max:255',
            'working_hours' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $serviceCenter->update($request->all());

        return response()->json($serviceCenter, 200);
    }

    public function destroy(ServiceCenter $serviceCenter)
    {
        $serviceCenter->delete();

        return response()->json(null, 204);
    }
}
